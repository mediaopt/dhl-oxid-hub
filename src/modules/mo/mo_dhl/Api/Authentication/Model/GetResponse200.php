<?php

namespace Mediaopt\DHL\Api\Authentication\Model;

class GetResponse200 extends \ArrayObject
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
     * @var GetResponse200Amp
     */
    protected $amp;
    /**
     * 
     *
     * @return GetResponse200Amp
     */
    public function getAmp() : GetResponse200Amp
    {
        return $this->amp;
    }
    /**
     * 
     *
     * @param GetResponse200Amp $amp
     *
     * @return self
     */
    public function setAmp(GetResponse200Amp $amp) : self
    {
        $this->initialized['amp'] = true;
        $this->amp = $amp;
        return $this;
    }
}