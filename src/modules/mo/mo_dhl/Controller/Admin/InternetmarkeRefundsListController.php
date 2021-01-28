<?php


namespace Mediaopt\DHL\Controller\Admin;

use Mediaopt\DHL\Model\MoDHLInternetmarkeRefund;

class InternetmarkeRefundsListController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminListController
{
    /**
     * @var string
     */
    protected $_sThisTemplate = 'mo_dhl__internetmarke_refunds_list.tpl';

    /**
     * @var string
     */
    protected $_sListClass = MoDHLInternetmarkeRefund::class;
}
