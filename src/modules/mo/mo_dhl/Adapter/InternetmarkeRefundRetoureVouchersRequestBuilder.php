<?php


namespace Mediaopt\DHL\Adapter;


use Mediaopt\DHL\Api\Internetmarke\RetoureVouchersRequestType;
use Mediaopt\DHL\Api\Internetmarke\ShoppingCart;
use Mediaopt\DHL\Api\Internetmarke\VoucherList;
use OxidEsales\Eshop\Core\Registry;

class InternetmarkeRefundRetoureVouchersRequestBuilder
{

    /**
     * @param int $shopOrderId
     * @return RetoureVouchersRequestType
     */
    public function build(int $shopOrderId)
    {
        $shoppingCart = new ShoppingCart($shopOrderId, null);
        return new RetoureVouchersRequestType(null, $this->buildRetoureId(), $shoppingCart);
    }

    /**
     * @return string|null
     */
    protected function buildRetoureId()
    {
        $internetMarkeRefund = Registry::get(DHLAdapter::class)->buildInternetmarkeRefund();
        return $internetMarkeRefund->createRetoureId()->getShopRetoureId();
    }
}