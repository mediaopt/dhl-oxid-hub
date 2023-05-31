<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class ShippingConfirmation extends \ArrayObject
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
     * Email address(es) of the recipient of the confirmation.
     *
     * @var string
     */
    protected $email;
    /**
     * Email address(es) of the recipient of the confirmation.
     *
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }
    /**
     * Email address(es) of the recipient of the confirmation.
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email) : self
    {
        $this->initialized['email'] = true;
        $this->email = $email;
        return $this;
    }
}