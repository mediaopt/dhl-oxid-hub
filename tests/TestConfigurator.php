<?php

class TestConfigurator extends \Mediaopt\DHL\Configurator
{
    protected function getLogin()
    {
        return 'moptrandom-temp-string-1455964747901';
    }

    protected function getPassword()
    {
        return 'J+-G_s6+3Ik1NX3f_mx9';
    }

    protected function getEkp()
    {
        return '5222500948';
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
