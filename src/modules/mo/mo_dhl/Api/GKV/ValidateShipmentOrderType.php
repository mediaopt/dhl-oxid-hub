<?php

namespace Mediaopt\DHL\Api\GKV;

class ValidateShipmentOrderType
{

    /**
     * @var string $sequenceNumber
     */
    protected $sequenceNumber = null;

    /**
     * @var Shipment $Shipment
     */
    protected $Shipment = null;

    /**
     * @var Serviceconfiguration $PrintOnlyIfCodeable
     */
    protected $PrintOnlyIfCodeable = null;

    /**
     * @param string   $sequenceNumber
     * @param Shipment $Shipment
     */
    public function __construct(string $sequenceNumber, Shipment $Shipment)
    {
        $this->sequenceNumber = $sequenceNumber;
        $this->Shipment = $Shipment;
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
     * @return ValidateShipmentOrderType
     */
    public function setSequenceNumber($sequenceNumber)
    {
        $this->sequenceNumber = $sequenceNumber;
        return $this;
    }

    /**
     * @return Shipment
     */
    public function getShipment()
    {
        return $this->Shipment;
    }

    /**
     * @param Shipment $Shipment
     * @return ValidateShipmentOrderType
     */
    public function setShipment($Shipment)
    {
        $this->Shipment = $Shipment;
        return $this;
    }

    /**
     * @return Serviceconfiguration
     */
    public function getPrintOnlyIfCodeable()
    {
        return $this->PrintOnlyIfCodeable;
    }

    /**
     * @param Serviceconfiguration $PrintOnlyIfCodeable
     * @return ValidateShipmentOrderType
     */
    public function setPrintOnlyIfCodeable($PrintOnlyIfCodeable)
    {
        $this->PrintOnlyIfCodeable = $PrintOnlyIfCodeable;
        return $this;
    }

}
