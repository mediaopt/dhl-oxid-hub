<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class ShoppingCart
{

    /**
     * @var ShopOrderId $shopOrderId
     */
    protected $shopOrderId = null;

    /**
     * @var VoucherList $voucherList
     */
    protected $voucherList = null;

    /**
     * @param VoucherList $voucherList
     */
    public function __construct($voucherList)
    {
      $this->voucherList = $voucherList;
    }

    /**
     * @return ShopOrderId
     */
    public function getShopOrderId()
    {
      return $this->shopOrderId;
    }

    /**
     * @param ShopOrderId $shopOrderId
     * @return ShoppingCart
     */
    public function setShopOrderId($shopOrderId)
    {
      $this->shopOrderId = $shopOrderId;
      return $this;
    }

    /**
     * @return VoucherList
     */
    public function getVoucherList()
    {
      return $this->voucherList;
    }

    /**
     * @param VoucherList $voucherList
     * @return ShoppingCart
     */
    public function setVoucherList($voucherList)
    {
      $this->voucherList = $voucherList;
      return $this;
    }

}
