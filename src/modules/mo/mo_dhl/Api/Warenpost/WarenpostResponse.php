<?php

namespace Mediaopt\DHL\Api\Warenpost;

class WarenpostResponse
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
     * WarenpostResponse constructor.
     * @param string $shipmentNumber
     * @param string $labelData
     */
    public function __construct(string $shipmentNumber, string $labelData)
    {
        $this->shipmentNumber = $shipmentNumber;
        $this->labelData = $labelData;
    }

    /**
     * @return string
     */
    public function getShipmentNumber(): string
    {
        return $this->shipmentNumber;
    }

    /**
     * @return string
     */
    public function getLabelData(): string
    {
        return $this->labelData;
    }
}