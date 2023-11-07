<?php

namespace Mediaopt\DHL\Api\Authentication\Model;

class GetResponse200Amp extends \ArrayObject
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
    protected $name;
    /**
     * Sandbox version is >= Prod version
     *
     * @var string
     */
    protected $version;
    /**
     * 
     *
     * @var string
     */
    protected $rev;
    /**
     * 
     *
     * @var string
     */
    protected $env;
    /**
     * 
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * 
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
     * Sandbox version is >= Prod version
     *
     * @return string
     */
    public function getVersion() : string
    {
        return $this->version;
    }
    /**
     * Sandbox version is >= Prod version
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
    /**
     * 
     *
     * @return string
     */
    public function getRev() : string
    {
        return $this->rev;
    }
    /**
     * 
     *
     * @param string $rev
     *
     * @return self
     */
    public function setRev(string $rev) : self
    {
        $this->initialized['rev'] = true;
        $this->rev = $rev;
        return $this;
    }
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
}