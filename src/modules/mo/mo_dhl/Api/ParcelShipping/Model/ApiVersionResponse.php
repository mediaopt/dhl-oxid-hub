<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class ApiVersionResponse extends \ArrayObject
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
     * 
     *
     * @var string
     */
    protected $env;
    /**
     * 
     *
     * @var string
     */
    protected $version;
    /**
     * 
     *
     * @return string
     */
    public function getEnv() : string
    {
        return $this->env;
    }
    /**
     * 
     *
     * @param string $env
     *
     * @return self
     */
    public function setEnv(string $env) : self
    {
        $this->initialized['env'] = true;
        $this->env = $env;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getVersion() : string
    {
        return $this->version;
    }
    /**
     * 
     *
     * @param string $version
     *
     * @return self
     */
    public function setVersion(string $version) : self
    {
        $this->initialized['version'] = true;
        $this->version = $version;
        return $this;
    }
}