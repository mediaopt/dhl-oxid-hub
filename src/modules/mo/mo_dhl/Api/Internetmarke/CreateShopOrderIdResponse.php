<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class CreateShopOrderIdResponse
{

    /**
     * @var string $shopOrderId
     */
    protected $shopOrderId = null;

    /**
     * @param string $shopOrderId
     */
    public function __construct($shopOrderId)
    {
      $this->shopOrderId = $shopOrderId;
    }

    /**
     * @return string
     */
    public function getShopOrderId()
    {
      return $this->shopOrderId;
    }

    /**
     * @param string $shopOrderId
     * @return CreateShopOrderIdResponse
     */
    public function setShopOrderId($shopOrderId)
    {
      $this->shopOrderId = $shopOrderId;
      return $this;
    }

}
