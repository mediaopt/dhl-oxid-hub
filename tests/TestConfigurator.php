<?php

class TestConfigurator extends \Mediaopt\DHL\Configurator
{
    protected function getRestLogin()
    {
        return 'DhlEmpfaengerservicesOxid_3';
    }

    protected function getRestPassword()
    {
        return 'sLS0vunhKg47u6JyVTL0ZUDCG18Mh8';
    }

    protected function getSoapLogin()
    {
        return 'moptrandom-temp-string-1455964747901';
    }

    protected function getSoapPassword()
    {
        return 'H#R#__!w4-dt-9++9Z-r7-9';
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
