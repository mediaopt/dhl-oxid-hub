<?php

class TestConfigurator extends \Mediaopt\DHL\Configurator
{
    protected function getRestLogin()
    {
        return 'DHL_Oxid_2';
    }

    protected function getRestPassword()
    {
        return '0qy7vU4ubYUHgU5ppBsG2jIh48j9nO';
    }

    protected function getSoapLogin()
    {
        return 'moptrandom-temp-string-1455964747901';
    }

    protected function getSoapPassword()
    {
        return 'H#R#__!w4-dt-9++9Z-r7-9';
    }

    protected function getCustomerGKVLogin()
    {
        return '2222222222_01';
    }

    protected function getCustomerGKVPassword()
    {
        return 'pass';
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
