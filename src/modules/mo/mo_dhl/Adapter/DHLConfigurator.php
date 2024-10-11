<?php

namespace Mediaopt\DHL\Adapter;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Monolog\Handler\RotatingFileHandler;

/**
 * This class retrieves the configuration from the OXID shop.
 *
 * @author Mediaopt GmbH
 */
class DHLConfigurator extends \Mediaopt\DHL\Configurator
{
    /**
     * @var int
     */
    const DEFAULT_LOG_RETENTION_SIZE = 30;

    const TEST_API_USERNAME = 'moptrandom-temp-string-1455964747901';

    const TEST_API_PASSWORD = 'H#R#__!w4-dt-9++9Z-r7-9';

    const PROD_API_USERNAME = 'DHL_Oxid_3';

    const PROD_API_PASSWORD = 'RGZ02BtCUBOHkxzMdy1NUm29oxhpHx';

    const TEST_CUSTOMER_PORTOKASSE_API_USERNAME = 'wapo-test@mediaopt.de';

    const TEST_CUSTOMER_PORTOKASSE_API_PASSWORD = '#mediaopt20';

    const TEST_GKV_USERNAME = '2222222222_01';

    const TEST_GKV_PASSWORD = 'SandboxPasswort2023!';

    const TEST_PARCEL_SHIPPING_USERNAME = 'user-valid';

    const TEST_PARCEL_SHIPPING_PASSWORD = self::TEST_GKV_PASSWORD;

    const PARCEL_SHIPPING_API_KEY = 'AYjXP5URDZnGbNVtxQa8iHNvXlboQqtG';

    const TEST_RETOURE_USERNAME = '2222222222_customer';

    const TEST_RETOURE_PASSWORD = 'uBQbZ62!ZiBiVVbhc';

    const TEST_INTERNETMARKE_PARTNER_ID = 'AMHDH';

    const TEST_INTERNETMARKE_SIGNATURE = 'v9hFqrH1JH5vBdtd8f9XXjMpkSNl6UcW';

    const PROD_INTERNETMARKE_PARTNER_ID = 'AMHDH';

    const PROD_INTERNETMARKE_SIGNATURE = 'v9hFqrH1JH5vBdtd8f9XXjMpkSNl6UcW';

    const PRODWS_MANDANT_ID = 'MEDIAOPT';

    const PRODWS_USERNAME = 'mediaopt';

    const PRODWS_PASSWORD = 'B&5%bk?dx7';

    const STANDORTSUCHE_API_KEY_NAME = 'DHL-API-Key';

    const DHL_DEVELOPER_API_KEY = 'kAPjq3yHFgY6QD3sHEtv61dQCAgoXLyK';

    const DHL_DEVELOPER_API_SECRET = 'YdZnAljhgbcOXOKD';

    const TEST_AUTHENTICATION_USERNAME = 'user-valid';

    const TEST_AUTHENTICATION_PASSWORD = 'SandboxPasswort2023!';

    /**
     * @return mixed
     */
    public function getMapsApiKey()
    {
        return \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__standortsuche_googleMapsApiKey');
    }

    /**
     * @return string
     */
    protected function getProdLogin()
    {
        return self::PROD_API_USERNAME;
    }

