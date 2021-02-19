<?php


namespace Mediaopt\DHL\Api\ProdWS;

class BasicProductList
{

    /**
     * @var BasicProductType[] $BasicProduct
     */
    protected $BasicProduct = null;

    /**
     * @param BasicProductType[] $BasicProduct
     */
    public function __construct($BasicProduct)
    {
      $this->BasicProduct = $BasicProduct;
    }

    /**
     * @return BasicProductType[]
     */
    public function getBasicProduct()
    {
      return $this->BasicProduct;
    }

    /**
     * @param BasicProductType[] $BasicProduct
     * @return BasicProductList
     */
    public function setBasicProduct($BasicProduct)
    {
      $this->BasicProduct = $BasicProduct;
      return $this;
    }

}
