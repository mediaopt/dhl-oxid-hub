<?php

namespace Mediaopt\DHL\Api;

use Mediaopt\DHL\Api\GKV\AuthenticationType;
use Mediaopt\DHL\Api\GKV\Request\CreateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\Request\DeleteShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\Request\DoManifestRequest;
use Mediaopt\DHL\Api\GKV\Request\GetExportDocRequest;
use Mediaopt\DHL\Api\GKV\Request\GetLabelRequest;
use Mediaopt\DHL\Api\GKV\Request\GetManifestRequest;
use Mediaopt\DHL\Api\GKV\Request\UpdateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\Request\ValidateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\Response\CreateShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\Response\DeleteShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\Response\DoManifestResponse;
use Mediaopt\DHL\Api\GKV\Response\GetExportDocResponse;
use Mediaopt\DHL\Api\GKV\Response\GetLabelResponse;
use Mediaopt\DHL\Api\GKV\Response\GetManifestResponse;
use Mediaopt\DHL\Api\GKV\Response\GetVersionResponse;
use Mediaopt\DHL\Api\GKV\Response\UpdateShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\Response\ValidateShipmentResponse;
use Mediaopt\DHL\Api\GKV\Shipment;
use Mediaopt\DHL\Api\GKV\Version;
use Mediaopt\DHL\Exception\WebserviceException;
use Psr\Log\LoggerInterface;

