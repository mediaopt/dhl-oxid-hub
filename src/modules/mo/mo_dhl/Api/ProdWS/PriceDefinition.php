<?php


namespace Mediaopt\DHL\Api\ProdWS;

class PriceDefinition
{

    /**
     * @var CurrencyAmountType $commercialGrossPrice
     */
    protected $commercialGrossPrice = null;

    /**
     * @var ValidityType $priceValidity
     */
    protected $priceValidity = null;

    /**
     * @param CurrencyAmountType $commercialGrossPrice
     * @param ValidityType       $priceValidity
     */
    public function __construct($commercialGrossPrice, $priceValidity)
    {
      $this->commercialGrossPrice = $commercialGrossPrice;
      $this->priceValidity = $priceValidity;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getCommercialGrossPrice()
    {
      return $this->commercialGrossPrice;
    }

    /**
     * @param CurrencyAmountType $commercialGrossPrice
     * @return PriceDefinition
     */
    public function setCommercialGrossPrice($commercialGrossPrice)
    {
      $this->commercialGrossPrice = $commercialGrossPrice;
      return $this;
    }

    /**
     * @return ValidityType
     */
    public function getPriceValidity()
    {
      return $this->priceValidity;
    }

    /**
     * @param ValidityType $priceValidity
     * @return PriceDefinition
     */
    public function setPriceValidity($priceValidity)
    {
      $this->priceValidity = $priceValidity;
      return $this;
    }

}
