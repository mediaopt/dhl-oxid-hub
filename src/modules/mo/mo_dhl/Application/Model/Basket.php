<?php
namespace Mediaopt\DHL\Application\Model;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 derksen mediaopt GmbH
 */

/** @noinspection LongInheritanceChainInspection */

/**
 * Adds functionality to integrate surcharges in case a Wunschtag or Wunschzeit is selected.
 *
 * @author derksen mediaopt GmbH
 */
class Basket extends Basket_parent
{

    /**
     * @var bool
     */
    protected $moIsDhlDeliveryAllowed;

    /**
     * @extend
     */
    protected function _calcTotalPrice()
    {
        parent::_calcTotalPrice();
        $this->getPrice()->add($this->moDHLGetDeliverySurcharges()->getPrice());
    }

    /**
     * @return \OxidEsales\Eshop\Core\Price
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function moDHLGetDeliverySurcharges()
    {
        $remark = \OxidEsales\Eshop\Core\Registry::getSession()->getVariable('ordrem');
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        if ($wunschpaket->hasWunschzeit($remark) && $wunschpaket->hasWunschtag($remark)) {
            return $this->moDHLGetCostsForCombinedWunschtagAndWunschzeit();
        }
        if ($wunschpaket->hasWunschzeit($remark)) {
            return $this->moDHLGetWunschzeitCosts();
        }
        if ($wunschpaket->hasWunschtag($remark)) {
            return $this->moDHLGetWunschtagCosts();
        }

        return \oxNew(\OxidEsales\Eshop\Core\Price::class, 0.0);
    }

    /**
     * @return bool
     */
    public function moDHLContainsNonDeliverableItem()
    {
        /** @var \OxidEsales\Eshop\Application\Model\BasketItem $basketItem */
        foreach ($this->getContents() as $basketItem) {
            try {
                if ($basketItem->getArticle()->getStockStatus() < 0) {
                    return true;
                }
            } catch (\OxidEsales\Eshop\Core\Exception\ArticleException $exception) {
                // We discard this exception as the checkout will handle this condition better.
            }
        }
        return false;
    }

    /**
     * Estimates the delivery time based on the delivery time of each article.
     *
     * Returns two integers:
     * (1) the largest minimum delivery time (in days)
     * (2) the largest maximum delivery time (in days)
     *
     * @return int[]
     */
    public function moDHLEstimateDeliveryTime()
    {
        $maximumOfMinima = 0;
        $maximumOfMaxima = 0;
        /** @var \OxidEsales\Eshop\Application\Model\BasketItem $basketItem */
        foreach ($this->getContents() as $basketItem) {
            try {
                $article = $basketItem->getArticle();
                $factor = $this->moDHLConvertDeliveryTimeUnit($article->oxarticles__oxdeltimeunit);
                $maximumOfMinima = max($article->oxarticles__oxmindeltime->rawValue * $factor, $maximumOfMinima);
                $maximumOfMaxima = max($article->oxarticles__oxmaxdeltime->rawValue * $factor, $maximumOfMaxima);
            } catch (\OxidEsales\Eshop\Core\Exception\ArticleException $exception) {
                // We discard this exception as the checkout will handle this condition better.
            }
        }
        return [$maximumOfMinima, $maximumOfMaxima];
    }

    /**
     * @return \OxidEsales\Eshop\Core\Price
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function moDHLGetWunschtagCosts()
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        return $wunschpaket->hasWunschtag(\OxidEsales\Eshop\Core\Registry::getSession()->getVariable('ordrem')) ? $this->moDHLCalculateSurcharge($wunschpaket->getWunschtagSurcharge()) : \oxNew(\OxidEsales\Eshop\Core\Price::class, 0.0);
    }

    /**
     * @return \OxidEsales\Eshop\Core\Price
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function moDHLGetWunschzeitCosts()
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        return $wunschpaket->hasWunschzeit(\OxidEsales\Eshop\Core\Registry::getSession()->getVariable('ordrem')) ? $this->moDHLCalculateSurcharge($wunschpaket->getWunschzeitSurcharge()) : \oxNew(\OxidEsales\Eshop\Core\Price::class, 0.0);
    }

    /**
     * @return \OxidEsales\Eshop\Core\Price
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function moDHLGetCostsForCombinedWunschtagAndWunschzeit()
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        $remark = \OxidEsales\Eshop\Core\Registry::getSession()->getVariable('ordrem');
        return $wunschpaket->hasWunschtag($remark) && $wunschpaket->hasWunschzeit($remark) ? $this->moDHLCalculateSurcharge($wunschpaket->getCombinedWunschtagAndWunschzeitSurcharge()) : \oxNew(\OxidEsales\Eshop\Core\Price::class, 0.0);
    }

    /**
     * @param float $amount
     * @return \OxidEsales\Eshop\Core\Price
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function moDHLCalculateSurcharge($amount)
    {
        $surcharge = \oxNew(\OxidEsales\Eshop\Core\Price::class);
        $surcharge->setBruttoPriceMode();
        $surcharge->setPrice((float) $amount);
        $surcharge->setVat($this->getAdditionalServicesVatPercent());
        $surcharge->divide(\OxidEsales\Eshop\Core\Registry::getConfig()->getCurrencyObject('EUR')->rate);
        $surcharge->multiply(\OxidEsales\Eshop\Core\Registry::getConfig()->getActShopCurrencyObject()->rate);
        return $surcharge;
    }

    /**
     * @param string $unit DAY or WEEK or MONTH
     * @return int
     */
    protected function moDHLConvertDeliveryTimeUnit($unit)
    {
        switch ($unit) {
            default:
            case 'DAY':
                return 1;
            case 'WEEK':
                return 7;
            case 'MONTH':
                return 30;
        }
    }

