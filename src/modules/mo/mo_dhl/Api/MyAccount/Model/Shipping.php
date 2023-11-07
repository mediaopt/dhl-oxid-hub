<?php

namespace Mediaopt\DHL\Api\MyAccount\Model;

class Shipping extends \ArrayObject
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
     * customer's ship customer config details
     *
     * @var Detail[]
     */
    protected $details;
    /**
     * customer's ship customer config details
     *
     * @return Detail[]
     */
    public function getDetails() : array
    {
        return $this->details;
    }
    /**
     * customer's ship customer config details
     *
     * @param Detail[] $details
     *
     * @return self
     */
    public function setDetails(array $details) : self
    {
        $this->initialized['details'] = true;
        $this->details = $details;
        return $this;
    }
}