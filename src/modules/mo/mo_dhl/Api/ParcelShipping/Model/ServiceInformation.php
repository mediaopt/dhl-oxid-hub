<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class ServiceInformation extends \ArrayObject
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
     * @var ServiceInformationAmp
     */
    protected $amp;
    /**
     * 
     *
     * @var ServiceInformationBackend
     */
    protected $backend;
    /**
     * 
     *
     * @return ServiceInformationAmp
     */
    public function getAmp() : ServiceInformationAmp
    {
        return $this->amp;
    }
    /**
     * 
     *
     * @param ServiceInformationAmp $amp
     *
     * @return self
     */
    public function setAmp(ServiceInformationAmp $amp) : self
    {
        $this->initialized['amp'] = true;
        $this->amp = $amp;
        return $this;
    }
    /**
     * 
     *
     * @return ServiceInformationBackend
     */
    public function getBackend() : ServiceInformationBackend
    {
        return $this->backend;
    }
    /**
     * 
     *
     * @param ServiceInformationBackend $backend
     *
     * @return self
     */
    public function setBackend(ServiceInformationBackend $backend) : self
    {
        $this->initialized['backend'] = true;
        $this->backend = $backend;
        return $this;
    }
}