<?php
namespace Mediaopt\DHL\Application\Component;

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
class UserComponent extends UserComponent_parent
{
    /**
     * @extend
     * @return bool
     */
    protected function _changeUser_noRedirect()
    {
        $result = parent::_changeUser_noRedirect();
        $this->mo_empfaengerservices__injectWunschpaketTagsIntoOrderRemark();
        return $result;
    }

    /**
     */
    protected function mo_empfaengerservices__injectWunschpaketTagsIntoOrderRemark()
    {
        $remark = (string) \OxidEsales\Eshop\Core\Registry::getSession()->getVariable('ordrem');
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        $remarkWithoutTags = $wunschpaket->removeWunschpaketTags($remark);
        $wunschpaketTags = implode('', $this->mo_empfaengerservices__generateWunschpaketTags());
        \OxidEsales\Eshop\Core\Registry::getSession()->setVariable('ordrem', $wunschpaketTags . $remarkWithoutTags);
    }

    /**
     * @return string[]
     */
    protected function mo_empfaengerservices__generateWunschpaketTags()
    {
        return array_values([$this->mo_empfaengerservices__generatePreferredDayTag(), $this->mo_empfaengerservices__generatePreferredTimeTag(), $this->mo_empfaengerservices__generatePreferredLocationTag()]);
    }


    /**
     * @return string
     */
    protected function mo_empfaengerservices__generatePreferredLocationTag()
    {
        list($wunschort, $wunschnachbarName, $wunschnachbarAddress) = array_map('strval', array_map([\OxidEsales\Eshop\Core\Registry::getConfig(), 'getRequestParameter'], ['moEmpfaengerservicesWunschort', 'moEmpfaengerservicesWunschnachbarName', 'moEmpfaengerservicesWunschnachbarAddress']));
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        if ($wunschort !== '' && $wunschpaket->isWunschortActive()) {
            try {
                return $wunschpaket->generateWunschortTag($wunschort);
            } catch (\InvalidArgumentException $exception) {
                /** @noinspection PhpParamsInspection */
                \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_EMPFAENGERSERVICES__WUNSCHORT_INVALID');
                return '';
            }
        }
        if ($wunschnachbarName . $wunschnachbarAddress !== '' && $wunschpaket->isWunschnachbarActive()) {
            try {
                return $wunschpaket->generateWunschnachbarTag($wunschnachbarName, $wunschnachbarAddress);
            } catch (\InvalidArgumentException $exception) {
                /** @noinspection PhpParamsInspection */
                \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_EMPFAENGERSERVICES__WUNSCHNACHBAR_INVALID');
                return '';
            }
        }

        return '';
    }

    /**
     * @return string
     */
    protected function mo_empfaengerservices__generatePreferredDayTag()
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        $submittedWunschtag = (string) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('moEmpfaengerservicesWunschtag');
        try {
            $basket = $this->getSession()->getBasket();
            return $submittedWunschtag !== '' && $wunschpaket->canAWunschtagBeSelected($basket) ? $wunschpaket->generateWunschtagTag($submittedWunschtag, $basket) : '';
        } catch (\InvalidArgumentException $exception) {
            /** @noinspection PhpParamsInspection */
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_EMPFAENGERSERVICES__WUNSCHTAG_INVALID');
            return '';
        }
    }

    /**
     * @return string
     */
    protected function mo_empfaengerservices__generatePreferredTimeTag()
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        $submittedTime = (string) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('moEmpfaengerservicesTime');
        try {
            /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
            $basket = $this->getSession()->getBasket();
            $zip = $basket->moEmpfaengeservicesGetAddressedZipCode();
            return $submittedTime !== '' && $wunschpaket->canAWunschzeitBeSelected($zip) ? $wunschpaket->generateWunschzeitTag($submittedTime, $zip) : '';
        } catch (\InvalidArgumentException $exception) {
            /** @noinspection PhpParamsInspection */
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_EMPFAENGERSERVICES__WUNSCHZEIT_INVALID');
            return '';
        }
    }

    /**
     * @extend
     * @return mixed
     */
    public function createUser()
    {
        $result = parent::createUser();
        $this->mo_empfaengerservices__injectWunschpaketTagsIntoOrderRemark();
        return $result;
    }
}
