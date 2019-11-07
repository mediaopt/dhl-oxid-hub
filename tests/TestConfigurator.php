<?php

class TestConfigurator extends \Mediaopt\DHL\Configurator
{
    protected function getLogin()
    {
        return 'DhlEmpfaengerservicesOxid_3';
    }

    protected function getPassword()
    {
        return 'sLS0vunhKg47u6JyVTL0ZUDCG18Mh8';
    }

    protected function getEkp()
    {
        return '5222500948';
    }

    protected function isProductionEnvironment()
    {
        return true;
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
