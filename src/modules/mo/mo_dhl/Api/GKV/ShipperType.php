<?php

namespace Mediaopt\DHL\Api\GKV;

class ShipperType
{

    /**
     * @var NameType $Name
     */
    protected $Name = null;

    /**
     * @var NativeAddressType $Address
     */
    protected $Address = null;

    /**
     * @var CommunicationType $Communication
     */
    protected $Communication = null;

    /**
     * @param NameType          $Name
     * @param NativeAddressType $Address
     */
    public function __construct(NameType $Name, NativeAddressType $Address)
    {
        $this->Name = $Name;
        $this->Address = $Address;
    }

    /**
     * @return NameType
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param NameType $Name
     * @return \Mediaopt\DHL\Api\GKV\ShipperType
     */
    public function setName($Name)
    {
        $this->Name = $Name;
        return $this;
    }

    /**
     * @return NativeAddressType
     */
    public function getAddress()
    {
        return $this->Address;
    }

    /**
     * @param NativeAddressType $Address
     * @return \Mediaopt\DHL\Api\GKV\ShipperType
     */
    public function setAddress($Address)
    {
        $this->Address = $Address;
        return $this;
    }

    /**
     * @return CommunicationType
     */
    public function getCommunication()
    {
        return $this->Communication;
    }

    /**
     * @param CommunicationType $Communication
     * @return \Mediaopt\DHL\Api\GKV\ShipperType
     */
    public function setCommunication($Communication)
    {
        $this->Communication = $Communication;
        return $this;
    }
}
