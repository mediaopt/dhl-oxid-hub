<?php


namespace Mediaopt\DHL\Api\ProdWS;

class TempUnitPriceType
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
     * @var TimestampType $validFrom
     */
    protected $validFrom = null;

    /**
     * @var TimestampType $validTo
     */
    protected $validTo = null;

    /**
     * @param float              $rate
     * @param CurrencyAmountType $grossPrice
     * @param TimestampType      $validFrom
     * @param TimestampType      $validTo
     */
    public function __construct($rate, $grossPrice, $validFrom, $validTo)
    {
      $this->rate = $rate;
      $this->grossPrice = $grossPrice;
      $this->validFrom = $validFrom;
      $this->validTo = $validTo;
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
     * @return TempUnitPriceType
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
     * @return TempUnitPriceType
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
     * @return TempUnitPriceType
     */
    public function setGrossPrice($grossPrice)
    {
      $this->grossPrice = $grossPrice;
      return $this;
    }

    /**
     * @return TimestampType
     */
    public function getValidFrom()
    {
      return $this->validFrom;
    }

    /**
     * @param TimestampType $validFrom
     * @return TempUnitPriceType
     */
    public function setValidFrom($validFrom)
    {
      $this->validFrom = $validFrom;
      return $this;
    }

    /**
     * @return TimestampType
     */
    public function getValidTo()
    {
      return $this->validTo;
    }

    /**
     * @param TimestampType $validTo
     * @return TempUnitPriceType
     */
    public function setValidTo($validTo)
    {
      $this->validTo = $validTo;
      return $this;
    }

}
