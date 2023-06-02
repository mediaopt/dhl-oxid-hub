<?php

namespace Mediaopt\DHL\Adapter;

use Mediaopt\DHL\Api\GKV\BankType;
use Mediaopt\DHL\Api\GKV\CDP;
use Mediaopt\DHL\Api\GKV\CommunicationType;
use Mediaopt\DHL\Api\GKV\CountryType;
use Mediaopt\DHL\Api\GKV\Economy;
use Mediaopt\DHL\Api\GKV\ExportDocPosition;
use Mediaopt\DHL\Api\GKV\ExportDocumentType;
use Mediaopt\DHL\Api\GKV\Ident;
use Mediaopt\DHL\Api\GKV\NameType;
use Mediaopt\DHL\Api\GKV\NativeAddressTypeNew;
use Mediaopt\DHL\Api\GKV\PackStationType;
use Mediaopt\DHL\Api\GKV\PDDP;
use Mediaopt\DHL\Api\GKV\PostfilialeTypeNoCountry;
use Mediaopt\DHL\Api\GKV\ReceiverNativeAddressType;
use Mediaopt\DHL\Api\GKV\ReceiverType;
use Mediaopt\DHL\Api\GKV\Serviceconfiguration;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationAdditionalInsurance;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationCashOnDelivery;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationDetailsOptional;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationDetailsPreferredDay;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationDetailsPreferredLocation;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationDetailsPreferredNeighbour;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationEndorsement;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationIC;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationVisualAgeCheck;
use Mediaopt\DHL\Api\GKV\Shipment;
use Mediaopt\DHL\Api\GKV\ShipmentDetailsTypeType;
use Mediaopt\DHL\Api\GKV\ShipmentItemType;
use Mediaopt\DHL\Api\GKV\ShipmentNotificationType;
use Mediaopt\DHL\Api\GKV\ShipmentService;
use Mediaopt\DHL\Api\GKV\ShipperType;
use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Model\MoDHLNotificationMode;
use Mediaopt\DHL\Model\MoDHLService;
use Mediaopt\DHL\ServiceProvider\Branch;
use Mediaopt\DHL\ServiceProvider\Currency;
use Mediaopt\DHL\Shipment\BillingNumber;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Core\Registry;
use Mediaopt\DHL\ServiceProvider\CountriesLanguages;
use OxidEsales\Eshop\Application\Model\State;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

/**
 * This class transforms an Order object into a Shipment object.
 *
 * @author Mediaopt GmbH
 */
class GKVShipmentBuilder extends BaseShipmentBuilder
{

    /**
     * @param Order $order
     * @return Shipment
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    public function build(Order $order)
    {
        $shipment = new Shipment($this->buildShipmentDetails($order), $this->buildShipper(), $this->buildReceiver($order));
        $shipment->setExportDocument($this->buildExportDocument($order));
        $shipment->setReturnReceiver($this->buildReturnReceiver());
        return $shipment;
    }

    /**
     * @param Order $order
     * @return ShipmentDetailsTypeType
     */
    protected function buildShipmentDetails(Order $order): ShipmentDetailsTypeType
    {
        $details = new ShipmentDetailsTypeType($this->getProcess($order)->getServiceIdentifier(), $this->buildAccountNumber($order), $this->buildShipmentDate(), $this->buildShipmentItem($order));
        if (Registry::getConfig()->getShopConfVar('mo_dhl__beilegerretoure_active') && $this->getProcess($order)->supportsDHLRetoure() && $returnBookingNumber = $this->buildReturnAccountNumber($order)) {
            $details->setReturnShipmentAccountNumber($returnBookingNumber);
        }
        if ($this->sendNotificationAllowed($order)) {
            $details->setNotification(new ShipmentNotificationType($order->getFieldData('oxbillemail')));
        }
        $customerReference = Registry::getLang()->translateString('GENERAL_ORDERNUM') . ' ' . $order->getFieldData('oxordernr');
        if ($order->moDHLUsesService(MoDHLService::MO_DHL__CASH_ON_DELIVERY) && $this->getProcess($order)->supportsCashOnDelivery()) {
            $accountOwner = Registry::getConfig()->getShopConfVar('mo_dhl__cod_accountOwner') ?: null;
            $bankName = Registry::getConfig()->getShopConfVar('mo_dhl__cod_bankName') ?: null;
            $iban = Registry::getConfig()->getShopConfVar('mo_dhl__cod_iban') ?: null;
            $details->setBankData((new BankType($accountOwner, $bankName, $iban))->setNote1($customerReference));
        }
        $details->setCustomerReference($customerReference);
        $details->setService($this->buildService($order));
        return $details;
    }

