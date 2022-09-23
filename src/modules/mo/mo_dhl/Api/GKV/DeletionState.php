<?php

namespace Mediaopt\DHL\Api\GKV;

class DeletionState
{

    /**
     * @var string $shipmentNumber
     */
    protected $shipmentNumber = null;

    /**
     * @var Statusinformation $Status
     */
    protected $Status = null;

    /**
     * @param string            $shipmentNumber
     * @param Statusinformation $Status
     */
    public function __construct($shipmentNumber, $Status)
    {
        $this->shipmentNumber = $shipmentNumber;
        $this->Status = $Status;
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
     * @return DeletionState
     */
    public function setShipmentNumber($shipmentNumber)
    {
        $this->shipmentNumber = $shipmentNumber;
        return $this;
    }

    /**
     * @return Statusinformation
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param Statusinformation $Status
     * @return DeletionState
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
    }

}
