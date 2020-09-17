<?php

namespace Mediaopt\DHL\Controller;

use Mediaopt\DHL\Application\Controller\AccountOrderController;
use Mediaopt\DHL\Application\Model\Order;
use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Core\Registry;

/**
 * @author Mediaopt GmbH
 */
class GuestController extends AccountOrderController
{
    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = 'mo_dhl__guest_order.tpl';

    /**
     * @extend
     * @return string
     */
    public function render()
    {
        $uid = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('uid');
        $oDb = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();
        $sQ = "select * from oxorder where MD5( CONCAT( oxid, oxshopid, oxuserid ) ) = " . $oDb->quote($uid);

        if ($orderId = $oDb->getOne($sQ)) {
            $order = oxNew(Order::class);
            $order->load($orderId);

            $this->addTplParam('order', $order);
            $this->addTplParam('uid', $uid);
        }

        (oxNew(FrontendController::class))::render();

        return $this->_sThisTemplate;
    }
}
