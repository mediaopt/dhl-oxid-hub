<?php

namespace Mediaopt\DHL;

use GuzzleHttp\ClientInterface;
use Mediaopt\DHL\Api\Internetmarke;
use Mediaopt\DHL\Api\InternetmarkeRefund;
use Mediaopt\DHL\Api\ParcelShipping\Client;
use Mediaopt\DHL\Api\ProdWSService;
use Mediaopt\DHL\Api\Standortsuche;
use Mediaopt\DHL\Api\Wunschpaket;
use Psr\Log\LoggerInterface;

/**
 * This class grants access to the SDK.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
class Main
{
    /**
     * @var Configurator
     */
    protected $configurator;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @param \Mediaopt\DHL\Configurator $configurator
     */
    public function __construct(Configurator $configurator)
    {
        $this->setConfigurator($configurator);
        $this->setLogger($this->getConfigurator()->buildLogger());
        $this->setClient($this->getConfigurator()->buildClient());
    }

    /**
     * @see $configurator
     * @return Configurator
     */
    public function getConfigurator()
    {
        return $this->configurator;
    }

    /**
     * @param Configurator $configurator
     * @return $this
     */
    public function setConfigurator(Configurator $configurator)
    {
        $this->configurator = $configurator;
        return $this;
    }

    /**
     * @see $logger
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param ClientInterface $client
     * @return $this
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return Standortsuche
     */
    public function buildStandortsuche()
    {
        return $this->getConfigurator()->buildStandortsuche($this->getLogger(), $this->getClient());
    }

    /**
     * @return Wunschpaket
     */
    public function buildWunschpaket()
    {
        return $this->getConfigurator()->buildWunschpaket($this->getLogger(), $this->getClient());
    }

    /**
     * @return Api\Retoure
     */
    public function buildRetoure()
    {
        return $this->getConfigurator()->buildRetoure($this->getLogger());
    }

    /**
     * @return InternetmarkeRefund
     */
    public function buildInternetmarkeRefund()
    {
        return $this->getConfigurator()->buildInternetmarkeRefund($this->getLogger());
    }

    /**
     * @return Internetmarke
     */
    public function buildInternetmarke()
    {
        return $this->getConfigurator()->buildInternetmarke($this->getLogger());
    }

    /**
     * @return ProdWSService
     */
    public function buildProdWS()
    {
        return $this->getConfigurator()->buildProdWS($this->getLogger());
    }

    /**
     * @return Client
     */
    public function buildParcelShipping(): Client
    {
        return $this->getConfigurator()->buildParcelShipping($this->getLogger());
    }

    /**
     * @return Api\MyAccount\Client
     */
    public function buildMyAccount(): Api\MyAccount\Client
    {
        return $this->getConfigurator()->buildMyAccount($this->getLogger());
    }
}
