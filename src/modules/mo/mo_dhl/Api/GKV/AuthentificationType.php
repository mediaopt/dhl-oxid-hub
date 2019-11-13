<?php

namespace Mediaopt\DHL\Api\GKV;

class AuthentificationType
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
     * @return AuthentificationType
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
     * @return AuthentificationType
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
        return $this;
    }

}
