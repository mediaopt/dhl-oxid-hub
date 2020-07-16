<?php


namespace Mediaopt\DHL\Api\Retoure;


class RetoureResponse
{

    /**
     * @var string
     */
    protected $shipmentNumber;

    /**
     * @var string
     */
    protected $labelData;

    /**
     * @var string
     */
    protected $qrLabelData;

    /**
     * @var string
     */
    protected $routingCode;

    /**
     * @param \stdClass $stdClass
     */
    public function __construct(\stdClass $stdClass)
    {
        foreach ($stdClass as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    /**
     * @return string
     */
    public function getShipmentNumber() : string
    {
        return $this->shipmentNumber;
    }

    /**
     * @param string $shipmentNumber
     * @return RetoureResponse
     */
    public function setShipmentNumber(string $shipmentNumber) : RetoureResponse
    {
        $this->shipmentNumber = $shipmentNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelData() : string
    {
        return $this->labelData;
    }

    /**
     * @param string $labelData
     * @return RetoureResponse
     */
    public function setLabelData(string $labelData) : RetoureResponse
    {
        $this->labelData = $labelData;
        return $this;
    }

    /**
     * @return string
     */
    public function getQrLabelData() : string
    {
        return $this->qrLabelData;
    }

    /**
     * @param string $qrLabelData
     * @return RetoureResponse
     */
    public function setQrLabelData(string $qrLabelData) : RetoureResponse
    {
        $this->qrLabelData = $qrLabelData;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoutingCode() : string
    {
        return $this->routingCode;
    }

    /**
     * @param string $routingCode
     * @return RetoureResponse
     */
    public function setRoutingCode(string $routingCode) : RetoureResponse
    {
        $this->routingCode = $routingCode;
        return $this;
    }
}
