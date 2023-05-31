<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class ShortResponseItem extends \ArrayObject
{
    /**
     * @var array
     */
    protected $initialized = array();
    public function isInitialized($property) : bool
    {
        return array_key_exists($property, $this->initialized);
    }
    /**
     * 
     *
     * @var string
     */
    protected $shipmentNo;
    /**
     * General status description for the attached response or response item.
     *
     * @var RequestStatus
     */
    protected $sstatus;
    /**
     * 
     *
     * @return string
     */
    public function getShipmentNo() : string
    {
        return $this->shipmentNo;
    }
    /**
     * 
     *
     * @param string $shipmentNo
     *
     * @return self
     */
    public function setShipmentNo(string $shipmentNo) : self
    {
        $this->initialized['shipmentNo'] = true;
        $this->shipmentNo = $shipmentNo;
        return $this;
    }
    /**
     * General status description for the attached response or response item.
     *
     * @return RequestStatus
     */
    public function getSstatus() : RequestStatus
    {
        return $this->sstatus;
    }
    /**
     * General status description for the attached response or response item.
     *
     * @param RequestStatus $sstatus
     *
     * @return self
     */
    public function setSstatus(RequestStatus $sstatus) : self
    {
        $this->initialized['sstatus'] = true;
        $this->sstatus = $sstatus;
        return $this;
    }
}