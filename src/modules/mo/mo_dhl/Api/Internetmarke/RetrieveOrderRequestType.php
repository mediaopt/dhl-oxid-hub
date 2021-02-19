<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class RetrieveOrderRequestType
{

    /**
     * @var UserToken $userToken
     */
    protected $userToken = null;

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
     * @return UserToken
     */
    public function getUserToken()
    {
      return $this->userToken;
    }

    /**
     * @param UserToken $userToken
     * @return RetrieveOrderRequestType
     */
    public function setUserToken($userToken)
    {
      $this->userToken = $userToken;
      return $this;
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
     * @return RetrieveOrderRequestType
     */
    public function setShopOrderId($shopOrderId)
    {
      $this->shopOrderId = $shopOrderId;
      return $this;
    }

}
