<?php

namespace Mediaopt\DHL\Api\MyAccount\Model;

class ApiVersionResponseBackend extends \ArrayObject
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
     * environment
     *
     * @var string
     */
    protected $env;
    /**
     * version of backend
     *
     * @var string
     */
    protected $version;
    /**
     * environment
     *
     * @return string
     */
    public function getEnv() : string
    {
        return $this->env;
    }
    /**
     * environment
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
     * version of backend
     *
     * @return string
     */
    public function getVersion() : string
    {
        return $this->version;
    }
    /**
     * version of backend
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