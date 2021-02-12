<?php


namespace Mediaopt\DHL\Api\ProdWS;

class PriceType
{

    /**
     * @var CurrencyAmountType $calculatedNetPrice
     */
    protected $calculatedNetPrice = null;

    /**
     * @var CurrencyAmountType $calculatedGrossPrice
     */
    protected $calculatedGrossPrice = null;

    /**
     * @var CurrencyAmountType $commercialBalance
     */
    protected $commercialBalance = null;

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
     */
    public function __construct($commercialGrossPrice)
    {
      $this->commercialGrossPrice = $commercialGrossPrice;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getCalculatedNetPrice()
    {
      return $this->calculatedNetPrice;
    }

    /**
     * @param CurrencyAmountType $calculatedNetPrice
     * @return PriceType
     */
    public function setCalculatedNetPrice($calculatedNetPrice)
    {
      $this->calculatedNetPrice = $calculatedNetPrice;
      return $this;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getCalculatedGrossPrice()
    {
      return $this->calculatedGrossPrice;
    }

    /**
     * @param CurrencyAmountType $calculatedGrossPrice
     * @return PriceType
     */
    public function setCalculatedGrossPrice($calculatedGrossPrice)
    {
      $this->calculatedGrossPrice = $calculatedGrossPrice;
      return $this;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getCommercialBalance()
    {
      return $this->commercialBalance;
    }

    /**
     * @param CurrencyAmountType $commercialBalance
     * @return PriceType
     */
    public function setCommercialBalance($commercialBalance)
    {
      $this->commercialBalance = $commercialBalance;
      return $this;
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
     * @return PriceType
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
     * @return PriceType
     */
    public function setPriceValidity($priceValidity)
    {
      $this->priceValidity = $priceValidity;
      return $this;
    }

}
