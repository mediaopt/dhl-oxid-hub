<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class ContractProductResponseType
{

    /**
     * @var ProductCode $productCode
     */
    protected $productCode = null;

    /**
     * @var int $price
     */
    protected $price = null;

    /**
     * @param ProductCode $productCode
     */
    public function __construct($productCode)
    {
      $this->productCode = $productCode;
    }

    /**
     * @return ProductCode
     */
    public function getProductCode()
    {
      return $this->productCode;
    }

    /**
     * @param ProductCode $productCode
     * @return ContractProductResponseType
     */
    public function setProductCode($productCode)
    {
      $this->productCode = $productCode;
      return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
      return $this->price;
    }

    /**
     * @param int $price
     * @return ContractProductResponseType
     */
    public function setPrice($price)
    {
      $this->price = $price;
      return $this;
    }

}
