<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class GetManifestResponse200 extends \ArrayObject
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
     * General status description for the GET /manifests endpoint.
     *
     * @var GetManifestStatus
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
     * @var GetManifestData
     */
    protected $manifest;
    /**
     * General status description for the GET /manifests endpoint.
     *
     * @return GetManifestStatus
     */
    public function getStatus() : GetManifestStatus
    {
        return $this->status;
    }
    /**
     * General status description for the GET /manifests endpoint.
     *
     * @param GetManifestStatus $status
     *
     * @return self
     */
    public function setStatus(GetManifestStatus $status) : self
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
     * @return GetManifestData
     */
    public function getManifest() : GetManifestData
    {
        return $this->manifest;
    }
    /**
     * 
     *
     * @param GetManifestData $manifest
     *
     * @return self
     */
    public function setManifest(GetManifestData $manifest) : self
    {
        $this->initialized['manifest'] = true;
        $this->manifest = $manifest;
        return $this;
    }
}