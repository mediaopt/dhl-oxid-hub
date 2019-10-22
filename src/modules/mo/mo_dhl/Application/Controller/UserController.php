<?php
namespace Mediaopt\DHL\Application\Controller;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 * 
 * @copyright 2016 derksen mediaopt GmbH
 */


/** @noinspection LongInheritanceChainInspection */

/**
 * This class extends the user with Wunschpaket functionality.
 * 
 * @author derksen mediaopt GmbH
 */
class UserController extends UserController_parent
{
    /**
     * @return string
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function render()
    {
        $template = parent::render();

        /** @var \Mediaopt\DHL\Application\Model\User|bool $user */
        $user = $this->getUser();
        if (!is_object($user) || !$user->moIsForcedToUseDhlDelivery()) {
            return $template;
        }


        /** @var \Mediaopt\DHL\Application\Model\Basket|null $basket */
        $basket = \OxidEsales\Eshop\Core\Registry::getSession()->getBasket();
        if (!is_object($basket) || $basket->moAllowsDhlDelivery()) {
            return $template;
        }

        $user->moResetWunschpaketSelection();
        return $template;
    }

    /**
     * @return string[]
     */
    public function mo_empfaengerservices__getLocation()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->extractLocation(parent::getOrderRemark());
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
     * @return string[]
     */
    public function mo_empfaengerservices__getWunschzeitOptions()
    {
        /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
        $basket = $this->getSession()->getBasket();
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->getWunschzeitOptions($basket->moEmpfaengeservicesGetAddressedZipCode());
    }

    /**
     * @return string[]
     */
    public function mo_empfaengerservices__getWunschtagOptions()
    {
        $basket = $this->getSession()->getBasket();
        $options = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->getWunschtagOptions($basket);
        return array_map('MoEmpfaengerservicesYellowBox::formatWunschtag', $options);
    }

    /**
     * @return string
     */
    public function mo_empfaengerservices__getSelectedWunschzeitId()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->extractTime(parent::getOrderRemark());
    }

    /**
     * @return string
     */
    public function mo_empfaengerservices__getSelectedWunschtag()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->extractWunschtag(parent::getOrderRemark());
    }

    /**
     * @return \OxidEsales\Eshop\Core\Price
     */
    public function mo_empfaengerservices__getWunschtagCosts()
    {
        /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
        $basket = \OxidEsales\Eshop\Core\Registry::getSession()->getBasket();
        $amount = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->getWunschtagSurcharge();
        return $basket->moEmpfaengerservicesCalculateSurcharge($amount);
    }

    /**
     * @return \OxidEsales\Eshop\Core\Price
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function mo_empfaengerservices__getCostsForCombinedWunschtagAndWunschzeit()
    {
        /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
        $basket = \OxidEsales\Eshop\Core\Registry::getSession()->getBasket();
        $amount = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->getCombinedWunschtagAndWunschzeitSurcharge();
        return $basket->moEmpfaengerservicesCalculateSurcharge($amount);
    }

    /**
     * @return \OxidEsales\Eshop\Core\Price
     */
    public function mo_empfaengerservices__getWunschzeitCosts()
    {
        /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
        $basket = \OxidEsales\Eshop\Core\Registry::getSession()->getBasket();
        $amount = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->getWunschzeitSurcharge();
        return $basket->moEmpfaengerservicesCalculateSurcharge($amount);
    }
}
