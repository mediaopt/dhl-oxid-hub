<?php

namespace Mediaopt\DHL\Api;

use Mediaopt\DHL\Api\GKV\AuthentificationType;
use Mediaopt\DHL\Api\GKV\CreateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\CreateShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\DeleteShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\DeleteShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\DoManifestRequest;
use Mediaopt\DHL\Api\GKV\DoManifestResponse;
use Mediaopt\DHL\Api\GKV\GetExportDocRequest;
use Mediaopt\DHL\Api\GKV\GetExportDocResponse;
use Mediaopt\DHL\Api\GKV\GetLabelRequest;
use Mediaopt\DHL\Api\GKV\GetLabelResponse;
use Mediaopt\DHL\Api\GKV\GetManifestRequest;
use Mediaopt\DHL\Api\GKV\GetManifestResponse;
use Mediaopt\DHL\Api\GKV\GetVersionResponse;
use Mediaopt\DHL\Api\GKV\Shipment;
use Mediaopt\DHL\Api\GKV\UpdateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\UpdateShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\ValidateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\ValidateShipmentResponse;
use Mediaopt\DHL\Api\GKV\Version;
use Mediaopt\DHL\Exception\WebserviceException;
use Psr\Log\LoggerInterface;

class GKV extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = [
        'Version'                                       => 'Mediaopt\\DHL\\Api\\GKV\\Version',
        'AuthentificationType'                          => 'Mediaopt\\DHL\\Api\\GKV\\AuthentificationType',
        'NativeAddressType'                             => 'Mediaopt\\DHL\\Api\\GKV\\NativeAddressType',
        'NativeAddressTypeNew'                          => 'Mediaopt\\DHL\\Api\\GKV\\NativeAddressTypeNew',
        'ReceiverNativeAddressType'                     => 'Mediaopt\\DHL\\Api\\GKV\\ReceiverNativeAddressType',
        'PickupAddressType'                             => 'Mediaopt\\DHL\\Api\\GKV\\PickupAddressType',
        'DeliveryAddressType'                           => 'Mediaopt\\DHL\\Api\\GKV\\DeliveryAddressType',
        'BankType'                                      => 'Mediaopt\\DHL\\Api\\GKV\\BankType',
        'NameType'                                      => 'Mediaopt\\DHL\\Api\\GKV\\NameType',
        'ReceiverNameType'                              => 'Mediaopt\\DHL\\Api\\GKV\\ReceiverNameType',
        'CommunicationType'                             => 'Mediaopt\\DHL\\Api\\GKV\\CommunicationType',
        'ContactType'                                   => 'Mediaopt\\DHL\\Api\\GKV\\ContactType',
        'PackStationType'                               => 'Mediaopt\\DHL\\Api\\GKV\\PackStationType',
        'PostfilialeType'                               => 'Mediaopt\\DHL\\Api\\GKV\\PostfilialeType',
        'PostfilialeTypeNoCountry'                      => 'Mediaopt\\DHL\\Api\\GKV\\PostfilialeTypeNoCountry',
        'ParcelShopType'                                => 'Mediaopt\\DHL\\Api\\GKV\\ParcelShopType',
        'CustomerType'                                  => 'Mediaopt\\DHL\\Api\\GKV\\CustomerType',
        'ErrorType'                                     => 'Mediaopt\\DHL\\Api\\GKV\\ErrorType',
        'CountryType'                                   => 'Mediaopt\\DHL\\Api\\GKV\\CountryType',
        'ShipmentNumberType'                            => 'Mediaopt\\DHL\\Api\\GKV\\ShipmentNumberType',
        'Status'                                        => 'Mediaopt\\DHL\\Api\\GKV\\Status',
        'Dimension'                                     => 'Mediaopt\\DHL\\Api\\GKV\\Dimension',
        'TimeFrame'                                     => 'Mediaopt\\DHL\\Api\\GKV\\TimeFrame',
        'GetVersionResponse'                            => 'Mediaopt\\DHL\\Api\\GKV\\GetVersionResponse',
        'CreateShipmentOrderRequest'                    => 'Mediaopt\\DHL\\Api\\GKV\\CreateShipmentOrderRequest',
        'ValidateShipmentOrderRequest'                  => 'Mediaopt\\DHL\\Api\\GKV\\ValidateShipmentOrderRequest',
        'CreateShipmentOrderResponse'                   => 'Mediaopt\\DHL\\Api\\GKV\\CreateShipmentOrderResponse',
        'ValidateShipmentResponse'                      => 'Mediaopt\\DHL\\Api\\GKV\\ValidateShipmentResponse',
        'GetLabelRequest'                               => 'Mediaopt\\DHL\\Api\\GKV\\GetLabelRequest',
        'GetLabelResponse'                              => 'Mediaopt\\DHL\\Api\\GKV\\GetLabelResponse',
        'DoManifestRequest'                             => 'Mediaopt\\DHL\\Api\\GKV\\DoManifestRequest',
        'DoManifestResponse'                            => 'Mediaopt\\DHL\\Api\\GKV\\DoManifestResponse',
        'DeleteShipmentOrderRequest'                    => 'Mediaopt\\DHL\\Api\\GKV\\DeleteShipmentOrderRequest',
        'DeleteShipmentOrderResponse'                   => 'Mediaopt\\DHL\\Api\\GKV\\DeleteShipmentOrderResponse',
        'GetExportDocRequest'                           => 'Mediaopt\\DHL\\Api\\GKV\\GetExportDocRequest',
        'GetExportDocResponse'                          => 'Mediaopt\\DHL\\Api\\GKV\\GetExportDocResponse',
        'GetManifestRequest'                            => 'Mediaopt\\DHL\\Api\\GKV\\GetManifestRequest',
        'GetManifestResponse'                           => 'Mediaopt\\DHL\\Api\\GKV\\GetManifestResponse',
        'UpdateShipmentOrderRequest'                    => 'Mediaopt\\DHL\\Api\\GKV\\UpdateShipmentOrderRequest',
        'UpdateShipmentOrderResponse'                   => 'Mediaopt\\DHL\\Api\\GKV\\UpdateShipmentOrderResponse',
        'CreationState'                                 => 'Mediaopt\\DHL\\Api\\GKV\\CreationState',
        'ValidationState'                               => 'Mediaopt\\DHL\\Api\\GKV\\ValidationState',
        'Statusinformation'                             => 'Mediaopt\\DHL\\Api\\GKV\\Statusinformation',
        'StatusElement'                                 => 'Mediaopt\\DHL\\Api\\GKV\\StatusElement',
        'PieceInformation'                              => 'Mediaopt\\DHL\\Api\\GKV\\PieceInformation',
        'ShipmentOrderType'                             => 'Mediaopt\\DHL\\Api\\GKV\\ShipmentOrderType',
        'Shipment'                                      => 'Mediaopt\\DHL\\Api\\GKV\\Shipment',
        'ValidateShipmentOrderType'                     => 'Mediaopt\\DHL\\Api\\GKV\\ValidateShipmentOrderType',
        'ShipperTypeType'                               => 'Mediaopt\\DHL\\Api\\GKV\\ShipperTypeType',
        'ShipperType'                                   => 'Mediaopt\\DHL\\Api\\GKV\\ShipperType',
        'ReceiverTypeType'                              => 'Mediaopt\\DHL\\Api\\GKV\\ReceiverTypeType',
        'ReceiverType'                                  => 'Mediaopt\\DHL\\Api\\GKV\\ReceiverType',
        'ShipmentDetailsType'                           => 'Mediaopt\\DHL\\Api\\GKV\\ShipmentDetailsType',
        'ShipmentDetailsTypeType'                       => 'Mediaopt\\DHL\\Api\\GKV\\ShipmentDetailsTypeType',
        'ShipmentItemType'                              => 'Mediaopt\\DHL\\Api\\GKV\\ShipmentItemType',
        'ShipmentItemTypeType'                          => 'Mediaopt\\DHL\\Api\\GKV\\ShipmentItemTypeType',
        'ShipmentService'                               => 'Mediaopt\\DHL\\Api\\GKV\\ShipmentService',
        'Serviceconfiguration'                          => 'Mediaopt\\DHL\\Api\\GKV\\Serviceconfiguration',
        'ServiceconfigurationDetails'                   => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationDetails',
        'ServiceconfigurationDetailsPreferredDay'       => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationDetailsPreferredDay',
        'ServiceconfigurationDetailsPreferredLocation'  => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationDetailsPreferredLocation',
        'ServiceconfigurationDetailsPreferredNeighbour' => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationDetailsPreferredNeighbour',
        'ServiceconfigurationDetailsOptional'           => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationDetailsOptional',
        'ServiceconfigurationDetailsResponse'           => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationDetailsResponse',
        'ServiceconfigurationType'                      => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationType',
        'ServiceconfigurationEndorsement'               => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationEndorsement',
        'ServiceconfigurationISR'                       => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationISR',
        'ServiceconfigurationDH'                        => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationDH',
        'ServiceconfigurationVisualAgeCheck'            => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationVisualAgeCheck',
        'ServiceconfigurationDeliveryTimeframe'         => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationDeliveryTimeframe',
        'ServiceconfigurationDateOfDelivery'            => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationDateOfDelivery',
        'ServiceconfigurationAdditionalInsurance'       => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationAdditionalInsurance',
        'ServiceconfigurationCashOnDelivery'            => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationCashOnDelivery',
        'ServiceconfigurationUnfree'                    => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationUnfree',
        'PDDP'                                          => 'Mediaopt\\DHL\\Api\\GKV\\PDDP',
        'CDP'                                           => 'Mediaopt\\DHL\\Api\\GKV\\CDP',
        'Economy'                                       => 'Mediaopt\\DHL\\Api\\GKV\\Economy',
        'ServiceconfigurationIC'                        => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationIC',
        'ShipmentNotificationType'                      => 'Mediaopt\\DHL\\Api\\GKV\\ShipmentNotificationType',
        'ExportDocumentType'                            => 'Mediaopt\\DHL\\Api\\GKV\\ExportDocumentType',
        'ExportDocPosition'                             => 'Mediaopt\\DHL\\Api\\GKV\\ExportDocPosition',
        'FurtherAddressesType'                          => 'Mediaopt\\DHL\\Api\\GKV\\FurtherAddressesType',
        'DeliveryAdress'                                => 'Mediaopt\\DHL\\Api\\GKV\\DeliveryAdress',
        'LabelData'                                     => 'Mediaopt\\DHL\\Api\\GKV\\LabelData',
        'ExportDocData'                                 => 'Mediaopt\\DHL\\Api\\GKV\\ExportDocData',
        'ManifestState'                                 => 'Mediaopt\\DHL\\Api\\GKV\\ManifestState',
        'DeletionState'                                 => 'Mediaopt\\DHL\\Api\\GKV\\DeletionState',
        'BookPickupRequest'                             => 'Mediaopt\\DHL\\Api\\GKV\\BookPickupRequest',
        'BookPickupResponse'                            => 'Mediaopt\\DHL\\Api\\GKV\\BookPickupResponse',
        'PickupDetailsType'                             => 'Mediaopt\\DHL\\Api\\GKV\\PickupDetailsType',
        'PickupOrdererType'                             => 'Mediaopt\\DHL\\Api\\GKV\\PickupOrdererType',
        'PickupBookingInformationType'                  => 'Mediaopt\\DHL\\Api\\GKV\\PickupBookingInformationType',
        'CancelPickupRequest'                           => 'Mediaopt\\DHL\\Api\\GKV\\CancelPickupRequest',
        'CancelPickupResponse'                          => 'Mediaopt\\DHL\\Api\\GKV\\CancelPickupResponse',
        'IdentityData'                                  => 'Mediaopt\\DHL\\Api\\GKV\\IdentityData',
        'DrivingLicense'                                => 'Mediaopt\\DHL\\Api\\GKV\\DrivingLicense',
        'IdentityCard'                                  => 'Mediaopt\\DHL\\Api\\GKV\\IdentityCard',
        'BankCard'                                      => 'Mediaopt\\DHL\\Api\\GKV\\BankCard',
        'ReadShipmentOrderResponse'                     => 'Mediaopt\\DHL\\Api\\GKV\\ReadShipmentOrderResponse',
    ];

    /**
     * @var Credentials
     */
    protected $soapCredentials;

    /**
     * @var Credentials
     */
    protected $customerGKVCredentials;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Credentials     $credentials
     * @param Credentials     $customerGKVCredentials
     * @param LoggerInterface $logger
     */
    public function __construct(Credentials $credentials, Credentials $customerGKVCredentials, LoggerInterface $logger)
    {
        $this->soapCredentials = $credentials;
        $this->customerGKVCredentials = $customerGKVCredentials;
        $this->logger = $logger;
        $options = [
            'features'       => SOAP_SINGLE_ELEMENT_ARRAYS,
            'trace'          => 1,
            'location'       => $this->getSoapCredentials()->getEndpoint(),
            'login'          => $this->getSoapCredentials()->getUsername(),
            'password'       => $this->getSoapCredentials()->getPassword(),
            'authentication' => SOAP_AUTHENTICATION_BASIC,
            'classmap'       => self::$classmap,
        ];
        $wsdl = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'GKV' . DIRECTORY_SEPARATOR . 'geschaeftskundenversand-api-3.5.0.wsdl';
        parent::__construct($wsdl, $options);
    }

    /**
     * @return Credentials
     */
    public function getSoapCredentials(): Credentials
    {
        return $this->soapCredentials;
    }

    /**
     * @return Credentials
     */
    public function getCustomerGKVCredentials(): Credentials
    {
        return $this->customerGKVCredentials;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param string $functionName
     * @param mixed  $request
     * @return mixed
     */
    protected function callSoap($functionName, $request)
    {
        $this->getLogger()->debug(__METHOD__ . " - SOAP API call for function  $functionName", ['options' => $request]);
        try {
            $auth = new AuthentificationType($this->getCustomerGKVCredentials()->getUsername(), $this->getCustomerGKVCredentials()->getPassword());
            $header = new \SoapHeader('http://dhl.de/webservice/cisbase', 'Authentification', $auth);
            return $this->__soapCall($functionName, [$request], null, $header);
        } catch (\SoapFault $exception) {
            $message = __METHOD__ . " - The SOAP API call for function  $functionName failed due to {$exception->getMessage()}";
            $message = $this->appendOrderNr($request, $message);
            $this->getLogger()->error($message, ['exception' => $exception]);
            throw new WebserviceException('Failed API call.', 0, $exception);
        }
    }

    /**
     * Creates shipments.
     *
     * @param CreateShipmentOrderRequest $request
     * @return CreateShipmentOrderResponse
     */
    public function createShipmentOrder(CreateShipmentOrderRequest $request)
    {
        return $this->callSoap('createShipmentOrder', $request);
    }

    /**
     * Creates shipments.
     *
     * @param ValidateShipmentOrderRequest $request
     * @return ValidateShipmentResponse
     */
    public function validateShipment(ValidateShipmentOrderRequest $request)
    {
        return $this->callSoap('validateShipment', $request);
    }

    /**
     * Deletes the requested shipments.
     *
     * @param DeleteShipmentOrderRequest $request
     * @return DeleteShipmentOrderResponse
     */
    public function deleteShipmentOrder(DeleteShipmentOrderRequest $request)
    {
        return $this->callSoap('deleteShipmentOrder', $request);
    }

    /**
     * Manifest the requested DD shipments.
     *
     * @param DoManifestRequest $request
     * @return DoManifestResponse
     */
    public function doManifest(DoManifestRequest $request)
    {
        return $this->callSoap('doManifest', $request);
    }

    /**
     * Returns the request-url for getting a label.
     *
     * @param GetLabelRequest $request
     * @return GetLabelResponse
     */
    public function getLabel(GetLabelRequest $request)
    {
        return $this->callSoap('getLabel', $request);
    }

    /**
     * Returns the actual version of the implementation of the whole ISService
     *         webservice.
     *
     * @param Version $request
     * @return GetVersionResponse
     */
    public function getVersion(Version $request)
    {
        return $this->callSoap('getVersion', $request);
    }

    /**
     * Returns the request-url for getting a export
     *         document.
     *
     * @param GetExportDocRequest $request
     * @return GetExportDocResponse
     */
    public function getExportDoc(GetExportDocRequest $request)
    {
        return $this->callSoap('getExportDoc', $request);
    }

    /**
     * Request the manifest.
     *
     * @param GetManifestRequest $request
     * @return GetManifestResponse
     */
    public function getManifest(GetManifestRequest $request)
    {
        return $this->callSoap('getManifest', $request);
    }

    /**
     * Updates a shipment order.
     *
     * @param UpdateShipmentOrderRequest $request
     * @return UpdateShipmentOrderResponse
     */
    public function updateShipmentOrder(UpdateShipmentOrderRequest $request)
    {
        return $this->callSoap('updateShipmentOrder', $request);
    }

    /**
     * @return Version
     */
    public function buildVersion(): Version
    {
        return new Version(3, 4, 0);
    }

    /**
     * @param $request
     * @param $message
     * @return mixed|string
     */
    protected function appendOrderNr($request, $message)
    {
        if (!method_exists($request, 'getShipmentOrder')) {
            return $message;
        }
        $shipmentOrders = $request->getShipmentOrder();
        $shipmentOrderNumbers = [];
        foreach (is_array($shipmentOrders) ? $shipmentOrders : [$shipmentOrders] as $shipmentOrder) {
            if (method_exists($shipmentOrder, 'getShipment') && $shipmentOrder->getShipment() instanceof Shipment) {
                $shipmentOrderNumbers[] = $shipmentOrder->getShipment()->getShipmentDetails()->getCustomerReference();
            }
        }
        if ($shipmentOrderNumbers) {
            $message .= ' for orderNumbers: ' . implode(', ', $shipmentOrderNumbers);
        }
        return $message;
    }
}
