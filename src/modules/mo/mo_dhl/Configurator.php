<?php

namespace Mediaopt\DHL;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Mediaopt\DHL\Api\Authentication;
use Mediaopt\DHL\Api\Credentials;
use Mediaopt\DHL\Api\Internetmarke;
use Mediaopt\DHL\Api\InternetmarkeRefund;
use Mediaopt\DHL\Api\MyAccount;
use Mediaopt\DHL\Api\ParcelShipping\Authentication\ApiKeyAuthentication;
use Mediaopt\DHL\Api\ParcelShipping\Authentication\BasicAuthAuthentication;
use Mediaopt\DHL\Api\ProdWSService;
use Mediaopt\DHL\Api\Retoure;
use Mediaopt\DHL\Api\Standortsuche;
use Mediaopt\DHL\Api\Standortsuche\ServiceProviderBuilder;
use Mediaopt\DHL\Api\Wunschpaket;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\RequestInterface;

/**
 * This class is used to configure the SDK.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
abstract class Configurator
{
    /**
     * Returns true iff the production endpoint is to be used.
     *
     * @return boolean
     */
    abstract protected function isProductionEnvironment();

    /**
     * @return Credentials
     */
    protected function buildRestCredentials($forceUseProd = false)
    {
        return $this->isProductionEnvironment() || $forceUseProd
            ? Credentials::createProductionRestEndpoint($this->getProdLogin(), $this->getProdPassword(), $this->getEkp())
            : Credentials::createSandboxRestEndpoint($this->getSandboxLogin(), $this->getSandboxPassword(), $this->getEkp());
    }

    /**
     * @return Credentials
     */
    protected function buildStandortsucheCredentials()
    {
        return Credentials::createStandortsucheEndpoint($this->getStandortsucheKeyName(), $this->getStandortsuchePassword());
    }

    /**
     * @return Credentials
     */
    protected function buildSoapCredentials()
    {
        return $this->isProductionEnvironment()
            ? Credentials::createProductionSoapEndpoint($this->getProdLogin(), $this->getProdPassword(), $this->getEkp())
            : Credentials::createSandboxSoapEndpoint($this->getSandboxLogin(), $this->getSandboxPassword(), $this->getEkp());
    }

    /**
     * @return Credentials
     */
    protected function buildCustomerGKVCredentials()
    {
        return Credentials::createCustomerCredentials($this->getCustomerGKVLogin(), $this->getCustomerGKVPassword());
    }

    /**
     * @return Credentials
     */
    protected function buildParcelShippingCredentials(): Credentials
    {
        $username = $this->getCustomerParcelShippingUsername();
        $password = $this->getCustomerParcelShippingPassword();
        $apiKey = $this->getParcelShippingApiKey();
        return $this->isProductionEnvironment()
            ? Credentials::createProductionParcelShippingCredentials($username, $password, $apiKey)
            : Credentials::createSandboxParcelShippingCredentials($username, $password, $apiKey);
    }

    /**
     * @return Credentials
     */
    protected function buildAuthenticationCredentials(): Credentials
    {
        $clientId = $this->getAuthenticationClientId();
        $clientSecret = $this->getAuthenticationClientSecret();
        return $this->isProductionEnvironment()
            ? Credentials::createProductionAuthenticationCredentials($clientId, $clientSecret)
            : Credentials::createSandboxAuthenticationCredentials($clientId, $clientSecret);
    }

    /**
     * @return Credentials
     */
    protected function buildAuthenticationUserCredentials(): Credentials
    {
        $username = $this->getAuthenticationUsername();
        $password = $this->getAuthenticationPassword();
        return $this->isProductionEnvironment()
            ? Credentials::createProductionAuthenticationCredentials($username, $password)
            : Credentials::createSandboxAuthenticationCredentials($username, $password);
    }

    /**
     * @return Credentials
     */
    protected function buildMyAccountCredentials(): Credentials
    {
        return $this->isProductionEnvironment()
            ? Credentials::createProductionMyAccountCredentials()
            : Credentials::createSandboxMyAccountCredentials();
    }

    /**
     * @return Credentials
     */
    protected function buildInternetmarkeCredentials()
    {
        return $this->isProductionEnvironment()
            ? Credentials::createProductionInternetmarkeEndpoint($this->getInternetmarkeProdLogin(), $this->getInternetmarkeProdSignature())
            : Credentials::createSandboxInternetmarkeEndpoint($this->getInternetmarkeSandboxLogin(), $this->getInternetmarkeSandboxSignature());
    }

    /**
     * @return Credentials
     */
    protected function buildCustomerInternetmarkeCredentials()
    {
        return Credentials::createCustomerCredentials($this->getCustomerPortokasseProdLogin(), $this->getCustomerPortokasseProdPassword());
    }

    /**
     * @return Credentials
     */
    protected function buildProdWSCredentials()
    {
        return Credentials::createProdWSEndpoint($this->getProdWSLogin(), $this->getProdWSPassword());
    }

    /**
     * @return Credentials
     */
    protected function buildCustomerProdWSCredentials()
    {
        return Credentials::createCustomerCredentials($this->getCustomerProdWSMandantId(), null);
    }

    /**
     * @return Credentials
     */
    protected function buildCustomerRetoureCredentials()
    {
        return Credentials::createCustomerCredentials($this->getCustomerRetoureLogin(), $this->getCustomerRetourePassword());
    }

    /**
     * @return string
     */
    abstract protected function getSandboxLogin();

    /**
     * @return string
     */
    abstract protected function getSandboxPassword();

    /**
     * @return string
     */
    abstract protected function getCustomerGKVLogin();

    /**
     * @return string
     */
    abstract protected function getCustomerGKVPassword();

    /**
     * @return string
     */
    abstract protected function getParcelShippingApiKey();

    /**
     * @return string
     */
    abstract protected function getCustomerParcelShippingUsername();

    /**
     * @return string
     */
    abstract protected function getCustomerParcelShippingPassword();

    /**
     * @return string
     */
    abstract protected function getAuthenticationClientId();

    /**
     * @return string
     */
    abstract protected function getAuthenticationClientSecret();

    /**
     * @return string
     */
    abstract protected function getAuthenticationUsername();

    /**
     * @return string
     */
    abstract protected function getAuthenticationPassword();

    /**
     * @return string
     */
    abstract protected function getInternetmarkeProdLogin();

    /**
     * @return string
     */
    abstract protected function getInternetmarkeProdSignature();

    /**
     * @return string
     */
    abstract protected function getInternetmarkeSandboxLogin();

    /**
     * @return string
     */
    abstract protected function getInternetmarkeSandboxSignature();

    /**
     * @return string
     */
    abstract protected function getCustomerPortokasseProdLogin(): string;

    /**
     * @return string
     */
    abstract protected function getCustomerPortokasseProdPassword(): string;

    /**
     * @return string
     */
    abstract protected function getCustomerPortokasseSandboxLogin(): string;

    /**
     * @return string
     */
    abstract protected function getCustomerPortokasseSandboxPassword(): string;

    /**
     * @return string
     */
    abstract protected function getCustomerProdWSMandantId();

    /**
     * @return string
     */
    abstract protected function getProdWSLogin();

    /**
     * @return string
     */
    abstract protected function getProdWSPassword();

    /**
     * @return string
     */
    abstract protected function getCustomerRetoureLogin();

    /**
     * @return string
     */
    abstract protected function getCustomerRetourePassword();

    /**
     * @return string
     */
    abstract protected function getProdLogin();

    /**
     * @return string
     */
    abstract protected function getProdPassword();

    /**
     * @return string
     */
    abstract protected function getStandortsucheKeyName();

    /**
     * @return string
     */
    abstract protected function getStandortsuchePassword();

    /**
     * @return string
     */
    abstract protected function getEkp();

    /**
     * @param LoggerInterface|null        $logger
     * @param ClientInterface|null        $client
     * @param ServiceProviderBuilder|null $serviceProviderBuilder
     * @return Standortsuche
     */
    public function buildStandortsuche(
        LoggerInterface        $logger = null,
        ClientInterface        $client = null,
        ServiceProviderBuilder $serviceProviderBuilder = null
    ) {
        return new Standortsuche(
            $this->buildStandortsucheCredentials(),
            $logger ?: $this->buildLogger(),
            $client ?: $this->buildClient(),
            $serviceProviderBuilder
        );
    }

    /**
     * @param LoggerInterface|null $logger
     * @param ClientInterface|null $client
     * @return Wunschpaket
     */
    public function buildWunschpaket(LoggerInterface $logger = null, ClientInterface $client = null)
    {
        return new Wunschpaket(
            $this->buildRestCredentials(true),
            $logger ?: $this->buildLogger(),
            $client ?: $this->buildClient()
        );
    }

    /**
     * @param LoggerInterface $logger
     * @return Api\ParcelShipping\Client
     */
    public function buildParcelShipping(LoggerInterface $logger = null): \Mediaopt\DHL\Api\ParcelShipping\Client
    {
        $credentials = $this->buildParcelShippingCredentials();

        $httpClient = \Http\Discovery\Psr18ClientDiscovery::find();
        $uri = \Http\Discovery\Psr17FactoryDiscovery::findUriFactory()->createUri($credentials->getEndpoint());

        $apiKeyAuthentication = new ApiKeyAuthentication($credentials->getAdditionalFields()['api-key']);
        $basicAuthentication = new BasicAuthAuthentication($credentials->getUsername(), $credentials->getPassword());
        $loggingPlugin = new class($logger ?: $this->buildLogger()) implements Plugin {
            private $logger;

            public function __construct(LoggerInterface $logger)
            {
                $this->logger = $logger;
            }

            public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
            {
                $context = [
                    'method' => $request->getMethod(),
                    'url'    => (string)$request->getUri(),
                    'body'   => $request->getBody()->getContents(),
                ];
                $this->logger->debug('Parcel Shipping API Call', $context);
                return $next($request);
            }
        };
        $registry = new \Jane\Component\OpenApiRuntime\Client\Plugin\AuthenticationRegistry([$apiKeyAuthentication, $basicAuthentication]);
        $plugins = [
            new \Http\Client\Common\Plugin\AddHostPlugin($uri),
            new \Http\Client\Common\Plugin\AddPathPlugin($uri),
            $registry,
            $loggingPlugin,
        ];
        $httpClient = new \Http\Client\Common\PluginClient($httpClient, $plugins);
        return \Mediaopt\DHL\Api\ParcelShipping\Client::create($httpClient);
    }

    /**
     * @param LoggerInterface $logger
     * @return Api\MyAccount\Client
     */
    public function buildMyAccount(LoggerInterface  $logger): Api\MyAccount\Client
    {
        $token = $this->buildAuthenticationToken($logger) ;
        $credentials = $this->buildMyAccountCredentials();
        $bearerAuthentication = new Authentication\Authentication\BearerAuthAuthentication($token);
        $httpClient = \Http\Discovery\Psr18ClientDiscovery::find();
        $uri = \Http\Discovery\Psr17FactoryDiscovery::findUriFactory()->createUri($credentials->getEndpoint());

        $plugins = [
            new \Http\Client\Common\Plugin\AddHostPlugin($uri),
            new \Http\Client\Common\Plugin\AddPathPlugin($uri),
            new \Jane\Component\OpenApiRuntime\Client\Plugin\AuthenticationRegistry([$bearerAuthentication]),
            MyAccount::getMyAccountLoggingPlugin($logger),
        ];
        $httpClient = new \Http\Client\Common\PluginClient($httpClient, $plugins);

        return \Mediaopt\DHL\Api\MyAccount\Client::create($httpClient);
    }

    /**
     * @param LoggerInterface $logger
     * @return string
     */
    private function buildAuthenticationToken(LoggerInterface $logger): string
    {
        $credentials = $this->buildAuthenticationCredentials();
        $userPass = $this->buildAuthenticationUserCredentials();
        $httpClient = \Http\Discovery\Psr18ClientDiscovery::find();
        $plugins = array();
        $uri = \Http\Discovery\Psr17FactoryDiscovery::findUriFactory()->createUri($credentials->getEndpoint());
        $plugins[] = new \Http\Client\Common\Plugin\AddHostPlugin($uri);
        $plugins[] = new \Http\Client\Common\Plugin\AddPathPlugin($uri);
        $httpClient = new \Http\Client\Common\PluginClient($httpClient, $plugins);
        $authClient = Authentication\Client::create($httpClient);
        return Authentication::getToken($authClient, $credentials, $userPass);
    }

    /**
     * @param LoggerInterface|null $logger
     * @return Internetmarke
     */
    public function buildInternetmarke(LoggerInterface $logger = null)
    {
        return new Internetmarke(
            $this->buildInternetmarkeCredentials(),
            $this->buildCustomerInternetmarkeCredentials(),
            $logger ?: $this->buildLogger()
        );
    }

    /**
     * @param LoggerInterface|null $logger
     * @return InternetmarkeRefund
     */
    public function buildInternetmarkeRefund(LoggerInterface $logger = null)
    {
        return new InternetmarkeRefund(
            $this->buildInternetmarkeCredentials(),
            $this->buildCustomerInternetmarkeCredentials(),
            $logger ?: $this->buildLogger()
        );
    }

    /**
     * @param LoggerInterface|null $logger
     * @return ProdWSService
     */
    public function buildProdWS(LoggerInterface $logger = null)
    {
        return new ProdWSService(
            $this->buildProdWSCredentials(),
            $this->buildCustomerProdWSCredentials(),
            $logger ?: $this->buildLogger()
        );
    }

    /**
     * @param LoggerInterface|null $logger
     * @param ClientInterface|null $client
     * @return Retoure
     */
    public function buildRetoure(LoggerInterface $logger = null, ClientInterface $client = null)
    {
        return new Retoure(
            $this->buildRestCredentials(),
            $this->buildCustomerRetoureCredentials(),
            $logger ?: $this->buildLogger(),
            $client ?: $this->buildClient()
        );
    }

    /**
     * @return \Monolog\Handler\HandlerInterface
     */
    abstract protected function buildLogHandler();

    /**
     * @return Logger
     */
    public function buildLogger()
    {
        $logger = new Logger($this->getName());
        $logger->pushHandler($this->buildLogHandler());
        return $logger;
    }

    /**
     * @return Client
     */
    public function buildClient()
    {
        return new Client();
    }

    /**
     * Returns the API key used for displaying service providers on a map.
     *
     * @return string
     */
    abstract public function getMapsApiKey();

    /**
     * @return string for instance, this name is used for the logger
     */
    public function getName()
    {
        return 'empfaengerservices';
    }
}
