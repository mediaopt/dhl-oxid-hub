<?php

namespace Mediaopt\DHL\Api\GKV;

class CreateShipmentOrderResponse
{

    /**
     * @var Version $Version
     */
    protected $Version = null;

    /**
     * @var Statusinformation $Status
     */
    protected $Status = null;

    /**
     * @var CreationState[] $CreationState
     */
    protected $CreationState = null;

    /**
     * @param Version           $Version
     * @param Statusinformation $Status
     * @param CreationState[]   $CreationState
     */
    public function __construct($Version, $Status, $CreationState)
    {
        $this->Version = $Version;
        $this->Status = $Status;
        $this->CreationState = $CreationState;
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
     * @return CreateShipmentOrderResponse
     */
    public function setVersion($Version)
    {
        $this->Version = $Version;
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
     * @return CreateShipmentOrderResponse
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
    }

    /**
     * @return CreationState[]
     */
    public function getCreationState()
    {
        return $this->CreationState;
    }

    /**
     * @param CreationState[] $CreationState
     * @return CreateShipmentOrderResponse
     */
    public function setCreationState($CreationState)
    {
        $this->CreationState = $CreationState;
        return $this;
    }

}
