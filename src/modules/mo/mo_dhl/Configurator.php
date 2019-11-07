<?php

namespace Mediaopt\DHL;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Mediaopt\DHL\Api\Credentials;
use Mediaopt\DHL\Api\Standortsuche;
use Mediaopt\DHL\Api\Standortsuche\ServiceProviderBuilder;
use Mediaopt\DHL\Api\Wunschpaket;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * This class is used to configure the SDK.
 *
 * @author  derksen mediaopt GmbH
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
    protected function buildCredentials()
    {
        return $this->isProductionEnvironment()
            ? Credentials::createProductionEndpoint($this->getLogin(), $this->getPassword(), $this->getEkp())
            : Credentials::createSandboxEndpoint($this->getLogin(), $this->getPassword(), $this->getEkp());
    }

    /**
     * @return string
     */
    abstract protected function getLogin();

    /**
     * @return string
     */
    abstract protected function getPassword();

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
            $this->buildCredentials(),
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
            $this->buildCredentials(),
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
