<?php

namespace Mediaopt\DHL\Api\GKV;

class ShipperTypeType
{

    /**
     * @var NameType $Name
     */
    protected $Name = null;

    /**
     * @var NativeAddressTypeNew $Address
     */
    protected $Address = null;

    /**
     * @var CommunicationType $Communication
     */
    protected $Communication = null;

    /**
     * @param NameType             $Name
     * @param NativeAddressTypeNew $Address
     */
    public function __construct($Name, $Address)
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
     * @return ShipperTypeType
     */
    public function setName($Name)
    {
        $this->Name = $Name;
        return $this;
    }

    /**
     * @return NativeAddressTypeNew
     */
    public function getAddress()
    {
        return $this->Address;
    }

    /**
     * @param NativeAddressTypeNew $Address
     * @return ShipperTypeType
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
     * @return ShipperTypeType
     */
    public function setCommunication($Communication)
    {
        $this->Communication = $Communication;
        return $this;
    }

}
