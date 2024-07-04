<?php

namespace Mediaopt\DHL\Adapter;

use Mediaopt\DHL\Api\ParcelShipping\Model\BankAccount;
use Mediaopt\DHL\Api\ParcelShipping\Model\Commodity;
use Mediaopt\DHL\Api\ParcelShipping\Model\ContactAddress;
use Mediaopt\DHL\Api\ParcelShipping\Model\CustomsDetails;
use Mediaopt\DHL\Api\ParcelShipping\Model\Shipment;
use Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentDetails;
use Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentOrderRequest;
use Mediaopt\DHL\Api\ParcelShipping\Model\Shipper;
use Mediaopt\DHL\Api\ParcelShipping\Model\Value;
use Mediaopt\DHL\Api\ParcelShipping\Model\VAS;
use Mediaopt\DHL\Api\ParcelShipping\Model\VASCashOnDelivery;
use Mediaopt\DHL\Api\ParcelShipping\Model\VASDhlRetoure;
use Mediaopt\DHL\Api\ParcelShipping\Model\VASIdentCheck;
use Mediaopt\DHL\Api\ParcelShipping\Model\Weight;
use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Export\CsvExporter;
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
class ParcelShippingRequestBuilder extends BaseShipmentBuilder
{

    const STANDARD_GRUPPENPROFIL = 'STANDARD_GRUPPENPROFIL';

    /**
     * @param string[] $orderIds
     * @return array
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function build(array $orderIds): array
    {
        $shipments = array_map([$this, 'buildShipment'], $orderIds);
        $shipmentOrderRequest = new ShipmentOrderRequest();
        $shipmentOrderRequest->setShipments($shipments);
        $shipmentOrderRequest->setProfile(self::STANDARD_GRUPPENPROFIL);
        return [$this->buildQueryParameters(), $shipmentOrderRequest];
    }

    /**
     * @param string $orderId
     * @return Shipment
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    public function buildShipment(string $orderId)
    {
        $order = \oxNew(Order::class);
        $order->load($orderId);
        $shipment = new Shipment();
        $shipment->setShipper($this->buildShipper());
        $shipment->setConsignee($this->buildReceiver($order));
        $shipment->setDetails($this->buildShipmentDetails($order));
        $shipment->setCreationSoftware(CsvExporter::CREATOR_TAG);
        if ($this->isInternational($order)) {
            $shipment->setCustoms( $this->buildExportDocument($order));
        }
        $shipment->setBillingNumber($this->buildAccountNumber($order));
        $shipment->setProduct($this->getProcess($order)->getServiceIdentifier());
        $customerReference = Registry::getLang()->translateString('GENERAL_ORDERNUM') . ' ' . $order->getFieldData('oxordernr');
        $shipment->setRefNo($customerReference);
        $shipment->setServices($this->buildService($order));
        $shipment->setShipDate($this->buildShipmentDate());
        return $shipment;
    }

    /**
     * @param Order $order
     * @return ShipmentDetails
     */
    protected function buildShipmentDetails(Order $order): ShipmentDetails
    {
        $shipmentDetails = new ShipmentDetails();
        $weight = new Weight();
        $weight->setUom('kg');
        $weight->setValue($this->calculateWeight($order));
        $shipmentDetails->setWeight($weight);
        return $shipmentDetails;
    }

    /**
     * @param Order $order
     * @return array
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildReceiver($order): array
    {
        $name = $this->convertSpecialChars($order->moDHLGetAddressData('fname'))
            . ' ' . $this->convertSpecialChars($order->moDHLGetAddressData('lname'));
        if (Branch::isPackstation($order->moDHLGetAddressData('street'))) {
            return array_filter([
                'city'       => $order->moDHLGetAddressData('city'),
                'lockerID'   => $order->moDHLGetAddressData('streetnr'),
                'postalCode' => $order->moDHLGetAddressData('zip'),
                'postNumber' => $order->moDHLGetAddressData('addinfo'),
                'name'       => $name,
                'country'    => $this->buildCountry($order->moDHLGetAddressData('countryid')),
            ]);
        } else if (Branch::isFiliale($order->moDHLGetAddressData('street'))) {
            return array_filter([
                'city'       => $order->moDHLGetAddressData('city'),
                'name'       => $name,
                'postalCode' => $order->moDHLGetAddressData('zip'),
                'retailID'   => $order->moDHLGetAddressData('streetnr'),
                'postNumber' => $order->moDHLGetAddressData('addinfo'),
                'country'    => $this->buildCountry($order->moDHLGetAddressData('countryid')),
            ]);
        } else {
            return array_filter([
                'name1'         => $name,
                'name2'         => $order->moDHLGetAddressData('company')
                    ? $this->convertSpecialChars($order->moDHLGetAddressData('company'))
                    : null,
                'name3'         => $order->moDHLGetAddressData('addinfo')
                    ? $this->convertSpecialChars($order->moDHLGetAddressData('addinfo'))
                    : null,
                'state'         => $this->getStateName($order->moDHLGetAddressData('stateid')) ?: null,
                'contactName'   => $name,
                'phone'         => $order->moDHLGetAddressData('fon'),
                'email'         => $this->sendNotificationAllowed($order) ? $order->getFieldData('oxbillemail') : null,
                'city'          => $this->convertSpecialChars($order->moDHLGetAddressData('city')),
                'postalCode'    => $order->moDHLGetAddressData('zip'),
                'addressStreet' => $this->convertSpecialChars($order->moDHLGetAddressData('street')),
                'addressHouse'  => $order->moDHLGetAddressData('streetnr'),
                'country'       => $this->buildCountry($order->moDHLGetAddressData('countryid')),
            ]);
        }
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
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildCountry($countryId): string
    {
        $country = \oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
        $country->load($countryId);
        return $country->getFieldData('oxisoalpha3');
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
     * @return \DateTime
     * @throws \Exception
     */
    protected function buildShipmentDate(): \DateTime
    {
        $wunschpaket = Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        return $wunschpaket->getWunschpaket()->getTransferDay();
    }

