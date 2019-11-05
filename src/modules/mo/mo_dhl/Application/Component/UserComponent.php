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
        $this->moDHLInjectWunschpaketTagsIntoOrderRemark();
        return $result;
    }

    /**
     */
    protected function moDHLInjectWunschpaketTagsIntoOrderRemark()
    {
        $remark = (string) \OxidEsales\Eshop\Core\Registry::getSession()->getVariable('ordrem');
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        $remarkWithoutTags = $wunschpaket->removeWunschpaketTags($remark);
        $wunschpaketTags = implode('', $this->moDHLGenerateWunschpaketTags());
        \OxidEsales\Eshop\Core\Registry::getSession()->setVariable('ordrem', $wunschpaketTags . $remarkWithoutTags);
    }

    /**
     * @return string[]
     */
    protected function moDHLGenerateWunschpaketTags()
    {
        return array_values([$this->moDHLGeneratePreferredDayTag(), $this->moDHLGeneratePreferredTimeTag(), $this->moDHLGeneratePreferredLocationTag()]);
    }


    /**
     * @return string
     */
    protected function moDHLGeneratePreferredLocationTag()
    {
        list($wunschort, $wunschnachbarName, $wunschnachbarAddress) = array_map('strval', array_map([\OxidEsales\Eshop\Core\Registry::getConfig(), 'getRequestParameter'], ['moDHLWunschort', 'moDHLWunschnachbarName', 'moDHLWunschnachbarAddress']));
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        if ($wunschort !== '' && $wunschpaket->isWunschortActive()) {
            try {
                return $wunschpaket->generateWunschortTag($wunschort);
            } catch (\InvalidArgumentException $exception) {
                /** @noinspection PhpParamsInspection */
                \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__WUNSCHORT_INVALID');
                return '';
            }
        }
        if ($wunschnachbarName . $wunschnachbarAddress !== '' && $wunschpaket->isWunschnachbarActive()) {
            try {
                return $wunschpaket->generateWunschnachbarTag($wunschnachbarName, $wunschnachbarAddress);
            } catch (\InvalidArgumentException $exception) {
                /** @noinspection PhpParamsInspection */
                \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__WUNSCHNACHBAR_INVALID');
                return '';
            }
        }

        return '';
    }

    /**
     * @return string
     */
    protected function moDHLGeneratePreferredDayTag()
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        $submittedWunschtag = (string) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('moDHLWunschtag');
        try {
            $basket = $this->getSession()->getBasket();
            return $submittedWunschtag !== '' && $wunschpaket->canAWunschtagBeSelected($basket) ? $wunschpaket->generateWunschtagTag($submittedWunschtag, $basket) : '';
        } catch (\InvalidArgumentException $exception) {
            /** @noinspection PhpParamsInspection */
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__WUNSCHTAG_INVALID');
            return '';
        }
    }

    /**
     * @return string
     */
    protected function moDHLGeneratePreferredTimeTag()
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        $submittedTime = (string) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('moDHLTime');
        try {
            /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
            $basket = $this->getSession()->getBasket();
            $zip = $basket->moEmpfaengeservicesGetAddressedZipCode();
            return $submittedTime !== '' && $wunschpaket->canAWunschzeitBeSelected($zip) ? $wunschpaket->generateWunschzeitTag($submittedTime, $zip) : '';
        } catch (\InvalidArgumentException $exception) {
            /** @noinspection PhpParamsInspection */
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__WUNSCHZEIT_INVALID');
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
        $this->moDHLInjectWunschpaketTagsIntoOrderRemark();
        return $result;
    }
}
