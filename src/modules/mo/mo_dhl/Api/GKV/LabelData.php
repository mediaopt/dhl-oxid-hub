<?php

namespace Mediaopt\DHL\Api\GKV;

class LabelData
{

    /**
     * @var Statusinformation $Status
     */
    protected $Status = null;

    /**
     * @var string $shipmentNumber
     */
    protected $shipmentNumber = null;

    /**
     * @var string $labelUrl
     */
    protected $labelUrl = null;

    /**
     * @var string $labelData
     */
    protected $labelData = null;

    /**
     * @var string $returnLabelUrl
     */
    protected $returnLabelUrl = null;

    /**
     * @var string $returnLabelData
     */
    protected $returnLabelData = null;

    /**
     * @var string $exportLabelUrl
     */
    protected $exportLabelUrl = null;

    /**
     * @var string $exportLabelData
     */
    protected $exportLabelData = null;

    /**
     * @var string $codLabelUrl
     */
    protected $codLabelUrl = null;

    /**
     * @var string $codLabelData
     */
    protected $codLabelData = null;

    /**
     * @param Statusinformation $Status
     * @param string            $shipmentNumber
     */
    public function __construct($Status, $shipmentNumber)
    {
        $this->Status = $Status;
        $this->shipmentNumber = $shipmentNumber;
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
     * @return LabelData
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
     * @return LabelData
     */
    public function setShipmentNumber($shipmentNumber)
    {
        $this->shipmentNumber = $shipmentNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelUrl()
    {
        return $this->labelUrl;
    }

    /**
     * @param string $labelUrl
     * @return LabelData
     */
    public function setLabelUrl($labelUrl)
    {
        $this->labelUrl = $labelUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelData()
    {
        return $this->labelData;
    }

    /**
     * @param string $labelData
     * @return LabelData
     */
    public function setLabelData($labelData)
    {
        $this->labelData = $labelData;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnLabelUrl()
    {
        return $this->returnLabelUrl;
    }

    /**
     * @param string $returnLabelUrl
     * @return LabelData
     */
    public function setReturnLabelUrl($returnLabelUrl)
    {
        $this->returnLabelUrl = $returnLabelUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnLabelData()
    {
        return $this->returnLabelData;
    }

    /**
     * @param string $returnLabelData
     * @return LabelData
     */
    public function setReturnLabelData($returnLabelData)
    {
        $this->returnLabelData = $returnLabelData;
        return $this;
    }

    /**
     * @return string
     */
    public function getExportLabelUrl()
    {
        return $this->exportLabelUrl;
    }

    /**
     * @param string $exportLabelUrl
     * @return LabelData
     */
    public function setExportLabelUrl($exportLabelUrl)
    {
        $this->exportLabelUrl = $exportLabelUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getExportLabelData()
    {
        return $this->exportLabelData;
    }

    /**
     * @param string $exportLabelData
     * @return LabelData
     */
    public function setExportLabelData($exportLabelData)
    {
        $this->exportLabelData = $exportLabelData;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodLabelUrl()
    {
        return $this->codLabelUrl;
    }

    /**
     * @param string $codLabelUrl
     * @return LabelData
     */
    public function setCodLabelUrl($codLabelUrl)
    {
        $this->codLabelUrl = $codLabelUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodLabelData()
    {
        return $this->codLabelData;
    }

    /**
     * @param string $codLabelData
     * @return LabelData
     */
    public function setCodLabelData($codLabelData)
    {
        $this->codLabelData = $codLabelData;
        return $this;
    }

}