    private function buildService(Order $order): ?VAS
    {
        $services = new VAS();
        $initialized = false;

        $process = $this->getProcess($order);
        $remark = $order->oxorder__oxremark->value;
        $wunschpaket = Registry::get(\Mediaopt\DHL\Wunschpaket::class);

        if ($wunschpaket->hasWunschtag($remark) && $process->supportsPreferredDay()) {
            $wunschtag = $wunschpaket->extractWunschtag($remark);
            $wunschtag = date('Y-m-d', strtotime($wunschtag));
            $services->setPreferredDay(new \DateTime($wunschtag));
            $initialized = true;
        }
        [$type, $locationPart1, $locationPart2] = $wunschpaket->extractLocation($remark);
        if ($wunschpaket->hasWunschnachbar($remark) && $process->supportsPreferredNeighbour()) {
            $services->setPreferredNeighbour("$locationPart2, $locationPart1");
            $initialized = true;
        }
        if ($wunschpaket->hasWunschort($remark) && $process->supportsPreferredLocation()) {
            $services->setPreferredLocation($locationPart1);
            $initialized = true;
        }
        if ($process->supportsParcelOutletRouting() && (int)Registry::getConfig()->getShopConfVar('mo_dhl__filialrouting_active')) {
            $altEmail = Registry::getConfig()->getShopConfVar('mo_dhl__filialrouting_alternative_email') ?: '';
            $services->setParcelOutletRouting($altEmail);
            $initialized = true;
        }
        if ($order->moDHLUsesService(MoDHLService::MO_DHL__IDENT_CHECK) && $process->supportsIdentCheck()) {
            $services->setIdentCheck($this->createIdent($order));
            $initialized = true;
        } elseif ($order->moDHLUsesService(MoDHLService::MO_DHL__VISUAL_AGE_CHECK18) && $process->supportsVisualAgeCheck()) {
            $services->setVisualCheckOfAge('A18');
            $initialized = true;
        } elseif ($order->moDHLUsesService(MoDHLService::MO_DHL__VISUAL_AGE_CHECK16) && $process->supportsVisualAgeCheck()) {
            $services->setVisualCheckOfAge('A16');
            $initialized = true;
        }
        if ($process->supportsBulkyGood() && $order->moDHLUsesService(MoDHLService::MO_DHL__BULKY_GOOD)) {
            $services->setBulkyGoods(true);
            $initialized = true;
        }
        if ($process->supportsCashOnDelivery() && $order->moDHLUsesService(MoDHLService::MO_DHL__CASH_ON_DELIVERY)) {
            $customerReference = Registry::getLang()->translateString('GENERAL_ORDERNUM') . ' ' . $order->getFieldData('oxordernr');
            $bankAccount = new BankAccount();
            $bankAccount->setAccountHolder(Registry::getConfig()->getShopConfVar('mo_dhl__cod_accountOwner'));
            $bankAccount->setBankName(Registry::getConfig()->getShopConfVar('mo_dhl__cod_bankName'));
            $bankAccount->setIban(Registry::getConfig()->getShopConfVar('mo_dhl__cod_iban'));
            $cashOnDelivery = new VASCashOnDelivery();
            $cashOnDelivery->setAmount($this->createValue($this->getEURPrice($order, $order->oxorder__oxtotalordersum->value)));
            $cashOnDelivery->setBankAccount($bankAccount);
            $cashOnDelivery->setTransferNote1($customerReference);
            $services->setCashOnDelivery($cashOnDelivery);
            $initialized = true;
        }
        $orderBrutSum = $this->getEURPrice($order, $order->oxorder__oxtotalbrutsum->value);
        if ($process->supportsAdditionalInsurance() && ($order->moDHLUsesService(MoDHLService::MO_DHL__ADDITIONAL_INSURANCE) && $orderBrutSum > 500)) {
            $services->setAdditionalInsurance($this->createValue($orderBrutSum));
            $initialized = true;
        }
        if ($process->supportsPremium() && $order->moDHLUsesService(MoDHLService::MO_DHL__PREMIUM)) {
            $services->setPremium(true);
            $initialized = true;
        }
        if ($process->supportsCDP() && $order->moDHLUsesService(MoDHLService::MO_DHL__CDP)) {
            $services->setClosestDropPoint(true);
            $initialized = true;
        }
        if ($process->supportsEndorsement()) {
            $abandonment = (bool)($order->moDHLUsesService(MoDHLService::MO_DHL__ENDORSEMENT));
            $services->setEndorsement($abandonment ? MoDHLService::MO_DHL__ENDORSEMENT_ABANDONMENT : MoDHLService::MO_DHL__ENDORSEMENT_RETURN);
            $initialized = true;
        }
        if ($process->supportsPDDP() && $order->moDHLUsesService(MoDHLService::MO_DHL__PDDP)) {
            $services->setPostalDeliveryDutyPaid(true);
            $initialized = true;
        }
        if ($process->supportsNoNeighbourDelivery() && Registry::getConfig()->getShopConfVar('mo_dhl__no_neighbour_delivery_active')) {
            $services->setNoNeighbourDelivery(true);
            $initialized = true;
        }
        if ($process->supportsNamedPersonOnly() && $order->moDHLUsesService(MoDHLService::MO_DHL__NAMED_PERSON_ONLY)) {
            $services->setNamedPersonOnly(true);
            $initialized = true;
        }
        if ($process->supportsSignedForByRecipient() && $order->moDHLUsesService(MoDHLService::MO_DHL__SIGNED_FOR_BY_RECIPIENT)) {
            $services->setSignedForByRecipient(true);
            $initialized = true;
        }
        if (Registry::getConfig()->getShopConfVar('mo_dhl__beilegerretoure_active') && $this->getProcess($order)->supportsDHLRetoure() && $returnAccountNumber = $this->buildReturnAccountNumber($order)) {
            $dhlRetoure = new VASDhlRetoure();
            $dhlRetoure->setBillingNumber($returnAccountNumber);
            $dhlRetoure->setReturnAddress($this->buildReturnReceiver());
            $services->setDhlRetoure($dhlRetoure);
            $initialized = true;
        }

        return $initialized ? $services : null;
    }

