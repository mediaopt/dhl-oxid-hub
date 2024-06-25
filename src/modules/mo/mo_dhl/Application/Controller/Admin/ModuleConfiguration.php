<?php

namespace Mediaopt\DHL\Application\Controller\Admin;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Mediaopt\DHL\Adapter\DHLAdapter;
use Mediaopt\DHL\Adapter\ParcelShippingRequestBuilder;
use Mediaopt\DHL\Api\Internetmarke;
use Mediaopt\DHL\Api\MyAccount\Model\Detail;
use Mediaopt\DHL\Api\ParcelShipping\Client;
use Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentDetails;
use Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentOrderRequest;
use Mediaopt\DHL\Api\ParcelShipping\Model\Shipper;
use Mediaopt\DHL\Api\ParcelShipping\Model\Weight;
use Mediaopt\DHL\Application\Model\DeliverySetList;
use Mediaopt\DHL\Controller\Admin\ErrorDisplayTrait;
use Mediaopt\DHL\Export\CsvExporter;
use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Shipment\BillingNumber;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;
use OxidEsales\Eshop\Application\Model\DeliverySet;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\UtilsView;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

/** @noinspection LongInheritanceChainInspection */

/**
 * Extends the module configuration to allow the user to download logs.
 *
 * @author Mediaopt GmbH
 */
class ModuleConfiguration extends ModuleConfiguration_parent
{

    use ErrorDisplayTrait;

    /**
     * @var string[]
     */
    const SURCHARGE_SNIPPETS = [
        'mo_dhl__wunschtag_surcharge_text' => 'MO_DHL__WUNSCHTAG_COSTS',
    ];

    /**
     * @var string[]
     */
    const INTERNAL_PROCESSES = [
        'PAKET'                   => 'DHL PAKET',
        'PAKET_INTERNATIONAL'     => 'PAKET INTERNATIONAL',
        'EUROPAKET'               => 'DHL EUROPAKET',
        'WARENPOST'               => 'Warenpost',
        'WARENPOST_INTERNATIONAL' => 'Warenpost International',
    ];

    /**
     * @var string[]
     */
    const INTERNAL_PROCESSES_INVERSE = [
        'DHL PAKET'               => 'PAKET',
        'PAKET INTERNATIONAL'     => 'PAKET_INTERNATIONAL',
        'DHL EUROPAKET'           => 'EUROPAKET',
        'Warenpost'               => 'WARENPOST',
        'Warenpost International' => 'WARENPOST_INTERNATIONAL',
    ];

    var $SHIPPING_METHODS = [];

    /**
     * @extend
     * @return string
     */
    public function render()
    {
        $this->addTplParam('processes', Process::getAvailableProcesses());
        return parent::render();
    }

    /**
     * Streams the chosen log to the user.
     */
    public function moDownload()
    {
        $log = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('log');
        if (!in_array($log, $this->moGetLogs(), true)) {
            return;
        }

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename=' . $log);
        fpassthru(fopen(Registry::getConfig()->getLogsDir() . $log, 'rb'));
        exit;
    }

    /**
     * @return array
     */
    public function moGetLogs()
    {
        $logs = array_reverse(glob(Registry::getConfig()->getLogsDir() . 'mo_dhl_*.log'));
        return array_map('basename', $logs);
    }

    /**
     * @extend
     */
    public function saveConfVars()
    {
        parent::saveConfVars();

        if ($this->getEditObjectId() === 'mo_dhl') {
            $this->moReviewEkp();
            $this->moReviewFilialroutingAlternativeEmail();
            $this->moReviewWeightSettings();
        }
    }

    protected function getEkp(): string
    {
        return Registry::getConfig()->getConfigParam('mo_dhl__merchant_ekp');
    }

    /**
     * Converts Multiline text to simple array. Returns this array.
     *
     * @param string $multiline Multiline text
     *
     * @return array
     */
    protected function _multilineToArray($multiline)
    {
        if (is_array($multiline)) {
            return $multiline;
        }
        return parent::_multilineToArray($multiline);
    }

