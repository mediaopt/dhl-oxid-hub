<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class Weight extends \ArrayObject
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
     * metric unit for weight
     *
     * @var string
     */
    protected $uom;
    /**
     * 
     *
     * @var float
     */
    protected $value;
    /**
     * metric unit for weight
     *
     * @return string
     */
    public function getUom() : string
    {
        return $this->uom;
    }
    /**
     * metric unit for weight
     *
     * @param string $uom
     *
     * @return self
     */
    public function setUom(string $uom) : self
    {
        $this->initialized['uom'] = true;
        $this->uom = $uom;
        return $this;
    }
    /**
     * 
     *
     * @return float
     */
    public function getValue() : float
    {
        return $this->value;
    }
    /**
     * 
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