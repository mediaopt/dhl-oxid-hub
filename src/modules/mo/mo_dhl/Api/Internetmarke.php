<?php


namespace Mediaopt\DHL\Api;

use Mediaopt\DHL\Api\Internetmarke\AuthenticateUserRequestType;
use Mediaopt\DHL\Api\Internetmarke\AuthenticateUserResponseType;
use Mediaopt\DHL\Api\Internetmarke\CreateShopOrderIdRequest;
use Mediaopt\DHL\Api\Internetmarke\CreateShopOrderIdResponse;
use Mediaopt\DHL\Api\Internetmarke\RetrieveContractProductsRequestType;
use Mediaopt\DHL\Api\Internetmarke\RetrieveContractProductsResponseType;
use Mediaopt\DHL\Api\Internetmarke\RetrieveOrderRequestType;
use Mediaopt\DHL\Api\Internetmarke\RetrieveOrderResponseType;
use Mediaopt\DHL\Api\Internetmarke\RetrievePageFormatsRequestType;
use Mediaopt\DHL\Api\Internetmarke\RetrievePageFormatsResponseType;
use Mediaopt\DHL\Api\Internetmarke\RetrievePreviewVoucherPDFRequestType;
use Mediaopt\DHL\Api\Internetmarke\RetrievePreviewVoucherResponseType;
use Mediaopt\DHL\Api\Internetmarke\RetrievePrivateGalleryRequestType;
use Mediaopt\DHL\Api\Internetmarke\RetrievePrivateGalleryResponseType;
use Mediaopt\DHL\Api\Internetmarke\RetrievePublicGalleryRequestType;
use Mediaopt\DHL\Api\Internetmarke\RetrievePublicGalleryResponseType;
use Mediaopt\DHL\Api\Internetmarke\ShoppingCartPDFRequestType;
use Mediaopt\DHL\Api\Internetmarke\ShoppingCartPNGRequestType;
use Mediaopt\DHL\Api\Internetmarke\ShoppingCartResponseType;
use Mediaopt\DHL\Exception\WebserviceException;
use Psr\Log\LoggerInterface;

class Internetmarke extends \SoapClient
{

