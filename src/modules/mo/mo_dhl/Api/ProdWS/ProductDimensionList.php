<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ProductDimensionList
{

    /**
     * @var ProductDimension $productDimension
     */
    protected $productDimension = null;

    /**
     * @param ProductDimension $productDimension
     */
    public function __construct($productDimension)
    {
      $this->productDimension = $productDimension;
    }

    /**
     * @return ProductDimension
     */
    public function getProductDimension()
    {
      return $this->productDimension;
    }

    /**
     * @param ProductDimension $productDimension
     * @return ProductDimensionList
     */
    public function setProductDimension($productDimension)
    {
      $this->productDimension = $productDimension;
      return $this;
    }

}
