<?php

class TestConfigurator extends \Mediaopt\DHL\Configurator
{

    /**
     * @return string
     */
    protected function getProdLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PROD_API_USERNAME;
    }

    /**
     * @return string
     */
    protected function getProdPassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PROD_API_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getSandboxLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_API_USERNAME;
    }

    /**
     * @return string
     */
    protected function getSandboxPassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_API_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getCustomerGKVLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_GKV_USERNAME;
    }

    /**
     * @return string
     */
    protected function getCustomerGKVPassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_GKV_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getCustomerRetoureLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_RETOURE_USERNAME;
    }

    /**
     * @return string
     */
    protected function getCustomerRetourePassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_RETOURE_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getEkp()
    {
        return '2222222222';
    }

    /**
     * @return string
     */
    protected function getInternetmarkeProdLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PROD_INTERNETMARKE_PARTNER_ID;
    }

    /**
     * @return string
     */
    protected function getInternetmarkeProdSignature()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PROD_INTERNETMARKE_SIGNATURE;
    }

    /**
     * @return string
     */
    protected function getInternetmarkeSandboxLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_INTERNETMARKE_PARTNER_ID;
    }

    /**
     * @return string
     */
    protected function getInternetmarkeSandboxSignature()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_INTERNETMARKE_SIGNATURE;
    }

    /**
     * @return string
     */
    protected function getCustomerInternetmarkeLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_INTERNETMARKE_USERNAME;
    }

    /**
     * @return string
     */
    protected function getCustomerInternetmarkePassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_INTERNETMARKE_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getProdWSLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PRODWS_USERNAME;
    }

    /**
     * @return string
     */
    protected function getProdWSPassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PRODWS_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getCustomerProdWSMandantId()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_PRODWS_MANDANT_ID;
    }

    /**
     * @return bool
     */
    protected function isProductionEnvironment()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getMapsApiKey()
    {
        return 'API-KEY';
    }

    /**
     * @return \Monolog\Handler\HandlerInterface|\Monolog\Handler\NullHandler
     */
    protected function buildLogHandler()
    {
        return new Monolog\Handler\NullHandler();
    }
}
