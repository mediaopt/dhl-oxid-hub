<?php

namespace Mediaopt\DHL\Api\Authentication\Model;

class TokenResponse extends \ArrayObject
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
    protected $accessToken;
    /**
     * Will be set to 'Bearer'
     *
     * @var string
     */
    protected $tokenType;
    /**
     * Seconds
     *
     * @var int
     */
    protected $expiresIn;
    /**
     * 
     *
     * @return string
     */
    public function getAccessToken() : string
    {
        return $this->accessToken;
    }
    /**
     * 
     *
     * @param string $accessToken
     *
     * @return self
     */
    public function setAccessToken(string $accessToken) : self
    {
        $this->initialized['accessToken'] = true;
        $this->accessToken = $accessToken;
        return $this;
    }
    /**
     * Will be set to 'Bearer'
     *
     * @return string
     */
    public function getTokenType() : string
    {
        return $this->tokenType;
    }
    /**
     * Will be set to 'Bearer'
     *
     * @param string $tokenType
     *
     * @return self
     */
    public function setTokenType(string $tokenType) : self
    {
        $this->initialized['tokenType'] = true;
        $this->tokenType = $tokenType;
        return $this;
    }
    /**
     * Seconds
     *
     * @return int
     */
    public function getExpiresIn() : int
    {
        return $this->expiresIn;
    }
    /**
     * Seconds
     *
     * @param int $expiresIn
     *
     * @return self
     */
    public function setExpiresIn(int $expiresIn) : self
    {
        $this->initialized['expiresIn'] = true;
        $this->expiresIn = $expiresIn;
        return $this;
    }
}