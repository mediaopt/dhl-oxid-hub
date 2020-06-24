<?php

class TestConfigurator extends \Mediaopt\DHL\Configurator
{
    protected function getProdLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PROD_API_USERNAME;
    }

    protected function getProdPassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PROD_API_PASSWORD;
    }

    protected function getSandboxLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_API_USERNAME;
    }

    protected function getSandboxPassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_API_PASSWORD;
    }

    protected function getCustomerGKVLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_GKV_USERNAME;
    }

    protected function getCustomerGKVPassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_GKV_PASSWORD;
    }

    protected function getCustomerRetoureLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_RETOURE_USERNAME;
    }

    protected function getCustomerRetourePassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_RETOURE_PASSWORD;
    }

    protected function getEkp()
    {
        return '2222222222';
    }

    protected function isProductionEnvironment()
    {
        return false;
    }

    public function getMapsApiKey()
    {
        return 'API-KEY';
    }

    protected function buildLogHandler()
    {
        return new Monolog\Handler\NullHandler();
    }
}
