<?php

namespace Mediaopt\DHL\Api\GKV;

class ShipmentNumberType
{

    /**
     * @var string $shipmentNumber
     */
    protected $shipmentNumber = null;

    /**
     * @param string $shipmentNumber
     */
    public function __construct($shipmentNumber)
    {
        $this->shipmentNumber = $shipmentNumber;
    }

    /**
     * @return string
     */
    public function getShipmentNumber()
    {
        return $this->shipmentNumber;
    }

    /**
     * @param string $shipmentNumber
     * @return ShipmentNumberType
     */
    public function setShipmentNumber($shipmentNumber)
    {
        $this->shipmentNumber = $shipmentNumber;
        return $this;
    }

}
