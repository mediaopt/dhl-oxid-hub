<?php

class TestConfigurator extends \Mediaopt\DHL\Configurator
{
    protected function getRestLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PROD_API_USERNAME;
    }

    protected function getRestPassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PROD_API_PASSWORD;
    }

    protected function getSoapLogin()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_API_USERNAME;
    }

    protected function getSoapPassword()
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
