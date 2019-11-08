<?php
namespace Mediaopt\DHL\Core;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

/** @noinspection LongInheritanceChainInspection */

/**
 * Grants access to some methods of the adapter and adds functionality to get the country id of Germany.
 *
 * @author Mediaopt GmbH
 */
class ViewConfig extends ViewConfig_parent
{
    /**
     * Returns the OXID of Germany.
     *
     * @return string
     */
    public function getGermanyId()
    {
        return \oxNew(\OxidEsales\Eshop\Application\Model\Country::class)->getIdByCode('de');
    }

    /**
     * @see DHLAdapter::isReady()
     * @return string
     */
    public function getGoogleMapsApiKey()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class)->getGoogleMapsApiKey();
    }

    /**
     * @see DHLAdapter::isReady()
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function isDhlFinderAvailable()
    {
        /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
        $basket = \OxidEsales\Eshop\Core\Registry::getConfig()->getSession()->getBasket();
        $adapter = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class);
        return $adapter->isReady() && $basket->moAllowsDhlDelivery();
    }

    /**
     * Returns true iff the current theme or one of its parents is the supplied theme.
     *
     * @param string $themeName
     * @return bool
     */
    public function moHasAncestorTheme($themeName)
    {
        $theme = \oxNew(\OxidEsales\Eshop\Core\Theme::class);
        $theme->load($theme->getActiveThemeId());

        while ($theme !== null) {
            if ($theme->getId() === $themeName) {
                return true;
            }
            $theme = $theme->getParent();
        }

        return false;
    }

    /**
     * Returns true iff preferred day, time, location or neighbor is activated.
     *
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function moIsAnyWunschpaketFeatureActivated()
    {
        $basket = \OxidEsales\Eshop\Core\Registry::getConfig()->getSession()->getBasket();
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->canAWunschpaketServiceBeSelected($basket);
    }

    /**
     * @return bool
     */
    public function moIsWunschtagActivated()
    {
        $basket = \OxidEsales\Eshop\Core\Registry::getConfig()->getSession()->getBasket();
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->canAWunschtagBeSelected($basket);
    }

    /**
     * @return bool
     */
    public function moIsWunschzeitActivated()
    {
        /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
        $basket = \OxidEsales\Eshop\Core\Registry::getConfig()->getSession()->getBasket();
        $zip = $basket->moEmpfaengeservicesGetAddressedZipCode();
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->canAWunschzeitBeSelected($zip);
    }

    /**
     * @return bool
     */
    public function moIsWunschortActivated()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->isWunschortActive();
    }

    /**
     * @return bool
     */
    public function moIsWunschnachbarActivated()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->isWunschnachbarActive();
    }

    /**
     * @return bool
     */
    public function moCanPackstationBeSelected()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class)->canPackstationBeSelected();
    }

    /**
     * @return bool
     */
    public function moCanFilialeBeSelected()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class)->canFilialeBeSelected();
    }

    /**
     * @return string
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function moGetPrivacyLinkForWunschpaket()
    {
        $identifier = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__privacy_policy');
        $languageId = (int) \OxidEsales\Eshop\Core\Registry::getLang()->getTplLanguage();
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $query = ' SELECT OXSEOURL' . ' FROM oxcontents' . '   JOIN oxseo ON OXOBJECTID = OXID' . " WHERE OXLOADID = {$db->quote($identifier)} AND OXLANG = {$languageId}";
        return (string) $db->getOne($query);
    }
}
