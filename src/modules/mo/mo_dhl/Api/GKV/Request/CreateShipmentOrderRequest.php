<?php

namespace Mediaopt\DHL\Api\GKV\Request;

use Mediaopt\DHL\Api\GKV\ShipmentOrderType;
use Mediaopt\DHL\Api\GKV\Version;

class CreateShipmentOrderRequest
{

    /**
     * @var Version $Version
     */
    protected $Version = null;

    /**
     * @var ShipmentOrderType $ShipmentOrder
     */
    protected $ShipmentOrder = null;

    /**
     * @var string $labelResponseType
     */
    protected $labelResponseType = null;

    /**
     * @var string $groupProfileName
     */
    protected $groupProfileName = null;

    /**
     * @var string $labelFormat
     */
    protected $labelFormat = null;

    /**
     * @var string $labelFormatRetoure
     */
    protected $labelFormatRetoure = null;

    /**
     * @var string $combinedPrinting
     */
    protected $combinedPrinting = null;

    /**
     * @var string $feederSystem
     */
    protected $feederSystem = null;

    /**
     * @param Version           $Version
     * @param ShipmentOrderType $ShipmentOrder
     */
    public function __construct(Version $Version, ShipmentOrderType $ShipmentOrder)
    {
        $this->Version = $Version;
        $this->ShipmentOrder = $ShipmentOrder;
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
     * @return CreateShipmentOrderRequest
     */
    public function setVersion($Version)
    {
        $this->Version = $Version;
        return $this;
    }

    /**
     * @return ShipmentOrderType
     */
    public function getShipmentOrder()
    {
        return $this->ShipmentOrder;
    }

    /**
     * @param ShipmentOrderType $ShipmentOrder
     * @return CreateShipmentOrderRequest
     */
    public function setShipmentOrder($ShipmentOrder)
    {
        $this->ShipmentOrder = $ShipmentOrder;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelResponseType()
    {
        return $this->labelResponseType;
    }

    /**
     * @param string $labelResponseType
     * @return CreateShipmentOrderRequest
     */
    public function setLabelResponseType($labelResponseType)
    {
        $this->labelResponseType = $labelResponseType;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupProfileName()
    {
        return $this->groupProfileName;
    }

    /**
     * @param string $groupProfileName
     * @return CreateShipmentOrderRequest
     */
    public function setGroupProfileName($groupProfileName)
    {
        $this->groupProfileName = $groupProfileName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelFormat()
    {
        return $this->labelFormat;
    }

    /**
     * @param string $labelFormat
     * @return CreateShipmentOrderRequest
     */
    public function setLabelFormat($labelFormat)
    {
        $this->labelFormat = $labelFormat;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelFormatRetoure()
    {
        return $this->labelFormatRetoure;
    }

    /**
     * @param string $labelFormatRetoure
     * @return CreateShipmentOrderRequest
     */
    public function setLabelFormatRetoure($labelFormatRetoure)
    {
        $this->labelFormatRetoure = $labelFormatRetoure;
        return $this;
    }

    /**
     * @return string
     */
    public function getCombinedPrinting()
    {
        return $this->combinedPrinting;
    }

    /**
     * @param string $combinedPrinting
     * @return CreateShipmentOrderRequest
     */
    public function setCombinedPrinting($combinedPrinting)
    {
        $this->combinedPrinting = $combinedPrinting;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeederSystem()
    {
        return $this->feederSystem;
    }

    /**
     * @param string $feederSystem
     * @return CreateShipmentOrderRequest
     */
    public function setFeederSystem($feederSystem)
    {
        $this->feederSystem = $feederSystem;
        return $this;
    }

}
