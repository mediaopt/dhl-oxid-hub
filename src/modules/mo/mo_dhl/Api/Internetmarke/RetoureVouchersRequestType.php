<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class RetoureVouchersRequestType
{

    /**
     * @var UserToken $userToken
     */
    protected $userToken = null;

    /**
     * @var string $shopRetoureId
     */
    protected $shopRetoureId = null;

    /**
     * @var ShoppingCartType $shoppingCart
     */
    protected $shoppingCart = null;

    /**
     * @param UserToken $userToken
     * @param string $shopRetoureId
     * @param ShoppingCartType $shoppingCart
     */
    public function __construct($userToken, $shopRetoureId, $shoppingCart)
    {
      $this->userToken = $userToken;
      $this->shopRetoureId = $shopRetoureId;
      $this->shoppingCart = $shoppingCart;
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
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureVouchersRequestType
     */
    public function setUserToken($userToken)
    {
      $this->userToken = $userToken;
      return $this;
    }

    /**
     * @return string
     */
    public function getShopRetoureId()
    {
      return $this->shopRetoureId;
    }

    /**
     * @param string $shopRetoureId
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureVouchersRequestType
     */
    public function setShopRetoureId($shopRetoureId)
    {
      $this->shopRetoureId = $shopRetoureId;
      return $this;
    }

    /**
     * @return ShoppingCartType
     */
    public function getShoppingCart()
    {
      return $this->shoppingCart;
    }

    /**
     * @param ShoppingCartType $shoppingCart
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureVouchersRequestType
     */
    public function setShoppingCart($shoppingCart)
    {
      $this->shoppingCart = $shoppingCart;
      return $this;
    }

}
