<?php

namespace Mediaopt\DHL\Api\GKV;

class ExportDocData
{

    /**
     * @var string $shipmentNumber
     */
    protected $shipmentNumber = null;

    /**
     * @var Statusinformation $Status
     */
    protected $Status = null;

    /**
     * @var string $exportDocData
     */
    protected $exportDocData = null;

    /**
     * @var string $exportDocURL
     */
    protected $exportDocURL = null;

    /**
     * @param string            $shipmentNumber
     * @param Statusinformation $Status
     */
    public function __construct($shipmentNumber, $Status)
    {
        $this->shipmentNumber = $shipmentNumber;
        $this->Status = $Status;
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
     * @return \Mediaopt\DHL\Api\GKV\ExportDocData
     */
    public function setShipmentNumber($shipmentNumber)
    {
        $this->shipmentNumber = $shipmentNumber;
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
     * @return \Mediaopt\DHL\Api\GKV\ExportDocData
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
    }

    /**
     * @return string
     */
    public function getExportDocData()
    {
        return $this->exportDocData;
    }

    /**
     * @param string $exportDocData
     * @return \Mediaopt\DHL\Api\GKV\ExportDocData
     */
    public function setExportDocData($exportDocData)
    {
        $this->exportDocData = $exportDocData;
        return $this;
    }

    /**
     * @return string
     */
    public function getExportDocURL()
    {
        return $this->exportDocURL;
    }

    /**
     * @param string $exportDocURL
     * @return \Mediaopt\DHL\Api\GKV\ExportDocData
     */
    public function setExportDocURL($exportDocURL)
    {
        $this->exportDocURL = $exportDocURL;
        return $this;
    }

}
