<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class RetrieveOrderResponseType
{

    /**
     * @var Link $link
     */
    protected $link = null;

    /**
     * @var Link $manifestLink
     */
    protected $manifestLink = null;

    /**
     * @var ShoppingCart $shoppingCart
     */
    protected $shoppingCart = null;

    /**
     * @param Link $link
     * @param ShoppingCart $shoppingCart
     */
    public function __construct($link, $shoppingCart)
    {
      $this->link = $link;
      $this->shoppingCart = $shoppingCart;
    }

    /**
     * @return Link
     */
    public function getLink()
    {
      return $this->link;
    }

    /**
     * @param Link $link
     * @return RetrieveOrderResponseType
     */
    public function setLink($link)
    {
      $this->link = $link;
      return $this;
    }

    /**
     * @return Link
     */
    public function getManifestLink()
    {
      return $this->manifestLink;
    }

    /**
     * @param Link $manifestLink
     * @return RetrieveOrderResponseType
     */
    public function setManifestLink($manifestLink)
    {
      $this->manifestLink = $manifestLink;
      return $this;
    }

    /**
     * @return ShoppingCart
     */
    public function getShoppingCart()
    {
      return $this->shoppingCart;
    }

    /**
     * @param ShoppingCart $shoppingCart
     * @return RetrieveOrderResponseType
     */
    public function setShoppingCart($shoppingCart)
    {
      $this->shoppingCart = $shoppingCart;
      return $this;
    }

}