    private $userToken = null;

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = [
        'AuthenticateUserRequestType'          => 'Mediaopt\\DHL\\Api\\Internetmarke\\AuthenticateUserRequestType',
        'AuthenticateUserResponseType'         => 'Mediaopt\\DHL\\Api\\Internetmarke\\AuthenticateUserResponseType',
        'RetrievePreviewVoucherPDFRequestType' => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrievePreviewVoucherPDFRequestType',
        'RetrievePreviewVoucherPNGRequestType' => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrievePreviewVoucherPNGRequestType',
        'RetrievePreviewVoucherResponseType'   => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrievePreviewVoucherResponseType',
        'MotiveLink'                           => 'Mediaopt\\DHL\\Api\\Internetmarke\\MotiveLink',
        'RetrievePrivateGalleryRequestType'    => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrievePrivateGalleryRequestType',
        'RetrievePrivateGalleryResponseType'   => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrievePrivateGalleryResponseType',
        'ShoppingCartResponseType'             => 'Mediaopt\\DHL\\Api\\Internetmarke\\ShoppingCartResponseType',
        'ShoppingCart'                         => 'Mediaopt\\DHL\\Api\\Internetmarke\\ShoppingCart',
        'VoucherList'                          => 'Mediaopt\\DHL\\Api\\Internetmarke\\VoucherList',
        'ShoppingCartPNGRequestType'           => 'Mediaopt\\DHL\\Api\\Internetmarke\\ShoppingCartPNGRequestType',
        'ShoppingCartPDFRequestType'           => 'Mediaopt\\DHL\\Api\\Internetmarke\\ShoppingCartPDFRequestType',
        'ShoppingCartValidationErrorInfo'      => 'Mediaopt\\DHL\\Api\\Internetmarke\\ShoppingCartValidationErrorInfo',
        'AuthenticateUserException'            => 'Mediaopt\\DHL\\Api\\Internetmarke\\AuthenticateUserException',
        'IdentifyException'                    => 'Mediaopt\\DHL\\Api\\Internetmarke\\IdentifyException',
        'InvalidProductException'              => 'Mediaopt\\DHL\\Api\\Internetmarke\\InvalidProductException',
        'InvalidPageFormatException'           => 'Mediaopt\\DHL\\Api\\Internetmarke\\InvalidPageFormatException',
        'InvalidMotiveException'               => 'Mediaopt\\DHL\\Api\\Internetmarke\\InvalidMotiveException',
        'ShoppingCartValidationException'      => 'Mediaopt\\DHL\\Api\\Internetmarke\\ShoppingCartValidationException',
        'RetrievePublicGalleryRequestType'     => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrievePublicGalleryRequestType',
        'RetrievePublicGalleryResponseType'    => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrievePublicGalleryResponseType',
        'ImageItem'                            => 'Mediaopt\\DHL\\Api\\Internetmarke\\ImageItem',
        'GalleryItem'                          => 'Mediaopt\\DHL\\Api\\Internetmarke\\GalleryItem',
        'Name'                                 => 'Mediaopt\\DHL\\Api\\Internetmarke\\Name',
        'PersonName'                           => 'Mediaopt\\DHL\\Api\\Internetmarke\\PersonName',
        'CompanyName'                          => 'Mediaopt\\DHL\\Api\\Internetmarke\\CompanyName',
        'Address'                              => 'Mediaopt\\DHL\\Api\\Internetmarke\\Address',
        'NamedAddress'                         => 'Mediaopt\\DHL\\Api\\Internetmarke\\NamedAddress',
        'ShoppingCartPosition'                 => 'Mediaopt\\DHL\\Api\\Internetmarke\\ShoppingCartPosition',
        'AddressBinding'                       => 'Mediaopt\\DHL\\Api\\Internetmarke\\AddressBinding',
        'RetrieveOrderException'               => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrieveOrderException',
        'RetrieveOrderRequestType'             => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrieveOrderRequestType',
        'RetrieveOrderResponseType'            => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrieveOrderResponseType',
        'VoucherPosition'                      => 'Mediaopt\\DHL\\Api\\Internetmarke\\VoucherPosition',
        'Position'                             => 'Mediaopt\\DHL\\Api\\Internetmarke\\Position',
        'ShoppingCartPDFPosition'              => 'Mediaopt\\DHL\\Api\\Internetmarke\\ShoppingCartPDFPosition',
        'CreateShopOrderIdRequest'             => 'Mediaopt\\DHL\\Api\\Internetmarke\\CreateShopOrderIdRequest',
        'CreateShopOrderIdResponse'            => 'Mediaopt\\DHL\\Api\\Internetmarke\\CreateShopOrderIdResponse',
        'VoucherType'                          => 'Mediaopt\\DHL\\Api\\Internetmarke\\VoucherType',
        'RetrievePageFormatsRequestType'       => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrievePageFormatsRequestType',
        'RetrievePageFormatsResponseType'      => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrievePageFormatsResponseType',
        'PageFormat'                           => 'Mediaopt\\DHL\\Api\\Internetmarke\\PageFormat',
        'pageLayout'                           => 'Mediaopt\\DHL\\Api\\Internetmarke\\pageLayout',
        'BorderDimension'                      => 'Mediaopt\\DHL\\Api\\Internetmarke\\BorderDimension',
        'Dimension'                            => 'Mediaopt\\DHL\\Api\\Internetmarke\\Dimension',
        'RetrieveContractProductsRequestType'  => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrieveContractProductsRequestType',
        'RetrieveContractProductsResponseType' => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrieveContractProductsResponseType',
        'ContractProductResponseType'          => 'Mediaopt\\DHL\\Api\\Internetmarke\\ContractProductResponseType',
    ];

    /**
     * @var Credentials
     */
    protected $soapCredentials;

    /**
     * @var Credentials
     */
    protected $customerCredentials;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Credentials     $credentials
     * @param Credentials     $customerCredentials
     * @param LoggerInterface $logger
     * @throws \SoapFault
     */
    public function __construct(Credentials $credentials, Credentials $customerCredentials, LoggerInterface $logger)
    {
        $this->soapCredentials = $credentials;
        $this->customerCredentials = $customerCredentials;
        $this->logger = $logger;
        $options = [
            'features' => 1,
            'classmap' => self::$classmap,
        ];
        $wsdl = 'https://internetmarke.deutschepost.de/OneClickForAppV3?wsdl';
        parent::__construct($wsdl, $options);
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
        $this->addUserTokenIfNecessary($request);
        $this->getLogger()->debug(__METHOD__ . " - SOAP API call for function  $functionName", ['options' => $request]);
        try {
            return $this->__soapCall($functionName, [$request], null, $this->createAuthorizationHeader());
        } catch (\SoapFault $exception) {
            $message = __METHOD__ . " - The SOAP API call for function  $functionName failed due to {$exception->getMessage()}";
            $this->getLogger()->error($message, ['exception' => $exception]);
            throw new WebserviceException('Failed API call.', 0, $exception);
        }
    }

