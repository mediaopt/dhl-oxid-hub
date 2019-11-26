<?php

class GKVTestConfigurator extends \Mediaopt\DHL\Configurator
{
    protected function getLogin()
    {
        return 'moptrandom-temp-string-1455964747901';
    }

    protected function getPassword()
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