    /**
     */
    protected function moReviewFilialroutingAlternativeEmail()
    {
        $mailVariable = 'mo_dhl__filialrouting_alternative_email';
        $email = Registry::getConfig()->getConfigParam($mailVariable);
        if (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return;
        }
        Registry::getConfig()->saveShopConfVar('str', $mailVariable, '', '', 'module:mo_dhl');
        Registry::get(UtilsView::class)->addErrorToDisplay('MO_DHL__FILIALROUTING_EMAIL_ERROR');
    }

    /**
     */
    protected function moReviewWeightSettings()
    {
        $weightSetting = [
            'mo_dhl__default_weight',
            'mo_dhl__packing_weight_in_percent',
            'mo_dhl__packing_weight_absolute',
        ];
        $changed = false;
        foreach ($weightSetting as $setting) {
            $value = Registry::getConfig()->getConfigParam($setting);
            if (strpos($value, ',') !== false) {
                $value = \OxidEsales\EshopCommunity\Core\Registry::getUtils()->string2Float($value);
                Registry::getConfig()->saveShopConfVar('str', $setting, $value, '', 'module:mo_dhl');
                $changed = true;
            }
        }
        if ($changed) {
            Registry::get(UtilsView::class)->addErrorToDisplay('MO_DHL__ERROR_ WEIGHT_WITH_COMMA');
        }
    }

    /**
     */
    protected function moReviewEkp()
    {
        if (!$ekp = $this->getEkp()) {
            return;
        }

        try {
            Ekp::build($ekp);
        } catch (\InvalidArgumentException $exception) {
            Registry::getConfig()->saveShopConfVar('str', 'mo_dhl__merchant_ekp', '', '', 'module:mo_dhl');
            Registry::get(UtilsView::class)->addErrorToDisplay('MO_DHL__EKP_ERROR');
        }
    }

    /**
     */
    public function moSaveAndCheckLogin()
    {
        try {
            $this->save();
            $adapter = new DHLAdapter();
            if (Registry::getConfig()->getConfigParam('mo_dhl__account_sandbox')) {
                Registry::get(UtilsView::class)->addErrorToDisplay('MO_DHL__CHECK_FOR_SANDBOX_NOT_POSSIBLE');
                return;
            }
            $this->checkWunschpaket($adapter);
            $deliveries = oxNew(DeliverySetList::class);
            $deliveries = array_filter((array)$deliveries->getDeliverySetList(null, null), function ($deliverySet) {
                return !$deliverySet->oxdeliveryset__mo_dhl_excluded->value;
            });
            if ($deliveries === []) {
                Registry::get(UtilsView::class)->addErrorToDisplay('MO_DHL__NO_DELIVERYSET');
                return;
            }
            $parcelShipping = $adapter->buildParcelShipping();
            foreach ($deliveries as $delivery) {
                $this->checkShippingAPIs($parcelShipping, $delivery);
            }
        } catch (\Exception $e) {
            $this->displayErrors($e);
        }

    }

    /**
     * @param String $detailName
     * @return bool
     */
    public function checkForShippingAlreadyExist(string $detailName): bool
    {
        if (count($this->SHIPPING_METHODS) === 0) {
            /** @var QueryBuilderFactoryInterface $queryBuilder */
            $queryBuilder = ContainerFactory::getInstance()->getContainer()->get(QueryBuilderFactoryInterface::class);
            $this->SHIPPING_METHODS = array_map(
                fn($shippingMethod) => self::INTERNAL_PROCESSES[$shippingMethod],
                $queryBuilder->create()->select('mo_dhl_process')->from('oxdeliveryset')->execute()->fetchFirstColumn()
            );
        }

        return in_array($detailName, $this->SHIPPING_METHODS, true);
    }

