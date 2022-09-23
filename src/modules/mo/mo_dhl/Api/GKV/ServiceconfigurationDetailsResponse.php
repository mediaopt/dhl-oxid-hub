<?php

namespace Mediaopt\DHL\Api\GKV;

class ServiceconfigurationDetailsResponse
{

    /**
     * @var string $details
     */
    protected $details = null;

    /**
     * @param string $details
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param string $details
     * @return ServiceconfigurationDetailsResponse
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }

}
