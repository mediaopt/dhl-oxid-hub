<?php


namespace Mediaopt\DHL\Api\ProdWS;

class SeekProductResponseType
{

    /**
     * @var SalesProduct[] $salesProduct
     */
    protected $salesProduct = null;

    /**
     * @var string $message
     */
    protected $message = null;


    public function __construct()
    {

    }

    /**
     * @return SalesProduct[]
     */
    public function getSalesProduct()
    {
      return $this->salesProduct;
    }

    /**
     * @param SalesProduct[] $salesProduct
     * @return SeekProductResponseType
     */
    public function setSalesProduct(array $salesProduct = null)
    {
      $this->salesProduct = $salesProduct;
      return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
      return $this->message;
    }

    /**
     * @param string $message
     * @return SeekProductResponseType
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

}