    /**
     * @param RetrieveContractProductsRequestType $parameter
     * @return RetrieveContractProductsResponseType
     */
    public function retrieveContractProducts(RetrieveContractProductsRequestType $parameter)
    {
        return $this->callSoap('retrieveContractProducts', $parameter);
    }

    /**
     * @param RetrievePageFormatsRequestType $parameter
     * @return RetrievePageFormatsResponseType
     */
    public function retrievePageFormats(RetrievePageFormatsRequestType $parameter)
    {
        return $this->callSoap('retrievePageFormats', $parameter);
    }

    /**
     * @param RetrievePublicGalleryRequestType $parameter
     * @return RetrievePublicGalleryResponseType
     */
    public function retrievePublicGallery(RetrievePublicGalleryRequestType $parameter)
    {
        return $this->callSoap('retrievePublicGallery', $parameter);
    }

    /**
     * @param ShoppingCartPDFRequestType $parameter
     * @return ShoppingCartResponseType
     */
    public function checkoutShoppingCartPDF(ShoppingCartPDFRequestType $parameter)
    {
        return $this->callSoap('checkoutShoppingCartPDF', $parameter);
    }

    /**
     * @param ShoppingCartPNGRequestType $parameter
     * @return ShoppingCartResponseType
     */
    public function checkoutShoppingCartPNG(ShoppingCartPNGRequestType $parameter)
    {
        return $this->callSoap('checkoutShoppingCartPNG', $parameter);
    }

    /**
     * @return AuthenticateUserResponseType
     */
    public function authenticateUser()
    {
        $request = new AuthenticateUserRequestType($this->customerCredentials->getUsername(), $this->customerCredentials->getPassword());
        return $this->callSoap('authenticateUser', $request);
    }

    /**
     * @param RetrievePreviewVoucherPDFRequestType $parameter
     * @return RetrievePreviewVoucherResponseType
     */
    public function retrievePreviewVoucherPDF(RetrievePreviewVoucherPDFRequestType $parameter)
    {
        return $this->callSoap('retrievePreviewVoucherPDF', $parameter);
    }

    /**
     * @param RetrievePreviewVoucherPNGRequestType $parameter
     * @return RetrievePreviewVoucherResponseType
     */
    public function retrievePreviewVoucherPNG(RetrievePreviewVoucherPNGRequestType $parameter)
    {
        return $this->callSoap('retrievePreviewVoucherPNG', $parameter);
    }

    /**
     * @param RetrievePrivateGalleryRequestType $parameter
     * @return RetrievePrivateGalleryResponseType
     */
    public function retrievePrivateGallery(RetrievePrivateGalleryRequestType $parameter)
    {
        return $this->callSoap('retrievePrivateGallery', $parameter);
    }

    /**
     * @param RetrieveOrderRequestType $parameter
     * @return RetrieveOrderResponseType
     */
    public function retrieveOrder(RetrieveOrderRequestType $parameter)
    {
        return $this->callSoap('retrieveOrder', $parameter);
    }

    /**
     * @param CreateShopOrderIdRequest $createShopOrderIdRequest
     * @return CreateShopOrderIdResponse
     */
    public function createShopOrderId(CreateShopOrderIdRequest $createShopOrderIdRequest)
    {
        return $this->callSoap('createShopOrderId', $createShopOrderIdRequest);
    }

    /**
     * @return mixed
     */
    public function getUserToken()
    {
        if ($this->userToken === null) {
            $response = $this->authenticateUser();
            $this->userToken = $response->getUserToken();
        }
        return $this->userToken;
    }

    /**
     * @return \SoapHeader[]
     */
    protected function createAuthorizationHeader() : array
    {
        $timestamp = date('dmY-His');
        $soapUsername = $this->soapCredentials->getUsername();
        $soapPassword = $this->soapCredentials->getPassword();
        $keyPhase = '1';
        $hash = substr(md5("$soapUsername::$timestamp::$keyPhase::$soapPassword"), 0, 8);
        return [
            new \SoapHeader('http://oneclickforapp.dpag.de/V3', 'PARTNER_ID', $soapUsername),
            new \SoapHeader('http://oneclickforapp.dpag.de/V3', 'REQUEST_TIMESTAMP', $timestamp),
            new \SoapHeader('http://oneclickforapp.dpag.de/V3', 'KEY_PHASE', $keyPhase),
            new \SoapHeader('http://oneclickforapp.dpag.de/V3', 'PARTNER_SIGNATURE', $hash),
        ];
    }

    /**
     * @param $request
     */
    protected function addUserTokenIfNecessary(&$request)
    {
        if (method_exists($request, 'getUserToken') && method_exists($request, 'setUserToken') && !$request->getUserToken()) {
            $request->setUserToken($this->getUserToken());
        }
    }

}
