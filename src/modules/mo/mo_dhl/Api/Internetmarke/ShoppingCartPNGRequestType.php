<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class ShoppingCartPNGRequestType
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
     * @var PPL $ppl
     */
    protected $ppl = null;

    /**
     * @var ShoppingCartPosition[] $positions
     */
    protected $positions = null;

    /**
     * @var ShoppingCartPrice $total
     */
    protected $total = null;

    /**
     * @var Flag $createManifest
     */
    protected $createManifest = null;

    /**
     * @var ShippingList $createShippingList
     */
    protected $createShippingList = null;

    /**
     * @param ShoppingCartPosition[] $positions
     * @param ShoppingCartPrice $total
     */
    public function __construct(array $positions, $total)
    {
      $this->positions = $positions;
      $this->total = $total;
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
     * @return ShoppingCartPNGRequestType
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
     * @return ShoppingCartPNGRequestType
     */
    public function setShopOrderId($shopOrderId)
    {
      $this->shopOrderId = $shopOrderId;
      return $this;
    }

    /**
     * @return PPL
     */
    public function getPpl()
    {
      return $this->ppl;
    }

    /**
     * @param PPL $ppl
     * @return ShoppingCartPNGRequestType
     */
    public function setPpl($ppl)
    {
      $this->ppl = $ppl;
      return $this;
    }

    /**
     * @return ShoppingCartPosition[]
     */
    public function getPositions()
    {
      return $this->positions;
    }

    /**
     * @param ShoppingCartPosition[] $positions
     * @return ShoppingCartPNGRequestType
     */
    public function setPositions(array $positions)
    {
      $this->positions = $positions;
      return $this;
    }

    /**
     * @return ShoppingCartPrice
     */
    public function getTotal()
    {
      return $this->total;
    }

    /**
     * @param ShoppingCartPrice $total
     * @return ShoppingCartPNGRequestType
     */
    public function setTotal($total)
    {
      $this->total = $total;
      return $this;
    }

    /**
     * @return Flag
     */
    public function getCreateManifest()
    {
      return $this->createManifest;
    }

    /**
     * @param Flag $createManifest
     * @return ShoppingCartPNGRequestType
     */
    public function setCreateManifest($createManifest)
    {
      $this->createManifest = $createManifest;
      return $this;
    }

    /**
     * @return ShippingList
     */
    public function getCreateShippingList()
    {
      return $this->createShippingList;
    }

    /**
     * @param ShippingList $createShippingList
     * @return ShoppingCartPNGRequestType
     */
    public function setCreateShippingList($createShippingList)
    {
      $this->createShippingList = $createShippingList;
      return $this;
    }

}
