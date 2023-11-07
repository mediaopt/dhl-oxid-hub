<?php

namespace Mediaopt\DHL\Api\MyAccount\Model;

class AggregatedUserDataResponse extends \ArrayObject
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
     * The use profile data
     *
     * @var User
     */
    protected $user;
    /**
     * The customer's ship customer config, if user has ship role
     *
     * @var Shipping
     */
    protected $shippingRights;
    /**
     * The use profile data
     *
     * @return User
     */
    public function getUser() : User
    {
        return $this->user;
    }
    /**
     * The use profile data
     *
     * @param User $user
     *
     * @return self
     */
    public function setUser(User $user) : self
    {
        $this->initialized['user'] = true;
        $this->user = $user;
        return $this;
    }
    /**
     * The customer's ship customer config, if user has ship role
     *
     * @return Shipping
     */
    public function getShippingRights() : Shipping
    {
        return $this->shippingRights;
    }
    /**
     * The customer's ship customer config, if user has ship role
     *
     * @param Shipping $shippingRights
     *
     * @return self
     */
    public function setShippingRights(Shipping $shippingRights) : self
    {
        $this->initialized['shippingRights'] = true;
        $this->shippingRights = $shippingRights;
        return $this;
    }
}