    /**
     * @param Order $order
     * @return ReceiverType
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildReceiver($order): ReceiverType
    {
        $receiver = new ReceiverType(
            $this->convertSpecialChars($order->moDHLGetAddressData('fname'))
            . ' ' . $this->convertSpecialChars($order->moDHLGetAddressData('lname'))
        );
        if (Branch::isPackstation($order->moDHLGetAddressData('street'))) {
            $receiver->setPackstation($this->buildPackstation($order));
        } else if (Branch::isFiliale($order->moDHLGetAddressData('street'))) {
            $receiver->setPostfiliale($this->buildPostfiliale($order));
        } else {
            $receiver->setAddress($this->buildAddress($order));
            $receiver->setCommunication($this->buildCommunication($order));
        }
        return $receiver;
    }

    /**
     * @param Order $order
     * @return CommunicationType
     */
    protected function buildCommunication($order)
    {
        return (new CommunicationType())
            ->setContactPerson($order->moDHLGetAddressData('fname') . ' ' . $order->moDHLGetAddressData('lname'))
            ->setEmail($order->getFieldData('oxbillemail'))
            ->setPhone($order->moDHLGetAddressData('fon'));
    }

    /**
     * @param string|null $stateId
     * @return string|null
     */
    protected function getStateName(?string $stateId)
    {
        if (is_null($stateId)) {
            return null;
        }

        $state = \oxNew(State::class);
        $state->load($stateId);
        return $state->getFieldData('oxisoalpha2');
    }

    /**
     * @param string $countryId
     * @return CountryType
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildCountry($countryId)
    {
        $country = \oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
        $country->load($countryId);
        return new CountryType($country->getFieldData('oxisoalpha2'));
    }

    /**
     * @param Order $order
     * @return BillingNumber
     */
    protected function buildAccountNumber(Order $order): BillingNumber
    {
        return new BillingNumber($this->getEkp($order), $this->getProcess($order), $this->getParticipation($order));
    }