class GKV extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = [
        'AuthentificationType'                  => 'Mediaopt\\DHL\\Api\\GKV\\AuthenticationType',
        'CreateShipmentOrderRequest'            => 'Mediaopt\\DHL\\Api\\GKV\\Request\\CreateShipmentOrderRequest',
        'CreateShipmentOrderResponse'           => 'Mediaopt\\DHL\\Api\\GKV\\Response\\CreateShipmentOrderResponse',
        'Version'                               => 'Mediaopt\\DHL\\Api\\GKV\\Version',
        'ShipmentOrderType'                     => 'Mediaopt\\DHL\\Api\\GKV\\ShipmentOrderType',
        'Shipment'                              => 'Mediaopt\\DHL\\Api\\GKV\\Shipment',
        'ShipmentDetailsType'                   => 'Mediaopt\\DHL\\Api\\GKV\\ShipmentDetailsTypeType',
        'ShipmentItemType'                      => 'Mediaopt\\DHL\\Api\\GKV\\ShipmentItemType',
        'ShipmentService'                       => 'Mediaopt\\DHL\\Api\\GKV\\ShipmentService',
        'ServiceconfigurationDateOfDelivery'    => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationDateOfDelivery',
        'ServiceconfigurationDeliveryTimeframe' => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationDeliveryTimeframe',
        'ServiceconfigurationISR'                 => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationISR',
        'Serviceconfiguration'                    => 'Mediaopt\\DHL\\Api\\GKV\\Serviceconfiguration',
        'ServiceconfigurationShipmentHandling'    => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationShipmentHandling',
        'ServiceconfigurationEndorsement'         => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationEndorsement',
        'ServiceconfigurationVisualAgeCheck'      => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationVisualAgeCheck',
        'ServiceconfigurationDetails'             => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationDetails',
        'ServiceconfigurationCashOnDelivery'      => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationCashOnDelivery',
        'ServiceconfigurationAdditionalInsurance' => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationAdditionalInsurance',
        'ServiceconfigurationIC'                  => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationIC',
        'Ident'                               => 'Mediaopt\\DHL\\Api\\GKV\\Ident',
        'ServiceconfigurationDetailsOptional' => 'Mediaopt\\DHL\\Api\\GKV\\ServiceconfigurationDetailsOptional',
        'ShipmentNotificationType'            => 'Mediaopt\\DHL\\Api\\GKV\\ShipmentNotificationType',
        'BankType'                            => 'Mediaopt\\DHL\\Api\\GKV\\BankType',
        'ShipperType'                         => 'Mediaopt\\DHL\\Api\\GKV\\ShipperType',
        'NameType'                            => 'Mediaopt\\DHL\\Api\\GKV\\NameType',
        'NativeAddressType'                   => 'Mediaopt\\DHL\\Api\\GKV\\NativeAddressType',
        'CountryType'                         => 'Mediaopt\\DHL\\Api\\GKV\\CountryType',
        'CommunicationType'                   => 'Mediaopt\\DHL\\Api\\GKV\\CommunicationType',
        'ReceiverType'                        => 'Mediaopt\\DHL\\Api\\GKV\\ReceiverType',
        'ReceiverNativeAddressType'           => 'Mediaopt\\DHL\\Api\\GKV\\ReceiverNativeAddressType',
        'PackStationType'                     => 'Mediaopt\\DHL\\Api\\GKV\\PackStationType',
        'cis:PostfilialeType'                 => 'Mediaopt\\DHL\\Api\\GKV\\PostfilialeType',
        'ExportDocumentType'                  => 'Mediaopt\\DHL\\Api\\GKV\\ExportDocumentType',
        'ExportDocPosition'                   => 'Mediaopt\\DHL\\Api\\GKV\\ExportDocPosition',
        'Statusinformation'                   => 'Mediaopt\\DHL\\Api\\GKV\\Statusinformation',
        'CreationState'                       => 'Mediaopt\\DHL\\Api\\GKV\\CreationState',
        'LabelData'                           => 'Mediaopt\\DHL\\Api\\GKV\\LabelData',
        'ValidateShipmentOrderRequest'        => 'Mediaopt\\DHL\\Api\\GKV\\Request\\ValidateShipmentOrderRequest',
        'ValidateShipmentResponse'            => 'Mediaopt\\DHL\\Api\\GKV\\Response\\ValidateShipmentResponse',
        'ValidateShipmentOrderType'           => 'Mediaopt\\DHL\\Api\\GKV\\ValidateShipmentOrderType',
        'ValidationState'                     => 'Mediaopt\\DHL\\Api\\GKV\\ValidationState',
        'DeleteShipmentOrderRequest'          => 'Mediaopt\\DHL\\Api\\GKV\\Request\\DeleteShipmentOrderRequest',
        'DeleteShipmentOrderResponse'         => 'Mediaopt\\DHL\\Api\\GKV\\Response\\DeleteShipmentOrderResponse',
        'DeletionState'                           => 'Mediaopt\\DHL\\Api\\GKV\\DeletionState',
        'DoManifestRequest'                       => 'Mediaopt\\DHL\\Api\\GKV\\Request\\DoManifestRequest',
        'DoManifestResponse'                      => 'Mediaopt\\DHL\\Api\\GKV\\Response\\DoManifestResponse',
        'ManifestState'                           => 'Mediaopt\\DHL\\Api\\GKV\\ManifestState',
        'GetLabelRequest'                         => 'Mediaopt\\DHL\\Api\\GKV\\Request\\GetLabelRequest',
        'GetLabelResponse'                        => 'Mediaopt\\DHL\\Api\\GKV\\Response\\GetLabelResponse',
        'GetVersionResponse'                      => 'Mediaopt\\DHL\\Api\\GKV\\Response\\GetVersionResponse',
        'GetExportDocRequest'                     => 'Mediaopt\\DHL\\Api\\GKV\\Request\\GetExportDocRequest',
        'GetExportDocResponse'                    => 'Mediaopt\\DHL\\Api\\GKV\\Response\\GetExportDocResponse',
        'ExportDocData'                           => 'Mediaopt\\DHL\\Api\\GKV\\ExportDocData',
        'GetManifestRequest'                      => 'Mediaopt\\DHL\\Api\\GKV\\Request\\GetManifestRequest',
        'GetManifestResponse'                     => 'Mediaopt\\DHL\\Api\\GKV\\Response\\GetManifestResponse',
        'UpdateShipmentOrderRequest'              => 'Mediaopt\\DHL\\Api\\GKV\\Request\\UpdateShipmentOrderRequest',
        'UpdateShipmentOrderResponse'             => 'Mediaopt\\DHL\\Api\\GKV\\Response\\UpdateShipmentOrderResponse',
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
        $wsdl = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'GKV' . DIRECTORY_SEPARATOR . 'geschaeftskundenversand-api-3.3.2.wsdl';
        parent::__construct($wsdl, $options);
    }

    /**
     * @return Credentials
     */
    public function getSoapCredentials() : Credentials
    {
        return $this->soapCredentials;
    }

    /**
     * @return Credentials
     */
    public function getCustomerGKVCredentials() : Credentials
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
            $auth = new AuthenticationType($this->getCustomerGKVCredentials()->getUsername(), $this->getCustomerGKVCredentials()->getPassword());
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
        return new Version(3, 0);
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
