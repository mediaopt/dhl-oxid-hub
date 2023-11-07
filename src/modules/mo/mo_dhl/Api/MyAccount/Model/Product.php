<?php

namespace Mediaopt\DHL\Api\MyAccount\Model;

class Product extends \ArrayObject
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
     * language independent key of product
     *
     * @var string
     */
    protected $key;
    /**
     * name of product
     *
     * @var string
     */
    protected $name;
    /**
     * services
     *
     * @var Service[]
     */
    protected $services;
    /**
     * language independent key of product
     *
     * @return string
     */
    public function getKey() : string
    {
        return $this->key;
    }
    /**
     * language independent key of product
     *
     * @param string $key
     *
     * @return self
     */
    public function setKey(string $key) : self
    {
        $this->initialized['key'] = true;
        $this->key = $key;
        return $this;
    }
    /**
     * name of product
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * name of product
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name) : self
    {
        $this->initialized['name'] = true;
        $this->name = $name;
        return $this;
    }
    /**
     * services
     *
     * @return Service[]
     */
    public function getServices() : array
    {
        return $this->services;
    }
    /**
     * services
     *
     * @param Service[] $services
     *
     * @return self
     */
    public function setServices(array $services) : self
    {
        $this->initialized['services'] = true;
        $this->services = $services;
        return $this;
    }
}