<?php

namespace Mediaopt\DHL;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Mediaopt\DHL\Api\Credentials;
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
    protected function buildRestCredentials()
    {
        return Credentials::createProductionRestEndpoint($this->getRestLogin(), $this->getRestPassword(), $this->getEkp());
    }

    /**
     * @return Credentials
     */
    protected function buildSoapCredentials()
    {
        return $this->isProductionEnvironment()
            ? Credentials::createProductionSoapEndpoint($this->getSoapLogin(), $this->getSoapPassword(), $this->getEkp())
            : Credentials::createSandboxSoapEndpoint($this->getSoapLogin(), $this->getSoapPassword(), $this->getEkp());
    }

    /**
     * @return string
     */
    abstract protected function getSoapLogin();

    /**
     * @return string
     */
    abstract protected function getSoapPassword();

    /**
     * @return string
     */
    abstract protected function getRestLogin();

    /**
     * @return string
     */
    abstract protected function getRestPassword();

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
            $this->buildRestCredentials(),
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
            $this->buildRestCredentials(),
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
            $logger ?: $this->buildLogger()
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
