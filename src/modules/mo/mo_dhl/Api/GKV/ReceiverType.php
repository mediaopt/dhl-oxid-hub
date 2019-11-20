<?php

namespace Mediaopt\DHL\Api\GKV;

class ReceiverType
{

    /**
     * @var string $name1
     */
    protected $name1 = null;

    /**
     * @var ReceiverNativeAddressType $Address
     */
    protected $Address = null;

    /**
     * @var PackStationType $Packstation
     */
    protected $Packstation = null;

    /**
     * @var PostfilialeType $Postfiliale
     */
    protected $Postfiliale = null;

    /**
     * @var CommunicationType $Communication
     */
    protected $Communication = null;

    /**
     * @param string $name1
     */
    public function __construct($name1)
    {
        $this->name1 = $name1;
    }

    /**
     * @return string
     */
    public function getName1()
    {
        return $this->name1;
    }

    /**
     * @param string $name1
     * @return ReceiverType
     */
    public function setName1($name1)
    {
        $this->name1 = $name1;
        return $this;
    }

    /**
     * @return ReceiverNativeAddressType
     */
    public function getAddress()
    {
        return $this->Address;
    }

    /**
     * @param ReceiverNativeAddressType $Address
     * @return ReceiverType
     */
    public function setAddress($Address)
    {
        $this->Address = $Address;
        return $this;
    }

    /**
     * @return PackStationType
     */
    public function getPackstation()
    {
        return $this->Packstation;
    }

    /**
     * @param PackStationType $Packstation
     * @return ReceiverType
     */
    public function setPackstation($Packstation)
    {
        $this->Packstation = $Packstation;
        return $this;
    }

    /**
     * @return PostfilialeType
     */
    public function getPostfiliale()
    {
        return $this->Postfiliale;
    }

    /**
     * @param PostfilialeType $Postfiliale
     * @return ReceiverType
     */
    public function setPostfiliale($Postfiliale)
    {
        $this->Postfiliale = $Postfiliale;
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
     * @return ReceiverType
     */
    public function setCommunication($Communication)
    {
        $this->Communication = $Communication;
        return $this;
    }

}
