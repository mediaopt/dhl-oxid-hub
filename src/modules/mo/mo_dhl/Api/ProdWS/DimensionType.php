<?php


namespace Mediaopt\DHL\Api\ProdWS;

class DimensionType
{

    /**
     * @var mixed $value
     */
    protected $value = null;

    /**
     * @var mixed $unit
     */
    protected $unit = null;

    /**
     * @param mixed $value
     * @param mixed $unit
     */
    public function __construct($value, $unit)
    {
      $this->value = $value;
      $this->unit = $unit;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
      return $this->value;
    }

    /**
     * @param mixed $value
     * @return DimensionType
     */
    public function setValue($value)
    {
      $this->value = $value;
      return $this;
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
      return $this->unit;
    }

    /**
     * @param mixed $unit
     * @return DimensionType
     */
    public function setUnit($unit)
    {
      $this->unit = $unit;
      return $this;
    }

}
