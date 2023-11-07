<?php

namespace Mediaopt\DHL\Api\MyAccount\Model;

class ApiVersionResponseHTML extends \ArrayObject
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
     * @var ApiVersionResponseHTMLAmp
     */
    protected $amp;
    /**
     * 
     *
     * @return ApiVersionResponseHTMLAmp
     */
    public function getAmp() : ApiVersionResponseHTMLAmp
    {
        return $this->amp;
    }
    /**
     * 
     *
     * @param ApiVersionResponseHTMLAmp $amp
     *
     * @return self
     */
    public function setAmp(ApiVersionResponseHTMLAmp $amp) : self
    {
        $this->initialized['amp'] = true;
        $this->amp = $amp;
        return $this;
    }
}