<?php

namespace Mediaopt\DHL\Api\GKV;

class GetLabelRequest
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
     * @param Version $Version
     * @param string  $shipmentNumber
     * @param string  $labelResponseType
     * @param string  $groupProfileName
     * @param string  $labelFormat
     * @param string  $labelFormatRetoure
     * @param string  $combinedPrinting
     */
    public function __construct($Version, $shipmentNumber, $labelResponseType, $groupProfileName, $labelFormat, $labelFormatRetoure, $combinedPrinting)
    {
        $this->Version = $Version;
        $this->shipmentNumber = $shipmentNumber;
        $this->labelResponseType = $labelResponseType;
        $this->groupProfileName = $groupProfileName;
        $this->labelFormat = $labelFormat;
        $this->labelFormatRetoure = $labelFormatRetoure;
        $this->combinedPrinting = $combinedPrinting;
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
     * @return GetLabelRequest
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
     * @return GetLabelRequest
     */
    public function setShipmentNumber($shipmentNumber)
    {
        $this->shipmentNumber = $shipmentNumber;
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
     * @return GetLabelRequest
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
     * @return GetLabelRequest
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
     * @return GetLabelRequest
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
     * @return GetLabelRequest
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
     * @return GetLabelRequest
     */
    public function setCombinedPrinting($combinedPrinting)
    {
        $this->combinedPrinting = $combinedPrinting;
        return $this;
    }

}
