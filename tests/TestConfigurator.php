<?php

class TestConfigurator extends \Mediaopt\DHL\Configurator
{

    const TEST_PORTOKASSE_USERNAME = 'testpk_0526@dhldp-test.de';

    const TEST_PORTOKASSE_PASSWORD = '9W8ixXmjd3XEWg0c';

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
    protected function getParcelShippingApiKey()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PARCEL_SHIPPING_API_KEY;
    }


    /**
     * @return string
     */
    protected function getCustomerParcelShippingUsername()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_PARCEL_SHIPPING_USERNAME;
    }

    /**
     * @return string
     */
    protected function getCustomerParcelShippingPassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_PARCEL_SHIPPING_PASSWORD;
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
    protected function getStandortsuchePassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::DHL_DEVELOPER_API_KEY;
    }

    /**
     * @return string
     */
    protected function getEkp()
    {
        return '3333333333';
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
    protected function getCustomerPortokasseProdLogin(): string
    {
        return self::TEST_PORTOKASSE_USERNAME;
    }

    /**
     * @return string
     */
    protected function getCustomerPortokasseProdPassword(): string
    {
        return self::TEST_PORTOKASSE_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getCustomerPortokasseSandboxLogin(): string
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_CUSTOMER_PORTOKASSE_API_USERNAME;
    }

    /**
     * @return string
     */
    protected function getCustomerPortokasseSandboxPassword(): string
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_CUSTOMER_PORTOKASSE_API_PASSWORD;
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
        return \Mediaopt\DHL\Adapter\DHLConfigurator::PRODWS_MANDANT_ID;
    }

    /**
     * @return string
     */
    protected function getAuthenticationClientId()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::DHL_DEVELOPER_API_KEY;
    }

    /**
     * @return string
     */
    protected function getAuthenticationClientSecret()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::DHL_DEVELOPER_API_SECRET;
    }

    /**
     * @return string
     */
    protected function getAuthenticationUsername()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_AUTHENTICATION_USERNAME;
    }

    /**
     * @return string
     */
    protected function getAuthenticationPassword()
    {
        return \Mediaopt\DHL\Adapter\DHLConfigurator::TEST_AUTHENTICATION_PASSWORD;
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