    /**
     * @param Detail $detail
     * @return void
     */
    private function createNewShippingMethod(Detail $detail): void
    {
        if (!array_key_exists($detail->getProduct()->getName(), self::INTERNAL_PROCESSES_INVERSE)) {
            return;
        }
        $oDelSet = oxNew(DeliverySet::class);
        $aParams = [
            "oxdeliveryset__oxid"                 => null,
            "oxdeliveryset__oxtitle"              => $detail->getBookingText(),
            "oxdeliveryset__mo_dhl_process"       => self::INTERNAL_PROCESSES_INVERSE[$detail->getProduct()->getName()],
            "oxdeliveryset__mo_dhl_participation" => substr($detail->getBillingNumber(), -2)
        ];

        $oDelSet->setLanguage(0);
        $oDelSet->assign($aParams);
        $oDelSet = Registry::getUtilsFile()->processFiles($oDelSet);
        $oDelSet->save();
    }

    /**
     */
    public function moAuthentication(): void
    {
        try {
            $this->save();
            $adapter = new DHLAdapter();
            $myAccount = $adapter->buildMyAccount();
            $userData = $myAccount->getMyAggregatedUserData(['lang' => 'de']);

            $details = $userData->getShippingRights()->getDetails();

            array_map([$this, 'createNewShippingMethod'], array_filter($details, fn($detail) => !$this->checkForShippingAlreadyExist($detail->getProduct()->getName())));

        } catch (\Exception $e) {
            $this->displayErrors($e);
        }
    }

    /**
     */
    public function moSaveAndCheckInternetmarkeLogin()
    {
        try {
            $this->save();
            $adapter = new DHLAdapter();
            $this->checkInternetmarke($adapter->buildInternetmarke());
        } catch (\Exception $e) {
            $this->displayErrors($e);
        }
    }

    /**
     * @param string $textVarName
     * @return string[]
     */
    public function moDHLGetSurchargeTexts($textVarName)
    {
        $texts = Registry::getConfig()->getShopConfVar($textVarName) ?: [];
        foreach (array_keys($this->moDHLGetLanguages()) as $lang) {
            if (!isset($texts[$lang])) {
                $texts[$lang] = '';
            }
        }
        return $texts;
    }

    /**
     * @param int $langId
     * @return string
     */
    public function moDHLGetLanguageName(int $langId): string
    {
        return $this->moDHLGetLanguages()[$langId]->name;
    }

    /**
     * @return \stdClass[]
     */
    public function moDHLGetLanguages(): array
    {
        return Registry::getLang()->getLanguageArray();
    }

    /**
     * @param string $textVarName
     * @param int    $langId
     * @return string
     */
    public function moDHLGetPlaceholder(string $textVarName, int $langId): string
    {
        $snippet = self::SURCHARGE_SNIPPETS[$textVarName];
        $snippet .= Registry::getConfig()->getConfigParam('blShowVATForDelivery') ? '_NET' : '_GROSS';
        $translation = Registry::getLang()->translateString($snippet, $langId, false);
        return $translation !== $snippet ? $translation : '';
    }

    /**
     * @param DHLAdapter $adapter
     */
    private function checkWunschpaket(DHLAdapter $adapter)
    {
        try {
            $days = $adapter->buildWunschpaket()->getPreferredDays('12045');
        } catch (\RuntimeException $e) {
            Registry::get(UtilsView::class)->addErrorToDisplay($e->getMessage());
            return;
        }
        if (empty($days)) {
            Registry::get(UtilsView::class)->addErrorToDisplay('MO_DHL__INCORRECT_CREDENTIALS');
        }
    }

    private function checkInternetmarke(Internetmarke $internetmarke)
    {
        try {
            $response = $internetmarke->authenticateUser();
            $message = sprintf(Registry::getLang()->translateString('MO_DHL__WALLAT_BALANCE_CHECK'), $response->getWalletBalance() / 100.);
            Registry::get(UtilsView::class)->addErrorToDisplay($message);
        } catch (\RuntimeException $e) {
            $e = $e->getPrevious() ?: $e;
            Registry::get(UtilsView::class)->addErrorToDisplay($e->getMessage());
        }
    }

