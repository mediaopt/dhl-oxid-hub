<?php

namespace Mediaopt\DHL\Api\GKV;

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
     * @var string $combinedPrinting
     */
    protected $combinedPrinting = null;

    /**
     * @param Version $Version
     * @param string  $shipmentNumber
     * @param string  $exportDocResponseType
     * @param string  $groupProfileName
     * @param string  $combinedPrinting
     */
    public function __construct($Version, $shipmentNumber, $exportDocResponseType, $groupProfileName, $combinedPrinting)
    {
        $this->Version = $Version;
        $this->shipmentNumber = $shipmentNumber;
        $this->exportDocResponseType = $exportDocResponseType;
        $this->groupProfileName = $groupProfileName;
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

}
