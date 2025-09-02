<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class SingleManifestResponse extends \ArrayObject
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
     * General status description for the attached response or response item.
     *
     * @var RequestStatus
     */
    protected $status;
    /**
     * 
     *
     * @var string
     */
    protected $manifestDate;
    /**
     * 
     *
     * @var Document[]
     */
    protected $manifest;
    /**
     * 
     *
     * @var BillingNoToSheetNo[]
     */
    protected $sheetNo;
    /**
     * 
     *
     * @var ShipmentNoToSheetNo[]
     */
    protected $items;
    /**
     * General status description for the attached response or response item.
     *
     * @return RequestStatus
     */
    public function getStatus() : RequestStatus
    {
        return $this->status;
    }
    /**
     * General status description for the attached response or response item.
     *
     * @param RequestStatus $status
     *
     * @return self
     */
    public function setStatus(RequestStatus $status) : self
    {
        $this->initialized['status'] = true;
        $this->status = $status;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getManifestDate() : string
    {
        return $this->manifestDate;
    }
    /**
     * 
     *
     * @param string $manifestDate
     *
     * @return self
     */
    public function setManifestDate(string $manifestDate) : self
    {
        $this->initialized['manifestDate'] = true;
        $this->manifestDate = $manifestDate;
        return $this;
    }
    /**
     * 
     *
     * @return Document[]
     */
    public function getManifest() : array
    {
        return $this->manifest;
    }
    /**
     * 
     *
     * @param Document[] $manifest
     *
     * @return self
     */
    public function setManifest(array $manifest) : self
    {
        $this->initialized['manifest'] = true;
        $this->manifest = $manifest;
        return $this;
    }
    /**
     * 
     *
     * @return BillingNoToSheetNo[]
     */
    public function getSheetNo() : array
    {
        return $this->sheetNo;
    }
    /**
     * 
     *
     * @param BillingNoToSheetNo[] $sheetNo
     *
     * @return self
     */
    public function setSheetNo(array $sheetNo) : self
    {
        $this->initialized['sheetNo'] = true;
        $this->sheetNo = $sheetNo;
        return $this;
    }
    /**
     * 
     *
     * @return ShipmentNoToSheetNo[]
     */
    public function getItems() : array
    {
        return $this->items;
    }
    /**
     * 
     *
     * @param ShipmentNoToSheetNo[] $items
     *
     * @return self
     */
    public function setItems(array $items) : self
    {
        $this->initialized['items'] = true;
        $this->items = $items;
        return $this;
    }
}