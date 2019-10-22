<?php

namespace Mediaopt\DHL\Application\Controller;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 * 
 * @copyright 2016 derksen mediaopt GmbH
 */

use Mediaopt\Empfaengerservices\Api\Wunschpaket;

/** @noinspection LongInheritanceChainInspection */

/**
 * This class extends the order class with Wunschpaket features.
 * 
 * @author derksen mediaopt GmbH
 */
class OrderController extends OrderController_parent
{
    /**
     * Make sure that the tags in the order remark are properly set.
     */
    public function init()
    {
        parent::init();
        $atLeastOneServiceHasBeenDisabled = $this->mo_empfaengerservices__updateWunschpaketTags();
        if ($atLeastOneServiceHasBeenDisabled) {
            /** @noinspection PhpParamsInspection */
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_EMPFAENGERSERVICES__DISABLED_SERVICE_ERROR');
        }
    }

    /**
     */
    protected function mo_empfaengerservices__updateWunschpaketTags()
    {
        /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
        $basket = $this->getBasket();
        $zip = $basket->moEmpfaengeservicesGetAddressedZipCode();
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
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
    public function mo_empfaengerservices__getLocation()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->extractLocation(parent::getOrderRemark());
    }

    /**
     * @return string
     */
    public function mo_empfaengerservices__getTime()
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        $preferredTime = $wunschpaket->extractTime(parent::getOrderRemark());
        return $preferredTime !== '' ? Wunschpaket::formatPreferredTime($preferredTime) : '';
    }

    /**
     * @return string
     */
    public function mo_empfaengerservices__getWunschtag()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->extractWunschtag(parent::getOrderRemark());
    }

    /**
     * @extend
     * @return string
     */
    public function getOrderRemark()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->removeWunschpaketTags(parent::getOrderRemark());
    }

    /**
     * @return bool
     */
    public function mo_empfaengerservices__isAWunschpaketServiceSelected()
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        return $wunschpaket->hasAnyWunschpaketService(parent::getOrderRemark());
    }

    /**
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function mo_empfaengerservices__canAWunschpaketServiceBeSelected()
    {
        $basket = $this->getBasket();
        $user = $this->getUser();
        $deliveryAddress = $this->getDelAddress();
        $payment = $this->getPayment();
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->canAWunschpaketServiceBeSelected($basket, $user, $deliveryAddress, $payment);
    }
}