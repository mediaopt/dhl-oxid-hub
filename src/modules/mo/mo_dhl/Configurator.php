<?php

namespace Mediaopt\DHL;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Mediaopt\DHL\Api\Credentials;
use Mediaopt\DHL\Api\Internetmarke;
use Mediaopt\DHL\Api\InternetmarkeRefund;
use Mediaopt\DHL\Api\ProdWSService;
use Mediaopt\DHL\Api\Retoure;
use Mediaopt\DHL\Api\Standortsuche;
use Mediaopt\DHL\Api\Standortsuche\ServiceProviderBuilder;
use Mediaopt\DHL\Api\Wunschpaket;
use Mediaopt\DHL\Api\GKV;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

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
     * @param false $forceUseProd
     * @return Credentials
     */
    protected function buildStandortsucheCredentials($forceUseProd = false)
    {
        return $this->isProductionEnvironment() || $forceUseProd
            ? Credentials::createStandortsucheEndpoint($this->getStandortsucheKeyName(), $this->getProdStandortsuchePassword())
            : Credentials::createStandortsucheEndpoint($this->getStandortsucheKeyName(), $this->getSandboxStandortsuchePassword());
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
        return Credentials::createCustomerCredentials($this->getCustomerInternetmarkeLogin(), $this->getCustomerInternetmarkePassword());
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
    abstract protected function getCustomerInternetmarkeLogin();

    /**
     * @return string
     */
    abstract protected function getCustomerInternetmarkePassword();

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
    abstract protected function getProdStandortsuchePassword();

    /**
     * @return string
     */
    abstract protected function getSandboxStandortsuchePassword();

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
        LoggerInterface $logger = null,
        ClientInterface $client = null,
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
     * @param LoggerInterface|null $logger
     * @return GKV
     */
    public function buildGKV(LoggerInterface $logger = null)
    {
        return new GKV(
            $this->buildSoapCredentials(),
            $this->buildCustomerGKVCredentials(),
            $logger ?: $this->buildLogger()
        );
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
