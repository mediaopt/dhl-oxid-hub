<?php

namespace Mediaopt\DHL\Api\GKV;

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
     * @var string $shipmentNumber
     */
    protected $shipmentNumber = null;

    /**
     * @var string $returnShipmentNumber
     */
    protected $returnShipmentNumber = null;

    /**
     * @var LabelData[] $LabelData
     */
    protected $LabelData = null;

    /**
     * @param Version           $Version
     * @param Statusinformation $Status
     * @param string            $shipmentNumber
     * @param string            $returnShipmentNumber
     * @param LabelData[]       $LabelData
     */
    public function __construct($Version, $Status, $shipmentNumber, $returnShipmentNumber, $LabelData)
    {
        $this->Version = $Version;
        $this->Status = $Status;
        $this->shipmentNumber = $shipmentNumber;
        $this->returnShipmentNumber = $returnShipmentNumber;
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
     * @return string
     */
    public function getShipmentNumber()
    {
        return $this->shipmentNumber;
    }

    /**
     * @param string $shipmentNumber
     * @return UpdateShipmentOrderResponse
     */
    public function setShipmentNumber($shipmentNumber)
    {
        $this->shipmentNumber = $shipmentNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnShipmentNumber()
    {
        return $this->returnShipmentNumber;
    }

    /**
     * @param string $returnShipmentNumber
     * @return UpdateShipmentOrderResponse
     */
    public function setReturnShipmentNumber($returnShipmentNumber)
    {
        $this->returnShipmentNumber = $returnShipmentNumber;
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
