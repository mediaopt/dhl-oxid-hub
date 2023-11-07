<?php

namespace Mediaopt\DHL\Api\MyAccount\Model;

class User extends \ArrayObject
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
     * user's password is valid until this timestamp
     *
     * @var \DateTime
     */
    protected $passwordValidUntil;
    /**
     * user's password is valid until this timestamp
     *
     * @return \DateTime
     */
    public function getPasswordValidUntil() : \DateTime
    {
        return $this->passwordValidUntil;
    }
    /**
     * user's password is valid until this timestamp
     *
     * @param \DateTime $passwordValidUntil
     *
     * @return self
     */
    public function setPasswordValidUntil(\DateTime $passwordValidUntil) : self
    {
        $this->initialized['passwordValidUntil'] = true;
        $this->passwordValidUntil = $passwordValidUntil;
        return $this;
    }
}