<?php

namespace Mediaopt\DHL\Api\GKV;

class CreationState
{

    /**
     * @var string $sequenceNumber
     */
    protected $sequenceNumber = null;

    /**
     * @var string $shipmentNumber
     */
    protected $shipmentNumber = null;

    /**
     * @var string $returnShipmentNumber
     */
    protected $returnShipmentNumber = null;

    /**
     * @var LabelData $LabelData
     */
    protected $LabelData = null;

    /**
     * @param string    $sequenceNumber
     * @param LabelData $LabelData
     */
    public function __construct($sequenceNumber, $LabelData)
    {
        $this->sequenceNumber = $sequenceNumber;
        $this->LabelData = $LabelData;
    }

    /**
     * @return string
     */
    public function getSequenceNumber()
    {
        return $this->sequenceNumber;
    }

    /**
     * @param string $sequenceNumber
     * @return CreationState
     */
    public function setSequenceNumber($sequenceNumber)
    {
        $this->sequenceNumber = $sequenceNumber;
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
     * @return CreationState
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
     * @return CreationState
     */
    public function setReturnShipmentNumber($returnShipmentNumber)
    {
        $this->returnShipmentNumber = $returnShipmentNumber;
        return $this;
    }

    /**
     * @return LabelData
     */
    public function getLabelData()
    {
        return $this->LabelData;
    }

    /**
     * @param LabelData $LabelData
     * @return CreationState
     */
    public function setLabelData($LabelData)
    {
        $this->LabelData = $LabelData;
        return $this;
    }

}