    /**
     * @return string
     */
    protected function getProdPassword()
    {
        return self::PROD_API_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getSandboxLogin()
    {
        return self::TEST_API_USERNAME;
    }

    /**
     * @return string
     */
    protected function getSandboxPassword()
    {
        return self::TEST_API_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getStandortsucheKeyName()
    {
        return self::STANDORTSUCHE_API_KEY_NAME;
    }

    /**
     * @return string
     */
    protected function getStandortsuchePassword()
    {
        return self::DHL_DEVELOPER_API_KEY;
    }

    /**
     * @return string
     */
    protected function getCustomerGKVLogin()
    {
        return $this->isProductionEnvironment()
            ? (\OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__account_user') ?: '')
            : self::TEST_GKV_USERNAME;
    }

    /**
     * @return string
     */
    protected function getCustomerGKVPassword()
    {
        return $this->isProductionEnvironment()
            ? (\OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__account_password') ?: '')
            : self::TEST_GKV_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getParcelShippingApiKey()
    {
        return self::PARCEL_SHIPPING_API_KEY;
    }


    /**
     * @return string
     */
    protected function getCustomerParcelShippingUsername()
    {
        return $this->isProductionEnvironment()
            ? (\OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__account_user') ?: '')
            : self::TEST_PARCEL_SHIPPING_USERNAME;
    }

    /**
     * @return string
     */
    protected function getCustomerParcelShippingPassword()
    {
        return $this->isProductionEnvironment()
            ? (\OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__account_password') ?: '')
            : self::TEST_PARCEL_SHIPPING_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getAuthenticationClientId()
    {
        return self::DHL_DEVELOPER_API_KEY;
    }

    /**
     * @return string
     */
    protected function getAuthenticationClientSecret()
    {
        return self::DHL_DEVELOPER_API_SECRET;
    }

    /**
     * @return string
     */
    protected function getAuthenticationUsername()
    {
        return $this->isProductionEnvironment()
            ? (\OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__account_user') ?: '')
            : self::TEST_AUTHENTICATION_USERNAME;
    }

    /**
     * @return string
     */
    protected function getAuthenticationPassword()
    {
        return $this->isProductionEnvironment()
            ? (\OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__account_password') ?: '')
            : self::TEST_AUTHENTICATION_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getCustomerRetoureLogin()
    {
        return $this->isProductionEnvironment()
            ? (\OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__account_user') ?: '')
            : self::TEST_RETOURE_USERNAME;
    }

    /**
     * @return string
     */
    protected function getCustomerRetourePassword()
    {
        return $this->isProductionEnvironment()
            ? (\OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__account_password') ?: '')
            : self::TEST_RETOURE_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getInternetmarkeProdLogin()
    {
        return self::PROD_INTERNETMARKE_PARTNER_ID;
    }

    /**
     * @return string
     */
    protected function getInternetmarkeProdSignature()
    {
        return self::PROD_INTERNETMARKE_SIGNATURE;
    }

    /**
     * @return string
     */
    protected function getInternetmarkeSandboxLogin()
    {
        return self::TEST_INTERNETMARKE_PARTNER_ID;
    }

    /**
     * @return string
     */
    protected function getInternetmarkeSandboxSignature()
    {
        return self::TEST_INTERNETMARKE_SIGNATURE;
    }

    /**
     * @return string
     */
    protected function getCustomerPortokasseProdLogin(): string
    {
        return \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__portokasse_user') ?: '';
    }

    /**
     * @return string
     */
    protected function getCustomerPortokasseProdPassword(): string
    {
        return \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__portokasse_password') ?: '';
    }

    /**
     * @return string
     */
    protected function getCustomerPortokasseSandboxLogin(): string
    {
        return self::TEST_CUSTOMER_PORTOKASSE_API_USERNAME;
    }

    /**
     * @return string
     */
    protected function getCustomerPortokasseSandboxPassword(): string
    {
        return self::TEST_CUSTOMER_PORTOKASSE_API_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getProdWSLogin()
    {
        return self::PRODWS_USERNAME;
    }

    /**
     * @return string
     */
    protected function getProdWSPassword()
    {
        return self::PRODWS_PASSWORD;
    }

    /**
     * @return string
     */
    protected function getCustomerProdWSMandantId()
    {
        return self::PRODWS_MANDANT_ID;
    }

    /**
     * @return bool
     */
    protected function isProductionEnvironment()
    {
        return !\OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__account_sandbox');
    }

    /**
     * @return int
     */
    protected function getNumberOfLogFilesToRetain()
    {
        $retentionNumbers = ['UNLIMITED' => 0, 'ONE_DAY' => 1, 'TWO_DAYS' => 2, 'THREE_DAYS' => 3, 'FOUR_DAYS' => 4, 'FIVE_DAYS' => 5, 'SIX_DAYS' => 6, 'ONE_WEEK' => 7, 'TWO_WEEKS' => 14, 'THREE_WEEKS' => 21, 'ONE_MONTH' => 30, 'TWO_MONTHS' => 61, 'QUARTER_YEAR' => 122, 'HALF_YEAR' => 183, 'YEAR' => 365];
        /** @var string|null $retentionPeriod */
        $retentionPeriod = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('mo_dhl__retention');
        return array_key_exists($retentionPeriod, $retentionNumbers) ? $retentionNumbers[$retentionPeriod]
            : self::DEFAULT_LOG_RETENTION_SIZE;
    }

    /**
     * @return \Monolog\Handler\StreamHandler
     * @throws \Exception
     */
    protected function buildLogHandler()
    {
        $filename = \OxidEsales\Eshop\Core\Registry::getConfig()->getLogsDir() . $this->getName();
        $handler = new RotatingFileHandler($filename, $this->getNumberOfLogFilesToRetain(), $this->getLogLevel());
        $handler->setFilenameFormat('{filename}_{date}.log', 'Ymd');
        return $handler;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mo_dhl';
    }

    /**
     * @return mixed
     */
    protected function getLogLevel()
    {
        return \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__logLevel');
    }

    /**
     * @return string
     */
    protected function getEkp()
    {
        return \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__merchant_ekp');
    }
}
