<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class CustomsDetailsPostalCharges extends \ArrayObject
{
    /**
     * @var array
     */
    protected $initialized = array();
    public function isInitialized($property) : bool
    {
        return array_key_exists($property, $this->initialized);
    }
    /**
     * iso 4217 3 character currency code accepted. Recommended to use EUR where possible
     *
     * @var string
     */
    protected $currency;
    /**
     * Numeric value
     *
     * @var float
     */
    protected $value;
    /**
     * iso 4217 3 character currency code accepted. Recommended to use EUR where possible
     *
     * @return string
     */
    public function getCurrency() : string
    {
        return $this->currency;
    }
    /**
     * iso 4217 3 character currency code accepted. Recommended to use EUR where possible
     *
     * @param string $currency
     *
     * @return self
     */
    public function setCurrency(string $currency) : self
    {
        $this->initialized['currency'] = true;
        $this->currency = $currency;
        return $this;
    }
    /**
     * Numeric value
     *
     * @return float
     */
    public function getValue() : float
    {
        return $this->value;
    }
    /**
     * Numeric value
     *
     * @param float $value
     *
     * @return self
     */
    public function setValue(float $value) : self
    {
        $this->initialized['value'] = true;
        $this->value = $value;
        return $this;
    }
}