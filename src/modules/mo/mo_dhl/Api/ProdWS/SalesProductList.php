<?php


namespace Mediaopt\DHL\Api\ProdWS;

class SalesProductList
{

    /**
     * @var SalesProductType $SalesProduct
     */
    protected $SalesProduct = null;

    /**
     * @param SalesProductType $SalesProduct
     */
    public function __construct($SalesProduct)
    {
      $this->SalesProduct = $SalesProduct;
    }

    /**
     * @return SalesProductType
     */
    public function getSalesProduct()
    {
      return $this->SalesProduct;
    }

    /**
     * @param SalesProductType $SalesProduct
     * @return SalesProductList
     */
    public function setSalesProduct($SalesProduct)
    {
      $this->SalesProduct = $SalesProduct;
      return $this;
    }

}
