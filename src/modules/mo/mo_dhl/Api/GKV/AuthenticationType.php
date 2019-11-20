<?php

namespace Mediaopt\DHL\Api\GKV;

class AuthenticationType
{

    /**
     * @var  string $user
     */
    protected $user = null;

    /**
     * @var string $signature
     */
    protected $signature = null;

    /**
     * @param string $user
     * @param string $signature
     */
    public function __construct($user, $signature)
    {
        $this->user = $user;
        $this->signature = $signature;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     * @return AuthenticationType
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param string $signature
     * @return AuthenticationType
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
        return $this;
    }

}
