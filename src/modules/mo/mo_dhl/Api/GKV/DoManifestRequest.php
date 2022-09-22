<?php

namespace Mediaopt\DHL\Api\GKV;

class DoManifestRequest
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
     * @var mixed $allShipments
     */
    protected $allShipments = null;

    /**
     * @param Version $Version
     * @param string  $shipmentNumber
     * @param mixed   $allShipments
     */
    public function __construct($Version, $shipmentNumber, $allShipments)
    {
        $this->Version = $Version;
        $this->shipmentNumber = $shipmentNumber;
        $this->allShipments = $allShipments;
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
     * @return DoManifestRequest
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
     * @return DoManifestRequest
     */
    public function setShipmentNumber($shipmentNumber)
    {
        $this->shipmentNumber = $shipmentNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAllShipments()
    {
        return $this->allShipments;
    }

    /**
     * @param mixed $allShipments
     * @return DoManifestRequest
     */
    public function setAllShipments($allShipments)
    {
        $this->allShipments = $allShipments;
        return $this;
    }

}