    /**
     * @param Order $order
     * @return BillingNumber|null
     */
    public function buildReturnAccountNumber(Order $order)
    {
        if (!$this->getReturnProcess($order)) {
            return null;
        }
        return new BillingNumber($this->getEkp($order), $this->getReturnProcess($order), $this->getParticipation($order));
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function buildShipmentDate(): string
    {
        $wunschpaket = Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        return $wunschpaket->getWunschpaket()->getTransferDay()->format('Y-m-d');
    }

    /**
     * @param Order $order
     * @return ShipmentItemType
     */
    protected function buildShipmentItem(Order $order): ShipmentItemType
    {
        return new ShipmentItemType($this->calculateWeight($order));
    }

    /**
     * @param Order $order
     * @return ShipmentService
     */
    private function buildService(Order $order): ShipmentService
    {
        $service = new ShipmentService();
        $process = $this->getProcess($order);
        $remark = $order->oxorder__oxremark->value;
        $wunschpaket = Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        if ($wunschpaket->hasWunschtag($remark) && $process->supportsPreferredDay()) {
            $wunschtag = $wunschpaket->extractWunschtag($remark);
            $wunschtag = date('Y-m-d', strtotime($wunschtag));
            $service->setPreferredDay(new ServiceconfigurationDetailsPreferredDay(1, $wunschtag));
        }
        [$type, $locationPart1, $locationPart2] = $wunschpaket->extractLocation($remark);
        if ($wunschpaket->hasWunschnachbar($remark) && $process->supportsPreferredNeighbour()) {
            $service->setPreferredNeighbour(new ServiceconfigurationDetailsPreferredNeighbour(1, "$locationPart2, $locationPart1"));
        }
        if ($wunschpaket->hasWunschort($remark) && $process->supportsPreferredLocation()) {
            $service->setPreferredLocation(new ServiceconfigurationDetailsPreferredLocation(1, $locationPart1));
        }
        if ($process->supportsParcelOutletRouting()) {
            $isActive = (int) Registry::getConfig()->getShopConfVar('mo_dhl__filialrouting_active');
            $altEmail = Registry::getConfig()->getShopConfVar('mo_dhl__filialrouting_alternative_email') ?: null;
            $service->setParcelOutletRouting(new ServiceconfigurationDetailsOptional($isActive, $altEmail));
        }
        if ($order->moDHLUsesService(MoDHLService::MO_DHL__IDENT_CHECK) && $process->supportsIdentCheck()) {
            $service->setIdentCheck(new ServiceconfigurationIC($this->createIdent($order), true));
        } elseif ($order->moDHLUsesService(MoDHLService::MO_DHL__VISUAL_AGE_CHECK18) && $process->supportsVisualAgeCheck()) {
            $service->setVisualCheckOfAge(new ServiceconfigurationVisualAgeCheck(true, 'A18'));
        } elseif ($order->moDHLUsesService(MoDHLService::MO_DHL__VISUAL_AGE_CHECK16) && $process->supportsVisualAgeCheck()) {
            $service->setVisualCheckOfAge(new ServiceconfigurationVisualAgeCheck(true, 'A16'));
        }
        if ($process->supportsBulkyGood()) {
            $service->setBulkyGoods(new Serviceconfiguration((int) $order->moDHLUsesService(MoDHLService::MO_DHL__BULKY_GOOD)));
        }
        if ($process->supportsCashOnDelivery()) {
            $active = (int) $order->moDHLUsesService(MoDHLService::MO_DHL__CASH_ON_DELIVERY);
            $service->setCashOnDelivery(new ServiceconfigurationCashOnDelivery($active, $this->getEURPrice($order, $order->oxorder__oxtotalordersum->value)));
        }
        $orderBrutSum = $this->getEURPrice($order, $order->oxorder__oxtotalbrutsum->value);
        if ($process->supportsAdditionalInsurance()) {
            $active = (int) ($order->moDHLUsesService(MoDHLService::MO_DHL__ADDITIONAL_INSURANCE) && $orderBrutSum > 500);
            $service->setAdditionalInsurance(new ServiceconfigurationAdditionalInsurance($active, $orderBrutSum));
        }
        if ($process->supportsPremium()) {
            $active = (bool) ($order->moDHLUsesService(MoDHLService::MO_DHL__PREMIUM));
            $service->setPremium(new Serviceconfiguration($active));
        }
        if ($process->supportsCDP()) {
            $active = (bool) ($order->moDHLUsesService(MoDHLService::MO_DHL__CDP));
            $service->setCDP(new CDP($active));
        }
        if ($process->supportsEconomy()) {
            $active = (bool) ($order->moDHLUsesService(MoDHLService::MO_DHL__ECONOMY));
            $service->setEconomy(new Economy($active));
        }
        if ($process->supportsEndorsement()) {
            $abandonment = (bool) ($order->moDHLUsesService(MoDHLService::MO_DHL__ENDORSEMENT));
            $service->setEndorsement(new ServiceconfigurationEndorsement(true, $abandonment ? MoDHLService::MO_DHL__ENDORSEMENT_ABANDONMENT : MoDHLService::MO_DHL__ENDORSEMENT_IMMEDIATE));
        }
        if ($process->supportsPDDP()) {
            $active = (bool) ($order->moDHLUsesService(MoDHLService::MO_DHL__PDDP));
            $service->setPDDP(new PDDP($active));
        }
        if ($process->supportsNoNeighbourDelivery()) {
            $isActive = (int) Registry::getConfig()->getShopConfVar('mo_dhl__no_neighbour_delivery_active');
            $service->setNoNeighbourDelivery(new Serviceconfiguration($isActive));
        }
        if ($process->supportsNamedPersonOnly()) {
            $isActive = $order->moDHLUsesService(MoDHLService::MO_DHL__NAMED_PERSON_ONLY);
            $service->setNamedPersonOnly(new Serviceconfiguration($isActive));
        }
        return $service;
    }

    /**
     * @param Order $order
     * @return Ident
     */
    protected function createIdent(Order $order) : Ident
    {
        $ident = new Ident(
            $order->moDHLGetAddressData('lname'),
            $order->moDHLGetAddressData('fname'),
            $order->getFieldData('mo_dhl_ident_check_birthday'),
            Registry::getConfig()->getShopConfVar('mo_dhl__ident_check_min_age')
            ? 'A' . Registry::getConfig()->getShopConfVar('mo_dhl__ident_check_min_age')
            : null);
        if ($order->moDHLUsesService(MoDHLService::MO_DHL__VISUAL_AGE_CHECK18)) {
            $ident->setMinimumAge('A18');
        } elseif ($order->moDHLUsesService(MoDHLService::MO_DHL__VISUAL_AGE_CHECK16) && !$ident->getMinimumAge()) {
            $ident->setMinimumAge('A16');
        }
        return $ident;
    }

    /**
     * @return ShipperType
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    protected function buildReturnReceiver(): ShipperType
    {
        $config = Registry::getConfig();
        if ($config->getShopConfVar('mo_dhl__retoure_receiver_use_sender')) {
            return $this->buildShipper();
        }
        $name = new NameType($config->getShopConfVar('mo_dhl__retoure_receiver_line1'), $config->getShopConfVar('mo_dhl__retoure_receiver_line2'), $config->getShopConfVar('mo_dhl__retoure_receiver_line3'));
        $iso2 = $this->getIsoalpha2FromIsoalpha3($config->getShopConfVar('mo_dhl__retoure_receiver_country'));
        $country = new CountryType($iso2);
        $address = new NativeAddressTypeNew($config->getShopConfVar('mo_dhl__retoure_receiver_street'), $config->getShopConfVar('mo_dhl__retoure_receiver_street_number'), $config->getShopConfVar('mo_dhl__retoure_receiver_zip'), $config->getShopConfVar('mo_dhl__retoure_receiver_city'), $country);
        return new ShipperType($name, $address);
    }

    /**
     * @return ShipperType
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    protected function buildShipper(): ShipperType
    {
        $config = Registry::getConfig();

        $name = new NameType(
            $this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_line1')),
            $this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_line2')),
            $this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_line3'))
        );
        $iso2 = $this->getIsoalpha2FromIsoalpha3($config->getShopConfVar('mo_dhl__sender_country'));
        $country = new CountryType($iso2);
        $address = new NativeAddressTypeNew(
            $this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_street')),
            $config->getShopConfVar('mo_dhl__sender_street_number'),
            $config->getShopConfVar('mo_dhl__sender_zip'),
            $this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_city')),
            $country
        );
        return new ShipperType($name, $address);
    }

    /**
     * @param Order $order
     * @return PostfilialeTypeNoCountry
     */
    private function buildPostfiliale(Order $order): PostfilialeTypeNoCountry
    {
        return new PostfilialeTypeNoCountry($order->moDHLGetAddressData('streetnr'), $order->moDHLGetAddressData('addinfo'), $order->moDHLGetAddressData('zip'), $order->moDHLGetAddressData('city'));
    }

    /**
     * @param Order $order
     * @return PackStationType
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildPackstation(Order $order): PackStationType
    {
        return new PackStationType($order->moDHLGetAddressData('addinfo'), $order->moDHLGetAddressData('streetnr'), $order->moDHLGetAddressData('zip'), $order->moDHLGetAddressData('city'), null, $this->buildCountry($order->moDHLGetAddressData('countryid')));
    }

    /**
     * @param Order $order
     * @return ReceiverNativeAddressType
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildAddress(Order $order): ReceiverNativeAddressType
    {
        $address = new ReceiverNativeAddressType(
            $order->moDHLGetAddressData('company')
                ? $this->convertSpecialChars($order->moDHLGetAddressData('company'))
                : null,
            $order->moDHLGetAddressData('addinfo')
                ? $this->convertSpecialChars($order->moDHLGetAddressData('addinfo'))
                : null,
            $this->convertSpecialChars($order->moDHLGetAddressData('street')),
            $order->moDHLGetAddressData('streetnr'),
            $order->moDHLGetAddressData('zip'),
            $this->convertSpecialChars($order->moDHLGetAddressData('city')),
            $this->getStateName($order->moDHLGetAddressData('stateid')) ?: null,
            $this->buildCountry($order->moDHLGetAddressData('countryid'))
        );
        return $address;
    }

    /**
     * @param Order $order
     * @return bool
     */
    protected function sendNotificationAllowed(Order $order): bool
    {
        if (!$this->getProcess($order)->supportsNotification()) {
            return false;
        }
        switch (Registry::getConfig()->getShopConfVar('mo_dhl__notification_mode')) {
            case MoDHLNotificationMode::NEVER:
                return false;
            case MoDHLNotificationMode::ALWAYS:
                return true;
            default:
                return (bool)$order->getFieldData('MO_DHL_ALLOW_NOTIFICATION');
        }
    }

    /**
     * @param Order $order
     */
    protected function buildExportDocument(Order $order)
    {
        if (!$this->isInternational($order)) {
            return null;
        }
        $config = Registry::getConfig();
        $exportDocumentType = (new ExportDocumentType(
            'COMMERCIAL_GOODS',
            $this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_city'))
        ))->setAdditionalFee($this->getEURPrice($order, $order->oxorder__oxdelcost->value));

        $iso2 = $this->getIsoalpha2FromIsoalpha3($config->getShopConfVar('mo_dhl__sender_country'));

        $receiverLanguages = $this->getReceiverLanguages($order);

        $exportDocuments = [];

        /** @var OrderArticle $orderArticle */
        foreach ($order->getOrderArticles() as $orderArticle) {
            $count = $orderArticle->getFieldData('oxamount');
            $exportDocuments[] = new ExportDocPosition(
                $this->getArticleTitle($orderArticle, $receiverLanguages),
                $iso2,
                $orderArticle->getArticle()->getFieldData(MoDHLService::MO_DHL__ZOLLTARIF),
                $count,
                $this->getArticleWeight($orderArticle, $config),
                $this->getEURPrice($order, $orderArticle->getPrice()->getPrice())
            );
        }

        return $exportDocumentType->setExportDocPosition($exportDocuments);
    }

    /**
     * @param string $isoalpha3
     * @return false|string
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    protected function getIsoalpha2FromIsoalpha3($isoalpha3) {
        return \OxidEsales\Eshop\Core\DatabaseProvider::getDb()
            ->getOne('SELECT OXISOALPHA2 from oxcountry where OXISOALPHA3 = ? ', [$isoalpha3]);
    }

    /**
     * @param Order $order
     * @param float $price
     * @return float
     */
    protected function getEURPrice(Order $order, float $price): float
    {
        if ($order->oxorder__oxcurrency->value === Currency::MO_DHL__EUR) {
            return $price;
        }

        return round($price / $order->oxorder__oxcurrate->value, 2);
    }

    /**
     * @param Order $order
     * @return array
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function getReceiverLanguages(Order $order): array
    {
        $receiverCountryISO2 = strtolower(
            $this->buildCountry($order->moDHLGetAddressData('countryid'))->getCountryISOCode()
        );

        $storeLanguages = [];
        foreach (Registry::getLang()->getLanguageArray() as $language) {
            $storeLanguages[$language->oxid] = $language->id;
        }

        if (!array_key_exists($receiverCountryISO2, CountriesLanguages::$LIST)) {
            // If we have no list of languages for receiver country we will use default language
            return [];
        }

        $receiverLanguages = [];
        foreach (CountriesLanguages::$LIST[$receiverCountryISO2] as $language) {
            if (array_key_exists($language, $storeLanguages)) {
                $receiverLanguages[$language] = $storeLanguages[$language];
            }
        }

        // If we have a list we will use receiver languages in order from CountriesLanguages
        return $receiverLanguages;
    }

    /**
     * @param OrderArticle $orderArticle
     * @param array $receiverLanguages
     * @return false|string
     */
    protected function getArticleTitle(OrderArticle $orderArticle, array $receiverLanguages)
    {
        $articleId = $orderArticle->getArticle()->getId();
        $articleModel = oxNew(\OxidEsales\EshopCommunity\Application\Model\Article::class);

        $title = '';
        foreach ($receiverLanguages as $languageId) {
            $articleModel->loadInLang($languageId, $articleId);
            $title = $articleModel->getFieldData('oxtitle');
            if (!empty($title)) {
                break;
            }
        }

        if (empty($title)) {
            $title = $orderArticle->getArticle()->getFieldData('oxtitle');
        }

        return mb_substr($this->convertSpecialChars($title), 0, 50);
    }

    /**
     * @param string $string
     * @return string
     */
    public static function convertSpecialChars($string = ''): string
    {
        return html_entity_decode($string);
    }
}
