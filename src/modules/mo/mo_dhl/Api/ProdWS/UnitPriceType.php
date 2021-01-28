<?php


namespace Mediaopt\DHL\Api\ProdWS;

class UnitPriceType
{

    /**
     * @var CurrencyAmountType $netPrice
     */
    protected $netPrice = null;

    /**
     * @var float $rate
     */
    protected $rate = null;

    /**
     * @var CurrencyAmountType $grossPrice
     */
    protected $grossPrice = null;

    /**
     * @var ValidityType $priceValidity
     */
    protected $priceValidity = null;

    /**
     * @var TempPriceList $tempPriceList
     */
    protected $tempPriceList = null;

    /**
     * @param float              $rate
     * @param CurrencyAmountType $grossPrice
     */
    public function __construct($rate, $grossPrice)
    {
      $this->rate = $rate;
      $this->grossPrice = $grossPrice;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getNetPrice()
    {
      return $this->netPrice;
    }

    /**
     * @param CurrencyAmountType $netPrice
     * @return UnitPriceType
     */
    public function setNetPrice($netPrice)
    {
      $this->netPrice = $netPrice;
      return $this;
    }

    /**
     * @return float
     */
    public function getRate()
    {
      return $this->rate;
    }

    /**
     * @param float $rate
     * @return UnitPriceType
     */
    public function setRate($rate)
    {
      $this->rate = $rate;
      return $this;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getGrossPrice()
    {
      return $this->grossPrice;
    }

    /**
     * @param CurrencyAmountType $grossPrice
     * @return UnitPriceType
     */
    public function setGrossPrice($grossPrice)
    {
      $this->grossPrice = $grossPrice;
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
     * @return UnitPriceType
     */
    public function setPriceValidity($priceValidity)
    {
      $this->priceValidity = $priceValidity;
      return $this;
    }

    /**
     * @return TempPriceList
     */
    public function getTempPriceList()
    {
      return $this->tempPriceList;
    }

    /**
     * @param TempPriceList $tempPriceList
     * @return UnitPriceType
     */
    public function setTempPriceList($tempPriceList)
    {
      $this->tempPriceList = $tempPriceList;
      return $this;
    }

}
