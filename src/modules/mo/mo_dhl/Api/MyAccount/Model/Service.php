<?php

namespace Mediaopt\DHL\Api\MyAccount\Model;

class Service extends \ArrayObject
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
     * language indenpendent key of service
     *
     * @var string
     */
    protected $key;
    /**
     * name of service
     *
     * @var string
     */
    protected $name;
    /**
     * language indenpendent key of service
     *
     * @return string
     */
    public function getKey() : string
    {
        return $this->key;
    }
    /**
     * language indenpendent key of service
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
     * name of service
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * name of service
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
}