<?php

namespace Mediaopt\DHL\Adapter;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Mediaopt\DHL\Api\Standortsuche;
use Mediaopt\DHL\Api\Wunschpaket;
use Mediaopt\DHL\Main;
use Psr\Log\LoggerInterface;

/**
 * This class adapts the OXID shop to the SDK.
 *
 * @author Mediaopt GmbH
 */
class DHLAdapter
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
        $this->sdk = $sdk ?: new Main(\OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLConfigurator::class));
    }

    /**
     * @return bool
     */
    public function canPackstationBeSelected()
    {
        return (bool)\OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('mo_dhl__standortsuche_packstation');
    }

    /**
     * @return bool
     */
    public function canPostfilialeBeSelected()
    {
        return (bool)\OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('mo_dhl__standortsuche_postfiliale');
    }

    /**
     * @return bool
     */
    public function canPaketshopBeSelected()
    {
        return (bool)\OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('mo_dhl__standortsuche_paketshop');
    }

    /**
     * @return int
     * @throws \RuntimeException
     */
    public function getMaximumHits()
    {
        $maximumHits = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__standortsuche_maximumHits');
        if (!is_numeric($maximumHits)) {
            $message = 'Misconfiguration: mo_dhl__standortsuche_maximumHits is no number.';
            throw new \RuntimeException($message);
        }

        return (int)$maximumHits;
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
     * @param \OxidEsales\Eshop\Application\Model\User|null    $user
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
     * @param \OxidEsales\Eshop\Application\Model\User|null    $user
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
     * @return string
     * @see mo_empfaengerserivces__configurator::getMapsApiKey()
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
            if (\OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('mo_dhl__handing_over_' . strtolower($day))) {
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
        return (int)\OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('mo_dhl__wunschtag_preparation');
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

    /**
     * @return \Mediaopt\DHL\Api\ParcelShipping\Client
     */
    public function buildParcelShipping()
    {
        return $this->getSdk()->buildParcelShipping();
    }


    /**
     * @return \Mediaopt\DHL\Api\MyAccount\Client
     */
    public function buildMyAccount()
    {
        return $this->getSdk()->buildMyAccount();
    }

    /**
     * @return \Mediaopt\DHL\Api\Retoure
     */
    public function buildRetoure()
    {
        return $this->getSdk()->buildRetoure();
    }

    /**
     * @return \Mediaopt\DHL\Api\InternetmarkeRefund
     */
    public function buildInternetmarkeRefund()
    {
        return $this->getSdk()->buildInternetmarkeRefund();
    }

    /**
     * @return \Mediaopt\DHL\Api\Internetmarke
     */
    public function buildInternetmarke()
    {
        return $this->getSdk()->buildInternetmarke();
    }

    /**
     * @return \Mediaopt\DHL\Api\ProdWSService
     */
    public function buildProdWS()
    {
        return $this->getSdk()->buildProdWS();
    }
}
