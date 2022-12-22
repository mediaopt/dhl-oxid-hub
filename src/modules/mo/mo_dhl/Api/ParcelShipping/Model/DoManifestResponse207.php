<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class DoManifestResponse207 extends \ArrayObject
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
     * @var DoManifestStatusResponse
     */
    protected $status;
    /**
     * 
     *
     * @var ShortResponseItem[]
     */
    protected $items;
    /**
     * 
     *
     * @return DoManifestStatusResponse
     */
    public function getStatus() : DoManifestStatusResponse
    {
        return $this->status;
    }
    /**
     * 
     *
     * @param DoManifestStatusResponse $status
     *
     * @return self
     */
    public function setStatus(DoManifestStatusResponse $status) : self
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