<?php

namespace Mediaopt\DHL\Api\MyAccount\Model;

class ApiVersionResponseAmp extends \ArrayObject
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
     * name of api
     *
     * @var string
     */
    protected $name;
    /**
     * environment
     *
     * @var string
     */
    protected $env;
    /**
     * version of api
     *
     * @var string
     */
    protected $version;
    /**
     * revision
     *
     * @var string
     */
    protected $rev;
    /**
     * name of api
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * name of api
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
     * version of api
     *
     * @return string
     */
    public function getVersion() : string
    {
        return $this->version;
    }
    /**
     * version of api
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
     * revision
     *
     * @return string
     */
    public function getRev() : string
    {
        return $this->rev;
    }
    /**
     * revision
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
}