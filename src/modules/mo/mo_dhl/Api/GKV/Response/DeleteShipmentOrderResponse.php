<?php

namespace Mediaopt\DHL\Api\GKV\Response;

use Mediaopt\DHL\Api\GKV\DeletionState;
use Mediaopt\DHL\Api\GKV\Statusinformation;
use Mediaopt\DHL\Api\GKV\Version;

class DeleteShipmentOrderResponse
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
     * @var DeletionState $DeletionState
     */
    protected $DeletionState = null;

    /**
     * @param Version           $Version
     * @param Statusinformation $Status
     * @param DeletionState     $DeletionState
     */
    public function __construct($Version, $Status, $DeletionState)
    {
        $this->Version = $Version;
        $this->Status = $Status;
        $this->DeletionState = $DeletionState;
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
     * @return DeleteShipmentOrderResponse
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
     * @return DeleteShipmentOrderResponse
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
    }

    /**
     * @return DeletionState
     */
    public function getDeletionState()
    {
        return $this->DeletionState;
    }

    /**
     * @param DeletionState $DeletionState
     * @return DeleteShipmentOrderResponse
     */
    public function setDeletionState($DeletionState)
    {
        $this->DeletionState = $DeletionState;
        return $this;
    }

}
