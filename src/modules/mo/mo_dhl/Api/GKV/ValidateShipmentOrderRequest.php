<?php

namespace Mediaopt\DHL\Api\GKV;

class ValidateShipmentOrderRequest
{

    /**
     * @var Version $Version
     */
    protected $Version = null;

    /**
     * @var ValidateShipmentOrderType $ShipmentOrder
     */
    protected $ShipmentOrder = null;

    /**
     * @param Version                   $Version
     * @param ValidateShipmentOrderType $ShipmentOrder
     */
    public function __construct(Version $Version, ValidateShipmentOrderType $ShipmentOrder)
    {
        $this->Version = $Version;
        $this->ShipmentOrder = $ShipmentOrder;
    }

    /**
     * @return Version
     */
    public function getVersion()
    {
        return $this->Version;
    }

    /**
     * @param Version $Version
     * @return ValidateShipmentOrderRequest
     */
    public function setVersion($Version)
    {
        $this->Version = $Version;
        return $this;
    }

    /**
     * @return ValidateShipmentOrderType
     */
    public function getShipmentOrder()
    {
        return $this->ShipmentOrder;
    }

    /**
     * @param ValidateShipmentOrderType $ShipmentOrder
     * @return ValidateShipmentOrderRequest
     */
    public function setShipmentOrder($ShipmentOrder)
    {
        $this->ShipmentOrder = $ShipmentOrder;
        return $this;
    }

}