    /**
     * @param Client      $parcelShipping
     * @param DeliverySet $deliveryset
     * @throws \Exception
     */
    private function checkShippingAPIs(Client $parcelShipping, $deliveryset)
    {
        $lang = Registry::getLang();
        Registry::get(UtilsView::class)->addErrorToDisplay($lang->translateString('MO_DHL__CHECKING_DELIVERYSET') . $deliveryset->oxdeliveryset__oxtitle->value);
        try {
            if (!$deliveryset->oxdeliveryset__mo_dhl_process->value) {
                throw new \InvalidArgumentException('MO_DHL__ERROR_PROCESS_IS_MISSING');
            }
            $process = Process::build($deliveryset->oxdeliveryset__mo_dhl_process->value);
            if ($process->usesInternetMarke()) {
                return;
            }
            $shipmentOrderRequest = new ShipmentOrderRequest();
            $shipmentOrderRequest->setShipments([$this->createTestShipment($deliveryset)]);
            $shipmentOrderRequest->setProfile(ParcelShippingRequestBuilder::STANDARD_GRUPPENPROFIL);

            $response = $parcelShipping->createOrders($shipmentOrderRequest, ['validate' => true], [], Client::FETCH_RESPONSE);
            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
                $payload = json_decode($response->getBody()->getContents(), true);
                if ($payload['status'] == 401) {
                    Registry::get(UtilsView::class)->addErrorToDisplay('MO_DHL__LOGIN_FAILED');
                    return;
                }
                foreach ($this->extractErrorsFromResponsePayload($payload) as $error) {
                    Registry::get(UtilsView::class)->addErrorToDisplay($error);
                }
                return;
            }
        } catch (\RuntimeException $e) {
            $e = $e->getPrevious() ?: $e;
            Registry::get(UtilsView::class)->addErrorToDisplay($e->getMessage());
            return;
        }
        Registry::get(UtilsView::class)->addErrorToDisplay('MO_DHL__CORRECT_CREDENTIALS');
    }

    /**
     * @param DeliverySet $deliveryset
     * @return \Mediaopt\DHL\Api\ParcelShipping\Model\Shipment
     */
    protected function createTestShipment($deliveryset): \Mediaopt\DHL\Api\ParcelShipping\Model\Shipment
    {
        $process = Process::build($deliveryset->oxdeliveryset__mo_dhl_process->value);
        $receiverCountryCode = $process->isInternational() ? 'FRA' : 'DEU';

        $shipment = new \Mediaopt\DHL\Api\ParcelShipping\Model\Shipment();
        $shipper = (new Shipper())
            ->setName1('a b')
            ->setCity('Berlin')
            ->setPostalCode('12045')
            ->setAddressStreet('Elbestr.')
            ->setAddressHouse('28/29')
            ->setCountry('DEU');
        $shipment->setShipper($shipper);
        $shipment->setConsignee([
            'name1'         => 'a b',
            'contactName'   => 'a b',
            'city'          => 'Berlin',
            'postalCode'    => '12045',
            'addressStreet' => 'Elbestr.',
            'addressHouse'  => '28/29',
            'country'       => $receiverCountryCode,
        ]);
        $shipmentDetails = new ShipmentDetails();
        $weight = new Weight();
        $weight->setUom('kg');
        $weight->setValue('0.5');
        $shipmentDetails->setWeight($weight);
        $shipment->setDetails($shipmentDetails);
        $shipment->setCreationSoftware(CsvExporter::CREATOR_TAG);
        $shipment->setBillingNumber(new BillingNumber(Ekp::build($this->getEkp()), $process, Participation::build($deliveryset->oxdeliveryset__mo_dhl_participation->value)));
        $shipment->setProduct($process->getServiceIdentifier());
        $shipment->setRefNo('12345678');
        $shipment->setShipDate((new \DateTime()));
        return $shipment;
    }
}
