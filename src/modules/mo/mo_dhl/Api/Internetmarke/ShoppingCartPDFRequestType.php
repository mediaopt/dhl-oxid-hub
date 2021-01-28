<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class ShoppingCartPDFRequestType
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
     * @var PageFormatId $pageFormatId
     */
    protected $pageFormatId = null;

    /**
     * @var PPL $ppl
     */
    protected $ppl = null;

    /**
     * @var ShoppingCartPDFPosition[] $positions
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
     * @param PageFormatId $pageFormatId
     * @param ShoppingCartPDFPosition[] $positions
     * @param ShoppingCartPrice $total
     */
    public function __construct($pageFormatId, array $positions, $total)
    {
      $this->pageFormatId = $pageFormatId;
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
     * @return ShoppingCartPDFRequestType
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
     * @return ShoppingCartPDFRequestType
     */
    public function setShopOrderId($shopOrderId)
    {
      $this->shopOrderId = $shopOrderId;
      return $this;
    }

    /**
     * @return PageFormatId
     */
    public function getPageFormatId()
    {
      return $this->pageFormatId;
    }

    /**
     * @param PageFormatId $pageFormatId
     * @return ShoppingCartPDFRequestType
     */
    public function setPageFormatId($pageFormatId)
    {
      $this->pageFormatId = $pageFormatId;
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
     * @return ShoppingCartPDFRequestType
     */
    public function setPpl($ppl)
    {
      $this->ppl = $ppl;
      return $this;
    }

    /**
     * @return ShoppingCartPDFPosition[]
     */
    public function getPositions()
    {
      return $this->positions;
    }

    /**
     * @param ShoppingCartPDFPosition[] $positions
     * @return ShoppingCartPDFRequestType
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
     * @return ShoppingCartPDFRequestType
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
     * @return ShoppingCartPDFRequestType
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
     * @return ShoppingCartPDFRequestType
     */
    public function setCreateShippingList($createShippingList)
    {
      $this->createShippingList = $createShippingList;
      return $this;
    }

}
