<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class CreateShopOrderIdResponse
{

    /**
     * @var ShopOrderId $shopOrderId
     */
    protected $shopOrderId = null;

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
     * @return CreateShopOrderIdResponse
     */
    public function setShopOrderId($shopOrderId)
    {
      $this->shopOrderId = $shopOrderId;
      return $this;
    }

}
