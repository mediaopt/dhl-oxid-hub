<?php

namespace Mediaopt\DHL\Api\GKV\Request;

use Mediaopt\DHL\Api\GKV\Version;

class GetExportDocRequest
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
     * @var string $exportDocResponseType
     */
    protected $exportDocResponseType = null;

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
     * @param Version $Version
     * @param string  $shipmentNumber
     */
    public function __construct(Version $Version, string $shipmentNumber)
    {
        $this->Version = $Version;
        $this->shipmentNumber = $shipmentNumber;
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
     * @return GetExportDocRequest
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
     * @return GetExportDocRequest
     */
    public function setShipmentNumber($shipmentNumber)
    {
        $this->shipmentNumber = $shipmentNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getExportDocResponseType()
    {
        return $this->exportDocResponseType;
    }

    /**
     * @param string $exportDocResponseType
     * @return GetExportDocRequest
     */
    public function setExportDocResponseType($exportDocResponseType)
    {
        $this->exportDocResponseType = $exportDocResponseType;
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
     * @return GetExportDocRequest
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
     * @return GetExportDocRequest
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
     * @return GetExportDocRequest
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
     * @return GetExportDocRequest
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
     * @return GetExportDocRequest
     */
    public function setFeederSystem($feederSystem)
    {
        $this->feederSystem = $feederSystem;
        return $this;
    }

}
