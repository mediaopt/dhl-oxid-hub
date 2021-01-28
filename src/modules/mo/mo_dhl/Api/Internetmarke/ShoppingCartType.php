<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class ShoppingCartType
{

    /**
     * @var ShopOrderId $shopOrderId
     */
    protected $shopOrderId = null;

    /**
     * @var VoucherSetType $voucherSet
     */
    protected $voucherSet = null;

    /**
     * @param ShopOrderId $shopOrderId
     */
    public function __construct($shopOrderId)
    {
      $this->shopOrderId = $shopOrderId;
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
     * @return \Mediaopt\DHL\Api\Internetmarke\ShoppingCartType
     */
    public function setShopOrderId($shopOrderId)
    {
      $this->shopOrderId = $shopOrderId;
      return $this;
    }

    /**
     * @return VoucherSetType
     */
    public function getVoucherSet()
    {
      return $this->voucherSet;
    }

    /**
     * @param VoucherSetType $voucherSet
     * @return \Mediaopt\DHL\Api\Internetmarke\ShoppingCartType
     */
    public function setVoucherSet($voucherSet)
    {
      $this->voucherSet = $voucherSet;
      return $this;
    }

}
