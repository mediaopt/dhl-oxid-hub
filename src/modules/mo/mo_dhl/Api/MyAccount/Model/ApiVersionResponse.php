<?php

namespace Mediaopt\DHL\Api\MyAccount\Model;

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
     * @var ApiVersionResponseAmp
     */
    protected $amp;
    /**
     * 
     *
     * @var ApiVersionResponseBackend
     */
    protected $backend;
    /**
     * 
     *
     * @return ApiVersionResponseAmp
     */
    public function getAmp() : ApiVersionResponseAmp
    {
        return $this->amp;
    }
    /**
     * 
     *
     * @param ApiVersionResponseAmp $amp
     *
     * @return self
     */
    public function setAmp(ApiVersionResponseAmp $amp) : self
    {
        $this->initialized['amp'] = true;
        $this->amp = $amp;
        return $this;
    }
    /**
     * 
     *
     * @return ApiVersionResponseBackend
     */
    public function getBackend() : ApiVersionResponseBackend
    {
        return $this->backend;
    }
    /**
     * 
     *
     * @param ApiVersionResponseBackend $backend
     *
     * @return self
     */
    public function setBackend(ApiVersionResponseBackend $backend) : self
    {
        $this->initialized['backend'] = true;
        $this->backend = $backend;
        return $this;
    }
}