<?php

class TestConfigurator extends \Mediaopt\DHL\Configurator
{

    const TEST_INTERNETMARKE_USERNAME = 'testpk_0526@dhldp-test.de';

    const TEST_INTERNETMARKE_PASSWORD = '9W8ixXmjd3XEWg0c';

    const TEST_PRODWS_MANDANT_ID = 'MEDIAOPT';

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
    protected function getStandortsucheKeyName()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::STANDORTSUCHE_API_KEY_NAME;
    }

    /**
     * @return string
     */
    protected function getProdStandortsuchePassword()
    {
        return 'PROD_STANDORTSUCHE_API_PASSWORD';
    }

    /**
     * @return string
     */
    protected function getSandboxStandortsuchePassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_STANDORTSUCHE_API_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getWarenpostSandboxLogin(): string
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_WARENPOST_API_USERNAME;
    }

    /**
     * @return string
     */
    protected function getWarenpostSandboxPassword(): string
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_WARENPOST_API_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getWarenpostProdLogin(): string
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PROD_WARENPOST_API_USERNAME;
    }

    /**
     * @return string
     */
    protected function getWarenpostProdPassword(): string
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PROD_WARENPOST_API_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getWarenpostEkp(): string
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::WARENPOST_API_EKP;
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
        return self::TEST_INTERNETMARKE_USERNAME;
    }

    /**
     * @return string
     */
    protected function getCustomerInternetmarkePassword()
    {
        return self::TEST_INTERNETMARKE_PASSWORD;
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
        return self::TEST_PRODWS_MANDANT_ID;
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
