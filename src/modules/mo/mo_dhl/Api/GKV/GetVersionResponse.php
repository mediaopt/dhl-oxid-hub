<?php

namespace Mediaopt\DHL\Api\GKV;

class GetVersionResponse
{

    /**
     * @var Version $Version
     */
    protected $Version = null;

    /**
     * @param Version $Version
     */
    public function __construct($Version)
    {
        $this->Version = $Version;
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
     * @return GetVersionResponse
     */
    public function setVersion($Version)
    {
        $this->Version = $Version;
        return $this;
    }

}
