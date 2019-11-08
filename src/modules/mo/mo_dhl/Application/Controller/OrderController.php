<?php

namespace Mediaopt\DHL\Application\Controller;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Mediaopt\DHL\Api\Wunschpaket;

/** @noinspection LongInheritanceChainInspection */

/**
 * This class extends the order class with Wunschpaket features.
 *
 * @author Mediaopt GmbH
 */
class OrderController extends OrderController_parent
{
    /**
     * Make sure that the tags in the order remark are properly set.
     */
    public function init()
    {
        parent::init();
        $atLeastOneServiceHasBeenDisabled = $this->moDHLUpdateWunschpaketTags();
        if ($atLeastOneServiceHasBeenDisabled) {
            /** @noinspection PhpParamsInspection */
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__DISABLED_SERVICE_ERROR');
        }
    }

    /**
     */
    protected function moDHLUpdateWunschpaketTags()
    {
        /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
        $basket = $this->getBasket();
        $zip = $basket->moEmpfaengeservicesGetAddressedZipCode();
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        $previousRemark = $remark = \OxidEsales\Eshop\Core\Registry::getSession()->getVariable('ordrem');
        if ($wunschpaket->hasWunschtag($remark) && !$wunschpaket->canAWunschtagBeSelected($basket)) {
            $remark = $wunschpaket->removeWunschtagTag($remark);
        }
        if ($wunschpaket->hasWunschzeit($remark) && !$wunschpaket->canAWunschzeitBeSelected($zip)) {
            $remark = $wunschpaket->removeTimeTag($remark);
        }
        if ($wunschpaket->hasWunschort($remark) && !$wunschpaket->isWunschortActive()) {
            $remark = $wunschpaket->removeWunschortTag($remark);
        }
        if ($wunschpaket->hasWunschnachbar($remark) && !$wunschpaket->isWunschnachbarActive()) {
            $remark = $wunschpaket->removeWunschnachbarTag($remark);
        }
        \OxidEsales\Eshop\Core\Registry::getSession()->setVariable('ordrem', $remark);
        return $remark !== $previousRemark;
    }

    /**
     * @return string[]
     */
    public function moDHLGetLocation()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->extractLocation(parent::getOrderRemark());
    }

    /**
     * @return string
     */
    public function moDHLGetTime()
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        $preferredTime = $wunschpaket->extractTime(parent::getOrderRemark());
        return $preferredTime !== '' ? Wunschpaket::formatPreferredTime($preferredTime) : '';
    }

    /**
     * @return string
     */
    public function moDHLGetWunschtag()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->extractWunschtag(parent::getOrderRemark());
    }

    /**
     * @extend
     * @return string
     */
    public function getOrderRemark()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->removeWunschpaketTags(parent::getOrderRemark());
    }

    /**
     * @return bool
     */
    public function moDHLIsAWunschpaketServiceSelected()
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        return $wunschpaket->hasAnyWunschpaketService(parent::getOrderRemark());
    }

    /**
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function moDHLCanAWunschpaketServiceBeSelected()
    {
        $basket = $this->getBasket();
        $user = $this->getUser();
        $deliveryAddress = $this->getDelAddress();
        $payment = $this->getPayment();
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->canAWunschpaketServiceBeSelected($basket, $user, $deliveryAddress, $payment);
    }
}
