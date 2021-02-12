<?php


namespace Mediaopt\DHL\Api\ProdWS;

class AdditionalProductList
{

    /**
     * @var AdditionalProductType[] $AdditionalProduct
     */
    protected $AdditionalProduct = null;

    /**
     * @param AdditionalProductType[] $AdditionalProduct
     */
    public function __construct($AdditionalProduct)
    {
      $this->AdditionalProduct = $AdditionalProduct;
    }

    /**
     * @return AdditionalProductType[]
     */
    public function getAdditionalProduct()
    {
      return $this->AdditionalProduct;
    }

    /**
     * @param AdditionalProductType[] $AdditionalProduct
     * @return AdditionalProductList
     */
    public function setAdditionalProduct($AdditionalProduct)
    {
      $this->AdditionalProduct = $AdditionalProduct;
      return $this;
    }

}
