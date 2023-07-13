<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class ShipmentOrderRequest extends \ArrayObject
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
     * Shipment array having details for each shipment.
     *
     * @var Shipment[]
     */
    protected $shipments;
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
     * Shipment array having details for each shipment.
     *
     * @return Shipment[]
     */
    public function getShipments() : array
    {
        return $this->shipments;
    }
    /**
     * Shipment array having details for each shipment.
     *
     * @param Shipment[] $shipments
     *
     * @return self
     */
    public function setShipments(array $shipments) : self
    {
        $this->initialized['shipments'] = true;
        $this->shipments = $shipments;
        return $this;
    }
}