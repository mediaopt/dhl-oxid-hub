<?php
namespace Mediaopt\DHL\Application\Controller;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */


/** @noinspection LongInheritanceChainInspection */

/**
 * This class extends the user with Wunschpaket functionality.
 *
 * @author Mediaopt GmbH
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
    public function moDHLGetLocation()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->extractLocation(parent::getOrderRemark());
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
     * @return string[]
     */
    public function moDHLGetWunschtagOptions()
    {
        $basket = $this->getSession()->getBasket();
        $options = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->getWunschtagOptions($basket);
        return array_map('MoDHLYellowBox::formatWunschtag', $options);
    }

    /**
     * @return string
     */
    public function moDHLGetSelectedWunschtag()
    {
        return \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->extractWunschtag(parent::getOrderRemark());
    }

    /**
     * @return \OxidEsales\Eshop\Core\Price
     */
    public function moDHLGetWunschtagCosts()
    {
        /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
        $basket = \OxidEsales\Eshop\Core\Registry::getSession()->getBasket();
        $amount = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->getWunschtagSurcharge();
        return $basket->moDHLCalculateSurcharge($amount);
    }
}