    /**
     * @return string[]
     */
    protected function moDHLGetProductIds()
    {
        $articleIds = [];
        /** @var \OxidEsales\Eshop\Application\Model\BasketItem $basketItem */
        foreach ($this->getContents() as $basketItem) {
            $articleIds[] = $basketItem->getArticle()->getParentId() ?: $basketItem->getArticle()->getId();
        }
        return $articleIds;
    }


    /**
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function moAllowsDhlDelivery()
    {
        if ($this->moIsDhlDeliveryAllowed === null) {
            $articleIds = $this->moDHLGetProductIds();
            $this->moIsDhlDeliveryAllowed = $articleIds === [] || $this->moExistsItemIndependentDeliveryRuleAllowingDhlDelivery() || $this->moCanEachItemBeDeliveredViaDhl($articleIds);
        }
        return $this->moIsDhlDeliveryAllowed;
    }

    /**
     * @param string $table
     * @return string
     */
    protected function moIsActiveSnippet($table)
    {
        $isBetweenStartAndEnd = "NOW() BETWEEN {$table}.OXACTIVEFROM AND {$table}.OXACTIVETO";
        $startsAtSomePoint = "'1000-01-01 00:00:01' < {$table}.OXACTIVEFROM";
        return "{$table}.OXACTIVE = 1 OR ({$startsAtSomePoint} AND {$isBetweenStartAndEnd})";
    }

    /**
     * @param string[] $articleIds
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    protected function moCanEachItemBeDeliveredViaDhl($articleIds)
    {
        $activeDeliverySet = $this->moIsActiveSnippet('oxdeliveryset');
        $activeDelivery = $this->moIsActiveSnippet('oxdelivery');
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $ids = implode(', ', array_map([$db, 'quote'], $articleIds));
        $categoryIds = "SELECT OXCATNID FROM oxobject2category WHERE OXOBJECTID IN ({$ids})";
        $exclusion = ' SELECT MIN(oxdeliveryset.MO_DHL_EXCLUDED + oxdelivery.MO_DHL_EXCLUDED) AS isExcluded' . ' FROM oxobject2delivery' . "   JOIN oxdelivery ON oxdelivery.OXID = OXDELIVERYID AND ({$activeDelivery})" . '   JOIN oxdel2delset ON OXDELID = oxdelivery.OXID ' . "   JOIN oxdeliveryset ON oxdeliveryset.OXID = OXDELSETID AND ({$activeDeliverySet})" . " WHERE OXOBJECTID IN ({$ids}) OR OXOBJECTID IN ({$categoryIds})" . ' GROUP BY OXOBJECTID';
        $isExcluded = "SELECT COALESCE(MAX(isExcluded), 1) FROM ({$exclusion}) exclusion";
        return !$db->getOne($isExcluded);
    }

    /**
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    protected function moExistsItemIndependentDeliveryRuleAllowingDhlDelivery()
    {
        $activeDeliverySet = $this->moIsActiveSnippet('oxdeliveryset');
        $activeDelivery = $this->moIsActiveSnippet('oxdelivery');
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $itemDependency = ' SELECT OXID FROM oxobject2delivery' . " WHERE OXDELIVERYID = oxdelivery.OXID AND OXTYPE IN ('oxarticles', 'oxcategories')";
        $query = ' SELECT COALESCE(MIN(oxdeliveryset.MO_DHL_EXCLUDED), 1)' . ' FROM oxdeliveryset' . '   JOIN oxdel2delset ON OXDELSETID = oxdeliveryset.OXID' . "   JOIN oxdelivery ON oxdelivery.OXID = OXDELID AND oxdelivery.MO_DHL_EXCLUDED = 0 AND ({$activeDelivery})" . " WHERE ({$activeDeliverySet}) AND NOT EXISTS({$itemDependency})";
        return !$db->getOne($query);
    }

    /**
     * @return string|null
     */
    public function moEmpfaengeservicesGetAddressedZipCode()
    {
        $user = $this->getUser();
        if (!is_object($user)) {
            return null;
        }

        return $user->getSelectedAddressId() !== null && \OxidEsales\Eshop\Core\Registry::getSession()->getVariable('blshowshipaddress') ? $user->getSelectedAddress()->oxaddress__oxzip->value : $user->oxuser__oxzip->value;
    }
}
