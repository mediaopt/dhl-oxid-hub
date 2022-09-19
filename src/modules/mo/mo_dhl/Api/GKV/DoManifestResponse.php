<?php

namespace Mediaopt\DHL\Api\GKV;

class DoManifestResponse
{

    /**
     * @var Version $Version
     */
    protected $Version = null;

    /**
     * @var Statusinformation $Status
     */
    protected $Status = null;

    /**
     * @var ManifestState $ManifestState
     */
    protected $ManifestState = null;

    /**
     * @param Version           $Version
     * @param Statusinformation $Status
     * @param ManifestState     $ManifestState
     */
    public function __construct($Version, $Status, $ManifestState)
    {
        $this->Version = $Version;
        $this->Status = $Status;
        $this->ManifestState = $ManifestState;
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
     * @return DoManifestResponse
     */
    public function setVersion($Version)
    {
        $this->Version = $Version;
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
     * @return DoManifestResponse
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
    }

    /**
     * @return ManifestState
     */
    public function getManifestState()
    {
        return $this->ManifestState;
    }

    /**
     * @param ManifestState $ManifestState
     * @return DoManifestResponse
     */
    public function setManifestState($ManifestState)
    {
        $this->ManifestState = $ManifestState;
        return $this;
    }

}
