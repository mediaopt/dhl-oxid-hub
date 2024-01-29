<?php

namespace Mediaopt\DHL\Application\Controller\Admin;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Mediaopt\DHL\Adapter\DHLAdapter;
use Mediaopt\DHL\Adapter\ParcelShippingConverter;
use Mediaopt\DHL\Api\Authentication\Model\TokenPostBody;
use Mediaopt\DHL\Api\GKV;
use Mediaopt\DHL\Api\GKV\CountryType;
use Mediaopt\DHL\Api\GKV\NameType;
use Mediaopt\DHL\Api\GKV\CommunicationType;
use Mediaopt\DHL\Api\GKV\NativeAddressTypeNew;
use Mediaopt\DHL\Api\GKV\ReceiverNativeAddressType;
use Mediaopt\DHL\Api\GKV\ReceiverType;
use Mediaopt\DHL\Api\GKV\Shipment;
use Mediaopt\DHL\Api\GKV\ShipmentDetailsTypeType;
use Mediaopt\DHL\Api\GKV\ShipmentItemType;
use Mediaopt\DHL\Api\GKV\ShipperType;
use Mediaopt\DHL\Api\GKV\ValidateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\ValidateShipmentOrderType;
use Mediaopt\DHL\Api\GKV\Version;
use Mediaopt\DHL\Api\Internetmarke;
use Mediaopt\DHL\Api\MyAccount\Model\Detail;
use Mediaopt\DHL\Api\ParcelShipping\Client;
use Mediaopt\DHL\Application\Model\DeliverySetList;
use Mediaopt\DHL\Controller\Admin\ErrorDisplayTrait;
use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Shipment\BillingNumber;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;
use OxidEsales\Eshop\Application\Model\DeliverySet;
use OxidEsales\Eshop\Core\Registry;

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
        'PAKET'                  => 'DHL PAKET',
        'PAKET_INTERNATIONAL'    => 'PAKET INTERNATIONAL',
        'EUROPAKET'              => 'DHL EUROPAKET',
        'WARENPOST'              => 'Warenpost',
        'WARENPOST_INTERNATIONAL'=> 'Warenpost International',
    ];

    /**
     * @var string[]
     */
    const INTERNAL_PROCESSES_INVERSE = [
        'DHL PAKET'                 => 'PAKET',
        'PAKET INTERNATIONAL'       => 'PAKET_INTERNATIONAL',
        'DHL EUROPAKET'             => 'EUROPAKET',
        'Warenpost'                 => 'WARENPOST',
        'Warenpost International'   => 'WARENPOST_INTERNATIONAL',
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
        Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__FILIALROUTING_EMAIL_ERROR');
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
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__ERROR_ WEIGHT_WITH_COMMA');
        }
    }

    /**
     */
    protected function moReviewEkp()
    {
        $ekpVariable = 'mo_dhl__merchant_ekp';
        $ekp = Registry::getConfig()->getConfigParam($ekpVariable);
        if (empty($ekp)) {
            return;
        }

        try {
            Ekp::build($ekp);
        } catch (\InvalidArgumentException $exception) {
            Registry::getConfig()->saveShopConfVar('str', $ekpVariable, '', '', 'module:mo_dhl');
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__EKP_ERROR');
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
                Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__CHECK_FOR_SANDBOX_NOT_POSSIBLE');
                return;
            }
            $this->checkWunschpaket($adapter);
            $deliveries = oxNew(DeliverySetList::class);
            $deliveries = array_filter((array)$deliveries->getDeliverySetList(null, null), function ($deliverySet) {
                return !$deliverySet->oxdeliveryset__mo_dhl_excluded->value;
            });
            if ($deliveries === []) {
                Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__NO_DELIVERYSET');
                return;
            }
            $gkv = $adapter->buildGKV();
            $parcelShipping = $adapter->buildParcelShipping();
            foreach ($deliveries as $delivery) {
                $this->checkShippingAPIs($gkv, $parcelShipping, $delivery);
            }
        } catch (\Exception $e) {
            $this->displayErrors($e);
        }

    }

    /**
     * @param Detail $detail
     * @return bool
     */
    public function checkForShippingAlreadyExist(Detail $detail): bool
    {
        if (count(array_keys($this->SHIPPING_METHODS)) === 0) {
            $this->SHIPPING_METHODS = Registry::get(\OxidEsales\Eshop\Application\Model\DeliverySetList::class)->getDeliverySetList(null, null);
        }

        $shippingExist = false;

        foreach($this->SHIPPING_METHODS as $key => $value) {
            $shippingExist = $shippingExist || (self::INTERNAL_PROCESSES[$value->oxdeliveryset__mo_dhl_process->value] === $detail->getProduct()->getName());
        }
        return $shippingExist;
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
            "oxdeliveryset__oxid"                   => null,
            "oxdeliveryset__oxtitle"                => $detail->getBookingText(),
            "oxdeliveryset__mo_dhl_process"         => self::INTERNAL_PROCESSES_INVERSE[$detail->getProduct()->getName()],
            "oxdeliveryset__mo_dhl_participation"   => substr($detail->getBillingNumber(), -2)
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
            $size = count($details);

            for ($i=0; $i<$size; $i++) {
                if (!$this->checkForShippingAlreadyExist($details[$i])) {
                    $this->createNewShippingMethod($details[$i]);
                }
            }

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
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($e->getMessage());
            return;
        }
        if (empty($days)) {
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__INCORRECT_CREDENTIALS');
        }
    }

    private function checkInternetmarke(Internetmarke $internetmarke)
    {
        try {
            $response = $internetmarke->authenticateUser();
            $message = sprintf(Registry::getLang()->translateString('MO_DHL__WALLAT_BALANCE_CHECK'), $response->getWalletBalance() / 100.);
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($message);
        } catch (\RuntimeException $e) {
            $e = $e->getPrevious() ?: $e;
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($e->getMessage());
        }
    }

    /**
     * @param GKV         $gkv
     * @param Client      $parcelShipping
     * @param DeliverySet $deliveryset
     * @throws \Exception
     */
    private function checkShippingAPIs(\Mediaopt\DHL\Api\GKV $gkv, Client $parcelShipping, $deliveryset)
    {
        $lang = Registry::getLang();
        Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($lang->translateString('MO_DHL__CHECKING_DELIVERYSET') . $deliveryset->oxdeliveryset__oxtitle->value);
        try {
            if (!$deliveryset->oxdeliveryset__mo_dhl_process->value) {
                throw new \InvalidArgumentException('MO_DHL__ERROR_PROCESS_IS_MISSING');
            }
            $process = Process::build($deliveryset->oxdeliveryset__mo_dhl_process->value);
            if ($process->usesInternetMarke()) {
                return;
            }
            $shipment = $this->createTestShipment($gkv, $deliveryset);
            $shipmentOrder = new ValidateShipmentOrderType('123456', $shipment);
            $request = new ValidateShipmentOrderRequest(new Version(3, 4, 0), $shipmentOrder);

            if (Registry::getConfig()->getConfigParam('mo_dhl__account_rest_api')) {
                $converter = Registry::get(ParcelShippingConverter::class);
                [$query, $request] = $converter->convertValidateShipmentOrderRequest($request);
                $response = $parcelShipping->createOrders($request, $query, [], Client::FETCH_RESPONSE);
                if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
                    $payload = json_decode($response->getBody()->getContents(), true);
                    if ($payload['status'] == 401) {
                        Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__LOGIN_FAILED');
                        return;
                    }
                    foreach ($converter->extractErrorsFromResponsePayload($payload) as $error) {
                        Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($error);
                    }
                    return;
                }
            } else {
                $response = $gkv->validateShipment($request);
                if ($response->getStatus()->getStatusCode() !== 0) {
                    switch ($response->getStatus()->getStatusText()) {
                        case 'login failed':
                            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__LOGIN_FAILED');
                            return;
                        default:
                            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($response->getStatus()->getStatusText());
                            if (!isset($response->getValidationState()[0])) {
                                return;
                            }
                            $errors = array_unique($response->getValidationState()[0]->getStatus()->getStatusMessage());
                            foreach ($errors as $error) {
                                Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($error);
                            }
                            return;
                    }
                }
            }
        } catch (\RuntimeException $e) {
            $e = $e->getPrevious() ?: $e;
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($e->getMessage());
            return;
        }
        Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__CORRECT_CREDENTIALS');
    }

    /**
     * @param \Mediaopt\DHL\Api\GKV                           $gkv
     * @param DeliverySet $deliveryset
     * @return Shipment
     */
    protected function createTestShipment(\Mediaopt\DHL\Api\GKV $gkv, $deliveryset): Shipment
    {
        $process = Process::build($deliveryset->oxdeliveryset__mo_dhl_process->value);
        $receiverCountryCode = $process->isInternational() ? 'FR' : 'DE';
        $ShipmentDetails = new ShipmentDetailsTypeType($process->getServiceIdentifier(), new BillingNumber(Ekp::build($gkv->getSoapCredentials()->getEkp()), $process, Participation::build($deliveryset->oxdeliveryset__mo_dhl_participation->value)), (new \DateTime())->format('Y-m-d'), new ShipmentItemType(0.5));
        $Receiver = (new ReceiverType('a b'))->setAddress(new ReceiverNativeAddressType(null, null, 'Elbestr.', '28/29', '12045', 'Berlin', null, new CountryType($receiverCountryCode)))->setCommunication($this->createTestCommunication());
        $Shipper = (new ShipperType(new NameType('a b', null, null), new NativeAddressTypeNew('Elbestr.', '28', '12045', 'Berlin', new CountryType('DE'))));
        $shipment = new Shipment($ShipmentDetails, $Shipper, $Receiver);
        return $shipment;
    }

    /**
     * @return CommunicationType
     */
    protected function createTestCommunication()
    {
        return (new CommunicationType())->setContactPerson('a b');
    }
}
