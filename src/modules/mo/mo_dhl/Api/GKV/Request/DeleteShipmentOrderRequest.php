<?php

namespace Mediaopt\DHL\Api\GKV\Request;

use Mediaopt\DHL\Api\GKV\Version;

class DeleteShipmentOrderRequest
{

    /**
     * @var Version $Version
     */
    protected $Version = null;

    /**
     * @var string $shipmentNumber
     */
    protected $shipmentNumber = null;

    /**
     * @param Version $Version
     * @param string  $shipmentNumber
     */
    public function __construct(Version $Version, string $shipmentNumber)
    {
        $this->Version = $Version;
        $this->shipmentNumber = $shipmentNumber;
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
     * @return DeleteShipmentOrderRequest
     */
    public function setVersion($Version)
    {
        $this->Version = $Version;
        return $this;
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
     * @return DeleteShipmentOrderRequest
     */
    public function setShipmentNumber($shipmentNumber)
    {
        $this->shipmentNumber = $shipmentNumber;
        return $this;
    }

}
