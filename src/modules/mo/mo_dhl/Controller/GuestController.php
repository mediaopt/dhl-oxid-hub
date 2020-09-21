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
    /** @var Order */
    protected $order;

    /**
     * @extend
     * @return string
     */
    public function render()
    {
        $uid = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('uid');
        $oDb = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();
        $sQ = "select oxid from oxorder where MD5( CONCAT( oxid, oxshopid, oxuserid ) ) = " . $oDb->quote($uid);

        if ($orderId = $oDb->getOne($sQ)) {
            $order = oxNew(Order::class);
            $order->load($orderId);
            $this->order = $order;

            $this->addTplParam('order', $this->order);
            $this->addTplParam('uid', $uid);
        }

        parent::render();

        return 'mo_dhl__guest_order.tpl';
    }

    /**
     * Returns current order user object
     *
     * @return \OxidEsales\Eshop\Application\Model\User
     */
    public function getUser()
    {
        return $this->order->getOrderUser();
    }
}
