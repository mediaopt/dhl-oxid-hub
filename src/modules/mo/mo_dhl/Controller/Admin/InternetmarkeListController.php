<?php


namespace Mediaopt\DHL\Controller\Admin;


use Mediaopt\DHL\Model\MoDHLInternetmarkeProduct;

class InternetmarkeListController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminListController
{
    /**
     * @var string
     */
    protected $_sThisTemplate = 'mo_dhl__internetmarke_list.tpl';

    /**
     * @var string
     */
    protected $_sListClass = MoDHLInternetmarkeProduct::class;

    /**
     * @param string[] $whereQuery
     * @param string   $fullQuery
     * @return string
     */
     protected function _prepareWhereQuery($whereQuery, $fullQuery)
     {
         $whereQuery['mo_dhl_internetmarke_products.type'] = MoDHLInternetmarkeProduct::INTERNETMARKE_PRODUCT_TYPE_SALES;
         return parent::_prepareWhereQuery($whereQuery, $fullQuery);
     }
}
