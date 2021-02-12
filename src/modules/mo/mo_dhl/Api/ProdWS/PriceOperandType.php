<?php


namespace Mediaopt\DHL\Api\ProdWS;

class PriceOperandType
{

    /**
     * @var mixed $value
     */
    protected $value = null;

    /**
     * @var mixed $currency
     */
    protected $currency = null;

    /**
     * @param mixed $value
     * @param mixed $currency
     */
    public function __construct($value, $currency)
    {
      $this->value = $value;
      $this->currency = $currency;
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
     * @return PriceOperandType
     */
    public function setValue($value)
    {
      $this->value = $value;
      return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
      return $this->currency;
    }

    /**
     * @param mixed $currency
     * @return PriceOperandType
     */
    public function setCurrency($currency)
    {
      $this->currency = $currency;
      return $this;
    }

}
