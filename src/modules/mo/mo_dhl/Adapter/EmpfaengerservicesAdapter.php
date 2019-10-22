<?php

namespace Mediaopt\DHL\Adapter;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 * 
 * @copyright 2016 derksen mediaopt GmbH
 */

use Mediaopt\Empfaengerservices\Api\Standortsuche;
use Mediaopt\Empfaengerservices\Api\Wunschpaket;
use Mediaopt\Empfaengerservices\Main;
use Psr\Log\LoggerInterface;

/**
 * This class adapts the OXID shop to the SDK.
 * 
 * @author derksen mediaopt GmbH
 */
class EmpfaengerservicesAdapter
{
    /**
     * @var Main
     */
    protected $sdk;

    /**
     * @param Main $sdk
     */
    public function __construct(Main $sdk = null)
    {
        $this->sdk = $sdk ?: new Main(\OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\EmpfaengerservicesConfigurator::class));
    }

    /**
     * @return bool
     */
    public function canPackstationBeSelected()
    {
        return (bool) \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('mo_empfaengerservices__standortsuche_packstation');
    }

    /**
     * @return bool
     */
    public function canPostfilialeBeSelected()
    {
        return (bool) \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('mo_empfaengerservices__standortsuche_postfiliale');
    }

    /**
     * @return bool
     */
    public function canPaketshopBeSelected()
    {
        return (bool) \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('mo_empfaengerservices__standortsuche_paketshop');
    }

    /**
     * @return int
     * @throws \RuntimeException
     */
    public function getMaximumHits()
    {
        $maximumHits = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_empfaengerservices__standortsuche_maximumHits');
        if (!is_numeric($maximumHits)) {
            $message = 'Misconfiguration: mo_empfaengerservices__standortsuche_maximumHits is no number.';
            throw new \RuntimeException($message);
        }

        return (int) $maximumHits;
    }

    /**
     * @return boolean true iff this plugin is ready to be used
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function isReady()
    {
        if (!$this->canServiceProviderBeSelected()) {
            return false;
        }
        if (!$this->getGoogleMapsApiKey()) {
            $this->getLogger()->info('DHL Lieferadressen needs a Google Maps API key.');
            return false;
        }

        $germany = \oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
        $germany->load($germany->getIdByCode('de'));
        if (!$germany->oxcountry__oxactive->rawValue) {
            $this->getLogger()->info('Currently, DHL Lieferadressen is only available for Germany.');
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function canServiceProviderBeSelected()
    {
        return $this->canPackstationBeSelected() || $this->canFilialeBeSelected();
    }

    /**
     * @return bool
     */
    public function canFilialeBeSelected()
    {
        return $this->canPostfilialeBeSelected() || $this->canPaketshopBeSelected();
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\User|null $user
     * @param \OxidEsales\Eshop\Application\Model\Address|null $deliveryAddress
     * @return null
     */
    protected function getDeliveryCountry($user, $deliveryAddress)
    {
        if (is_object($deliveryAddress)) {
            return $deliveryAddress->oxaddress__oxcountryid->rawValue;
        }
        if (is_object($user)) {
            return $user->oxuser__oxcountryid->rawValue;
        }
        return null;
    }


    /**
     * @param \OxidEsales\Eshop\Application\Model\User|null $user
     * @param \OxidEsales\Eshop\Application\Model\Address|null $deliveryAddress
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function isExcludedDueToSendingOutsideOfGermany($user, $deliveryAddress)
    {
        // This OXID is constant due to the installation.
        $germany = 'a7c40f631fc920687.20179984';
        return ($this->getDeliveryCountry($user, $deliveryAddress) ?: $germany) !== $germany;
    }

    /**
     * @see mo_empfaengerserivces__configurator::getMapsApiKey()
     * @return string
     */
    public function getGoogleMapsApiKey()
    {
        return $this->getSdk()->getConfigurator()->getMapsApiKey();
    }

    /**
     * @return Main
     */
    protected function getSdk()
    {
        return $this->sdk;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->getSdk()->getLogger();
    }

    /**
     * @return string[]
     */
    public function getDaysExcludedForHandingOver()
    {
        $excludedDays = [];
        foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day) {
            if (\OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('mo_empfaengerservices__handing_over_' . strtolower($day))) {
                $excludedDays[] = $day;
            }
        }
        return $excludedDays;
    }

    /**
     * @return int
     */
    public function getPreparationDays()
    {
        return (int) \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('mo_empfaengerservices__wunschtag_preparation');
    }

    /**
     * @return Wunschpaket
     */
    public function buildWunschpaket()
    {
        return $this->getSdk()->buildWunschpaket();
    }

    /**
     * @return Standortsuche
     */
    public function buildStandortsuche()
    {
        return $this->getSdk()->buildStandortsuche();
    }
}