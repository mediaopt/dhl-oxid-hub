<?php

namespace Mediaopt\DHL\Api\GKV;

class GetManifestRequest
{

    /**
     * @var Version $Version
     */
    protected $Version = null;

    /**
     * @var string $manifestDate
     */
    protected $manifestDate = null;

    /**
     * @param Version $Version
     * @param string  $manifestDate
     */
    public function __construct($Version, $manifestDate)
    {
        $this->Version = $Version;
        $this->manifestDate = $manifestDate;
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
     * @return GetManifestRequest
     */
    public function setVersion($Version)
    {
        $this->Version = $Version;
        return $this;
    }

    /**
     * @return string
     */
    public function getManifestDate()
    {
        return $this->manifestDate;
    }

    /**
     * @param string $manifestDate
     * @return GetManifestRequest
     */
    public function setManifestDate($manifestDate)
    {
        $this->manifestDate = $manifestDate;
        return $this;
    }

}
