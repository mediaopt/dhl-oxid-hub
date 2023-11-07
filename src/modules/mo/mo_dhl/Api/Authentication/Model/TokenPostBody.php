<?php

namespace Mediaopt\DHL\Api\Authentication\Model;

class TokenPostBody extends \ArrayObject
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
    protected $grantType;
    /**
     * GKP user name. Required for grant_type=password.
     *
     * @var string
     */
    protected $username;
    /**
     * GKP password. Required for grant_type=password.
     *
     * @var string
     */
    protected $password;
    /**
     * 
     *
     * @var string
     */
    protected $clientId;
    /**
     * 
     *
     * @var string
     */
    protected $clientSecret;
    /**
     * 
     *
     * @return string
     */
    public function getGrantType() : string
    {
        return $this->grantType;
    }
    /**
     * 
     *
     * @param string $grantType
     *
     * @return self
     */
    public function setGrantType(string $grantType) : self
    {
        $this->initialized['grantType'] = true;
        $this->grantType = $grantType;
        return $this;
    }
    /**
     * GKP user name. Required for grant_type=password.
     *
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }
    /**
     * GKP user name. Required for grant_type=password.
     *
     * @param string $username
     *
     * @return self
     */
    public function setUsername(string $username) : self
    {
        $this->initialized['username'] = true;
        $this->username = $username;
        return $this;
    }
    /**
     * GKP password. Required for grant_type=password.
     *
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }
    /**
     * GKP password. Required for grant_type=password.
     *
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password) : self
    {
        $this->initialized['password'] = true;
        $this->password = $password;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getClientId() : string
    {
        return $this->clientId;
    }
    /**
     * 
     *
     * @param string $clientId
     *
     * @return self
     */
    public function setClientId(string $clientId) : self
    {
        $this->initialized['clientId'] = true;
        $this->clientId = $clientId;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getClientSecret() : string
    {
        return $this->clientSecret;
    }
    /**
     * 
     *
     * @param string $clientSecret
     *
     * @return self
     */
    public function setClientSecret(string $clientSecret) : self
    {
        $this->initialized['clientSecret'] = true;
        $this->clientSecret = $clientSecret;
        return $this;
    }
}