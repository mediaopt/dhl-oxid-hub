<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CurrencyValueType
{

    /**
     * @var CurrencyAmountType $minValue
     */
    protected $minValue = null;

    /**
     * @var CurrencyAmountType $maxValue
     */
    protected $maxValue = null;

    /**
     * @var CurrencyAmountType $fixValue
     */
    protected $fixValue = null;


    public function __construct()
    {

    }

    /**
     * @return CurrencyAmountType
     */
    public function getMinValue()
    {
      return $this->minValue;
    }

    /**
     * @param CurrencyAmountType $minValue
     * @return CurrencyValueType
     */
    public function setMinValue($minValue)
    {
      $this->minValue = $minValue;
      return $this;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getMaxValue()
    {
      return $this->maxValue;
    }

    /**
     * @param CurrencyAmountType $maxValue
     * @return CurrencyValueType
     */
    public function setMaxValue($maxValue)
    {
      $this->maxValue = $maxValue;
      return $this;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getFixValue()
    {
      return $this->fixValue;
    }

    /**
     * @param CurrencyAmountType $fixValue
     * @return CurrencyValueType
     */
    public function setFixValue($fixValue)
    {
      $this->fixValue = $fixValue;
      return $this;
    }

}
