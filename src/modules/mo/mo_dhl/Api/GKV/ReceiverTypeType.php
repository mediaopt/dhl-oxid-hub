<?php

namespace Mediaopt\DHL\Api\GKV;

class ReceiverTypeType
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
     * @var PostfilialeTypeNoCountry $Postfiliale
     */
    protected $Postfiliale = null;

    /**
     * @var CommunicationType $Communication
     */
    protected $Communication = null;

    /**
     * @param string                    $name1
     * @param ReceiverNativeAddressType $Address
     * @param PackStationType           $Packstation
     * @param PostfilialeTypeNoCountry  $Postfiliale
     */
    public function __construct($name1, $Address, $Packstation, $Postfiliale)
    {
        $this->name1 = $name1;
        $this->Address = $Address;
        $this->Packstation = $Packstation;
        $this->Postfiliale = $Postfiliale;
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
     * @return ReceiverTypeType
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
     * @return ReceiverTypeType
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
     * @return ReceiverTypeType
     */
    public function setPackstation($Packstation)
    {
        $this->Packstation = $Packstation;
        return $this;
    }

    /**
     * @return PostfilialeTypeNoCountry
     */
    public function getPostfiliale()
    {
        return $this->Postfiliale;
    }

    /**
     * @param PostfilialeTypeNoCountry $Postfiliale
     * @return ReceiverTypeType
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
     * @return ReceiverTypeType
     */
    public function setCommunication($Communication)
    {
        $this->Communication = $Communication;
        return $this;
    }

}
