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
