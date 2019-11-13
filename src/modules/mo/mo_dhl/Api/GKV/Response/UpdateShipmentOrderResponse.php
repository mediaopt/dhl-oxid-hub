<?php

namespace Mediaopt\DHL\Api\GKV\Response;

use Mediaopt\DHL\Api\GKV\LabelData;
use Mediaopt\DHL\Api\GKV\Statusinformation;
use Mediaopt\DHL\Api\GKV\Version;

class UpdateShipmentOrderResponse
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
     * @var LabelData[] $LabelData
     */
    protected $LabelData = null;

    /**
     * @param Version           $Version
     * @param Statusinformation $Status
     * @param LabelData[]       $LabelData
     */
    public function __construct($Version, $Status, $LabelData)
    {
        $this->Version = $Version;
        $this->Status = $Status;
        $this->LabelData = $LabelData;
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
     * @return UpdateShipmentOrderResponse
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
     * @return UpdateShipmentOrderResponse
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
    }

    /**
     * @return LabelData[]
     */
    public function getLabelData()
    {
        return $this->LabelData;
    }

    /**
     * @param LabelData[] $LabelData
     * @return UpdateShipmentOrderResponse
     */
    public function setLabelData($LabelData)
    {
        $this->LabelData = $LabelData;
        return $this;
    }

}