    /**
     * @param Order $order
     * @return VASIdentCheck
     */
    protected function createIdent(Order $order): VASIdentCheck
    {
        $identCheck = new VASIdentCheck();
        $identCheck->setDateOfBirth(new \DateTime($order->getFieldData('mo_dhl_ident_check_birthday')));
        $identCheck->setFirstName($order->moDHLGetAddressData('fname'));
        $identCheck->setLastName($order->moDHLGetAddressData('lname'));
        $identCheck->setMinimumAge(
            Registry::getConfig()->getShopConfVar('mo_dhl__ident_check_min_age')
                ? 'A' . Registry::getConfig()->getShopConfVar('mo_dhl__ident_check_min_age')
                : null);
        if ($order->moDHLUsesService(MoDHLService::MO_DHL__VISUAL_AGE_CHECK18)) {
            $identCheck->setMinimumAge('A18');
        } elseif ($order->moDHLUsesService(MoDHLService::MO_DHL__VISUAL_AGE_CHECK16) && !$identCheck->getMinimumAge()) {
            $identCheck->setMinimumAge('A16');
        }
        return $identCheck;
    }

    /**
     * @return ContactAddress
     */
    protected function buildReturnReceiver(): ContactAddress
    {
        $config = Registry::getConfig();
        if ($config->getShopConfVar('mo_dhl__retoure_receiver_use_sender')) {
            $returnReceiver = new ContactAddress();
            $returnReceiver->setName1($this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_line1')));
            if ($name2 = $this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_line2'))) {
                $returnReceiver->setName2($name2);
            }
            if ($name3 = $this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_line3'))) {
                $returnReceiver->setName3($name3);
            }
            $returnReceiver->setCity($this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_city')));
            $returnReceiver->setPostalCode($config->getShopConfVar('mo_dhl__sender_zip'));
            $returnReceiver->setAddressStreet($this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_street')));
            $returnReceiver->setAddressHouse($config->getShopConfVar('mo_dhl__sender_street_number'));
            $returnReceiver->setCountry($config->getShopConfVar('mo_dhl__sender_country'));
            return $returnReceiver;
        }
        $returnReceiver = new ContactAddress();
        $returnReceiver->setName1($this->convertSpecialChars($config->getShopConfVar('mo_dhl__retoure_receiver_line1')));
        if ($name2 = $this->convertSpecialChars($config->getShopConfVar('mo_dhl__retoure_receiver_line2'))) {
            $returnReceiver->setName2($name2);
        }
        if ($name3 = $this->convertSpecialChars($config->getShopConfVar('mo_dhl__retoure_receiver_line3'))) {
            $returnReceiver->setName3($name3);
        }
        $returnReceiver->setCity($this->convertSpecialChars($config->getShopConfVar('mo_dhl__retoure_receiver_city')));
        $returnReceiver->setPostalCode($config->getShopConfVar('mo_dhl__retoure_receiver_zip'));
        $returnReceiver->setAddressStreet($this->convertSpecialChars($config->getShopConfVar('mo_dhl__retoure_receiver_street')));
        $returnReceiver->setAddressHouse($config->getShopConfVar('mo_dhl__retoure_receiver_street_number'));
        $returnReceiver->setCountry($config->getShopConfVar('mo_dhl__retoure_receiver_country'));
        return $returnReceiver;
    }

    protected function buildShipper(): Shipper
    {
        $config = Registry::getConfig();
        $shipper = new Shipper();
        $shipper->setName1($this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_line1')));
        if ($name2 = $this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_line2'))) {
            $shipper->setName2($name2);
        }
        if ($name3 = $this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_line3'))) {
            $shipper->setName3($name3);
        }
        $shipper->setCity($this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_city')));
        $shipper->setPostalCode($config->getShopConfVar('mo_dhl__sender_zip'));
        $shipper->setAddressStreet($this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_street')));
        $shipper->setAddressHouse($config->getShopConfVar('mo_dhl__sender_street_number'));
        $shipper->setCountry($config->getShopConfVar('mo_dhl__sender_country'));
        return $shipper;
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
    protected function buildExportDocument(Order $order): CustomsDetails
    {
        $config = Registry::getConfig();

        $receiverLanguages = $this->getReceiverLanguages($order);

        $exportDocuments = [];

        /** @var OrderArticle $orderArticle */
        foreach ($order->getOrderArticles() as $orderArticle) {
            $commodity = new Commodity();
            $commodity->setItemDescription($this->getArticleTitle($orderArticle, $receiverLanguages));
            $commodity->setPackagedQuantity($orderArticle->getFieldData('oxamount'));
            $commodity->setItemValue($this->createValue($this->getEURPrice($order, $orderArticle->getPrice()->getPrice())));
            $weight = new Weight();
            $weight->setUom('kg');
            $weight->setValue($this->getArticleWeight($orderArticle, $config));
            $commodity->setItemWeight($weight);
            if ($hsCode = $orderArticle->getArticle()->getFieldData(MoDHLService::MO_DHL__ZOLLTARIF)) {
                $commodity->setHsCode($hsCode);
            }
            if ($origin = $config->getShopConfVar('mo_dhl__sender_country')) {
                $commodity->setCountryOfOrigin($origin);
            }
            $exportDocuments[] = $commodity;
        }

        $customsDetails = new CustomsDetails();
        $customsDetails->setExportType('COMMERCIAL_GOODS');
        $customsDetails->setPostalCharges($this->createValue($this->getEURPrice($order, $order->oxorder__oxdelcost->value)));
        $customsDetails->setItems($exportDocuments);
        $customsDetails->setOfficeOfOrigin($this->convertSpecialChars($config->getShopConfVar('mo_dhl__sender_city')));
        return $customsDetails;

    }

    /**
     * @param string $isoalpha3
     * @return false|string
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    protected function getIsoalpha2FromIsoalpha3($isoalpha3)
    {
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
        $country = \oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
        $country->load($order->moDHLGetAddressData('countryid'));
        $receiverCountryISO2 = $country->getFieldData('oxisoalpha2');

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
     * @param array        $receiverLanguages
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
        $title = $title
            ?? $orderArticle->getArticle()->getFieldData('oxtitle')
            ?? $orderArticle->getFieldData('oxtitle');

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


    /**
     * This method will return a value with EUR as currency since the currency this class receives is EUR at the moment.
     *
     * @param float       $amount
     * @param string|null $currency
     * @return Value
     */
    protected function createValue(float $amount, ?string $currency = null): Value
    {
        $value = new Value();
        $value->setValue($amount);
        $value->setCurrency($currency ?: 'EUR');
        return $value;
    }

    public function buildQueryParameters(): array
    {
        return [
            'includeDocs' => 'URL',
            'combine'     => false,
            'mustEncode'  => (bool) Registry::getConfig()->getShopConfVar('mo_dhl__only_with_leitcode'),
        ];
    }
}
