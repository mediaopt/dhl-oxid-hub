<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class MultipleManifestResponse extends \ArrayObject
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
     * @var ShortResponseItem[]
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
     * @return ShortResponseItem[]
     */
    public function getItems() : array
    {
        return $this->items;
    }
    /**
     * 
     *
     * @param ShortResponseItem[] $items
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