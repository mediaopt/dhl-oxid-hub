<?php

namespace Mediaopt\DHL\Adapter;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 derksen mediaopt GmbH
 */

use Monolog\Handler\RotatingFileHandler;

/**
 * This class retrieves the configuration from the OXID shop.
 *
 * @author derksen mediaopt GmbH
 */
class DHLConfigurator extends \Mediaopt\DHL\Configurator
{
    /**
     * @var int
     */
    const DEFAULT_LOG_RETENTION_SIZE = 30;

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
    protected function getLogin()
    {
        return 'DhlEmpfaengerservicesOxid_3';
    }

    /**
     * @return string
     */
    protected function getPassword()
    {
        return 'sLS0vunhKg47u6JyVTL0ZUDCG18Mh8';
    }

    /**
     * @return bool
     */
    protected function isProductionEnvironment()
    {
        return true;
    }

    /**
     * @return int
     */
    protected function getNumberOfLogFilesToRetain()
    {
        $retentionNumbers = ['UNLIMITED' => 0, 'ONE_DAY' => 1, 'TWO_DAYS' => 2, 'THREE_DAYS' => 3, 'FOUR_DAYS' => 4, 'FIVE_DAYS' => 5, 'SIX_DAYS' => 6, 'ONE_WEEK' => 7, 'TWO_WEEKS' => 14, 'THREE_WEEKS' => 21, 'ONE_MONTH' => 30, 'TWO_MONTHS' => 61, 'QUARTER_YEAR' => 122, 'HALF_YEAR' => 183, 'YEAR' => 365];
        /** @var string|null $retentionPeriod */
        $retentionPeriod = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('mo_dhl__retention');
        return array_key_exists($retentionPeriod, $retentionNumbers) ? $retentionNumbers[$retentionPeriod] : self::DEFAULT_LOG_RETENTION_SIZE;
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
