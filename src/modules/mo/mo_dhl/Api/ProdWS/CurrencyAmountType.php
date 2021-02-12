<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CurrencyAmountType
{

    /**
     * @var mixed $sign
     */
    protected $sign = null;

    /**
     * @var mixed $value
     */
    protected $value = null;

    /**
     * @var mixed $currency
     */
    protected $currency = null;

    /**
     * @var boolean $calculated
     */
    protected $calculated = null;

    /**
     * @param mixed $sign
     * @param mixed $value
     * @param mixed $currency
     * @param boolean $calculated
     */
    public function __construct($sign, $value, $currency, $calculated)
    {
      $this->sign = $sign;
      $this->value = $value;
      $this->currency = $currency;
      $this->calculated = $calculated;
    }

    /**
     * @return mixed
     */
    public function getSign()
    {
      return $this->sign;
    }

    /**
     * @param mixed $sign
     * @return CurrencyAmountType
     */
    public function setSign($sign)
    {
      $this->sign = $sign;
      return $this;
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
     * @return CurrencyAmountType
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
     * @return CurrencyAmountType
     */
    public function setCurrency($currency)
    {
      $this->currency = $currency;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getCalculated()
    {
      return $this->calculated;
    }

    /**
     * @param boolean $calculated
     * @return CurrencyAmountType
     */
    public function setCalculated($calculated)
    {
      $this->calculated = $calculated;
      return $this;
    }

}
