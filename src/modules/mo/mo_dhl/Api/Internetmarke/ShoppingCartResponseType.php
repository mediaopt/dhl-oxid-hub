<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class ShoppingCartResponseType
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
     * @var WalletBalance $walletBallance
     */
    protected $walletBallance = null;

    /**
     * @var ShoppingCart $shoppingCart
     */
    protected $shoppingCart = null;

    /**
     * @param Link $link
     * @param WalletBalance $walletBallance
     */
    public function __construct($link, $walletBallance)
    {
      $this->link = $link;
      $this->walletBallance = $walletBallance;
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
     * @return ShoppingCartResponseType
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
     * @return ShoppingCartResponseType
     */
    public function setManifestLink($manifestLink)
    {
      $this->manifestLink = $manifestLink;
      return $this;
    }

    /**
     * @return WalletBalance
     */
    public function getWalletBallance()
    {
      return $this->walletBallance;
    }

    /**
     * @param WalletBalance $walletBallance
     * @return ShoppingCartResponseType
     */
    public function setWalletBallance($walletBallance)
    {
      $this->walletBallance = $walletBallance;
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
     * @return ShoppingCartResponseType
     */
    public function setShoppingCart($shoppingCart)
    {
      $this->shoppingCart = $shoppingCart;
      return $this;
    }

}
