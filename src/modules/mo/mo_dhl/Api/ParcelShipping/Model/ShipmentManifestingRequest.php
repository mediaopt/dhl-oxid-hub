<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class ShipmentManifestingRequest extends \ArrayObject
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
    protected $profile;
    /**
     * List of shipment IDs for manifesting.
     *
     * @var string[]
     */
    protected $shipmentNumbers;
    /**
     * 
     *
     * @return string
     */
    public function getProfile() : string
    {
        return $this->profile;
    }
    /**
     * 
     *
     * @param string $profile
     *
     * @return self
     */
    public function setProfile(string $profile) : self
    {
        $this->initialized['profile'] = true;
        $this->profile = $profile;
        return $this;
    }
    /**
     * List of shipment IDs for manifesting.
     *
     * @return string[]
     */
    public function getShipmentNumbers() : array
    {
        return $this->shipmentNumbers;
    }
    /**
     * List of shipment IDs for manifesting.
     *
     * @param string[] $shipmentNumbers
     *
     * @return self
     */
    public function setShipmentNumbers(array $shipmentNumbers) : self
    {
        $this->initialized['shipmentNumbers'] = true;
        $this->shipmentNumbers = $shipmentNumbers;
        return $this;
    }
}