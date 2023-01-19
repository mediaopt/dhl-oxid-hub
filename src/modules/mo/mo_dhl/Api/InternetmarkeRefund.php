<?php

namespace Mediaopt\DHL\Api;

use Mediaopt\DHL\Api\Internetmarke\AuthenticateUserRequestTypeCustom;
use Mediaopt\DHL\Api\Internetmarke\AuthenticateUserResponseType;
use Mediaopt\DHL\Api\Internetmarke\CreateRetoureIdResponse;
use Mediaopt\DHL\Api\Internetmarke\RetoureVouchersRequestType;
use Mediaopt\DHL\Api\Internetmarke\RetoureVouchersResponseType;
use Mediaopt\DHL\Api\Internetmarke\RetrieveRetoureStateRequestType;
use Mediaopt\DHL\Api\Internetmarke\RetrieveRetoureStateResponseType;
use Mediaopt\DHL\Exception\WebserviceException;
use Psr\Log\LoggerInterface;

class InternetmarkeRefund extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array(
        'AuthenticateUserRequestType'      => 'Mediaopt\\DHL\\Api\\Internetmarke\\AuthenticateUserRequestTypeCustom',
        'AuthenticateUserResponseType'     => 'Mediaopt\\DHL\\Api\\Internetmarke\\AuthenticateUserResponseTypeCustom',
        'AuthenticateUserException'        => 'Mediaopt\\DHL\\Api\\Internetmarke\\AuthenticateUserExceptionCustom',
        'CreateRetoureIdException'         => 'Mediaopt\\DHL\\Api\\Internetmarke\\CreateRetoureIdException',
        'RetrieveRetoureStateRequestType'  => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrieveRetoureStateRequestType',
        'RetrieveRetoureStateResponseType' => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetrieveRetoureStateResponseType',
        'RetoureStateType'                 => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetoureStateType',
        'VoucherList'                      => 'Mediaopt\\DHL\\Api\\Internetmarke\\VoucherListCustom',
        'VoucherType'                      => 'Mediaopt\\DHL\\Api\\Internetmarke\\VoucherTypeCustom',
        'RetoureVouchersRequestType'       => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetoureVouchersRequestType',
        'ShoppingCartType'                 => 'Mediaopt\\DHL\\Api\\Internetmarke\\ShoppingCartType',
        'VoucherSetType'                   => 'Mediaopt\\DHL\\Api\\Internetmarke\\VoucherSetType',
        'RetoureVouchersResponseType'      => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetoureVouchersResponseType',
        'RetoureVoucherException'          => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetoureVoucherException',
        'RetoureVoucherErrorInfo'          => 'Mediaopt\\DHL\\Api\\Internetmarke\\RetoureVoucherErrorInfo',
        'CreateRetoureIdResponse'          => 'Mediaopt\\DHL\\Api\\Internetmarke\\CreateRetoureIdResponse',
    );

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
        $wsdl = 'https://internetmarke.deutschepost.de/OneClickForRefund?wsdl';
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
            return $this->__soapCall($functionName, $request ? [$request] : [], null, $this->createAuthorizationHeader());
        } catch (\SoapFault $exception) {
            $message = __METHOD__ . " - The SOAP API call for function  $functionName failed due to {$exception->getMessage()}";
            $this->getLogger()->error($message, ['exception' => $exception]);
            throw new WebserviceException('Failed API call.', 0, $exception);
        }
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
            new \SoapHeader('http://oneclickforrefund.dpag.de', 'PARTNER_ID', $soapUsername),
            new \SoapHeader('http://oneclickforrefund.dpag.de', 'REQUEST_TIMESTAMP', $timestamp),
            new \SoapHeader('http://oneclickforrefund.dpag.de', 'KEY_PHASE', $keyPhase),
            new \SoapHeader('http://oneclickforrefund.dpag.de', 'PARTNER_SIGNATURE', $hash),
        ];
    }

    /**
     * @return AuthenticateUserResponseType
     */
    public function authenticateUser()
    {
        $parameter = new AuthenticateUserRequestTypeCustom($this->customerCredentials->getUsername(), $this->customerCredentials->getPassword());
        return $this->callSoap('authenticateUser', $parameter);
    }

    /**
     * @return CreateRetoureIdResponse
     */
    public function createRetoureId()
    {
        return $this->callSoap('createRetoureId', null);
    }

    /**
     * @param RetrieveRetoureStateRequestType $parameter
     * @return RetrieveRetoureStateResponseType
     */
    public function retrieveRetoureState(RetrieveRetoureStateRequestType $parameter)
    {
        return $this->callSoap('retrieveRetoureState', $parameter);
    }

    /**
     * @param RetoureVouchersRequestType $parameter
     * @return RetoureVouchersResponseType
     */
    public function retoureVouchers(RetoureVouchersRequestType $parameter)
    {
        return $this->callSoap('retoureVouchers', $parameter);
    }

    /**
     * @param $request
     */
    protected function addUserTokenIfNecessary(&$request)
    {
        if (isset($request) && method_exists($request, 'getUserToken') && method_exists($request, 'setUserToken') && !$request->getUserToken()) {
            $request->setUserToken($this->getUserToken());
        }
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
}
