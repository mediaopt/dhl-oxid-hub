<?php


namespace Mediaopt\DHL\Api\ProdWS;

class NumericValueType
{

    /**
     * @var float $minValue
     */
    protected $minValue = null;

    /**
     * @var float $maxValue
     */
    protected $maxValue = null;

    /**
     * @var float $fixValue
     */
    protected $fixValue = null;

    /**
     * @var string $unit
     */
    protected $unit = null;

    /**
     * @param float $minValue
     * @param float $maxValue
     * @param float $fixValue
     * @param string $unit
     */
    public function __construct($minValue, $maxValue, $fixValue, $unit)
    {
      $this->minValue = $minValue;
      $this->maxValue = $maxValue;
      $this->fixValue = $fixValue;
      $this->unit = $unit;
    }

    /**
     * @return float
     */
    public function getMinValue()
    {
      return $this->minValue;
    }

    /**
     * @param float $minValue
     * @return NumericValueType
     */
    public function setMinValue($minValue)
    {
      $this->minValue = $minValue;
      return $this;
    }

    /**
     * @return float
     */
    public function getMaxValue()
    {
      return $this->maxValue;
    }

    /**
     * @param float $maxValue
     * @return NumericValueType
     */
    public function setMaxValue($maxValue)
    {
      $this->maxValue = $maxValue;
      return $this;
    }

    /**
     * @return float
     */
    public function getFixValue()
    {
      return $this->fixValue;
    }

    /**
     * @param float $fixValue
     * @return NumericValueType
     */
    public function setFixValue($fixValue)
    {
      $this->fixValue = $fixValue;
      return $this;
    }

    /**
     * @return string
     */
    public function getUnit()
    {
      return $this->unit;
    }

    /**
     * @param string $unit
     * @return NumericValueType
     */
    public function setUnit($unit)
    {
      $this->unit = $unit;
      return $this;
    }

}
