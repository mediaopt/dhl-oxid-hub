<?php

namespace Mediaopt\DHL\Api\GKV\Response;

use Mediaopt\DHL\Api\GKV\Statusinformation;
use Mediaopt\DHL\Api\GKV\Version;

class GetManifestResponse
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
     * @var string $manifestData
     */
    protected $manifestData = null;

    /**
     * @param Version           $Version
     * @param Statusinformation $Status
     * @param string            $manifestData
     */
    public function __construct($Version, $Status, $manifestData)
    {
        $this->Version = $Version;
        $this->Status = $Status;
        $this->manifestData = $manifestData;
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
     * @return GetManifestResponse
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
     * @return GetManifestResponse
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
    }

    /**
     * @return string
     */
    public function getManifestData()
    {
        return $this->manifestData;
    }

    /**
     * @param string $manifestData
     * @return GetManifestResponse
     */
    public function setManifestData($manifestData)
    {
        $this->manifestData = $manifestData;
        return $this;
    }

}
