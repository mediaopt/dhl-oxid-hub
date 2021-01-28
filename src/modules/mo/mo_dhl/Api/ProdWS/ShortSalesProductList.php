<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ShortSalesProductList
{

    /**
     * @var ShortSalesProductType $ShortSalesProduct
     */
    protected $ShortSalesProduct = null;

    /**
     * @param ShortSalesProductType $ShortSalesProduct
     */
    public function __construct($ShortSalesProduct)
    {
      $this->ShortSalesProduct = $ShortSalesProduct;
    }

    /**
     * @return ShortSalesProductType
     */
    public function getShortSalesProduct()
    {
      return $this->ShortSalesProduct;
    }

    /**
     * @param ShortSalesProductType $ShortSalesProduct
     * @return ShortSalesProductList
     */
    public function setShortSalesProduct($ShortSalesProduct)
    {
      $this->ShortSalesProduct = $ShortSalesProduct;
      return $this;
    }

}
