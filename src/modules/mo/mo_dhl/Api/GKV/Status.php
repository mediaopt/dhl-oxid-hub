<?php

namespace Mediaopt\DHL\Api\GKV;

class Status
{

    /**
     * @var Statuscode $statuscode
     */
    protected $statuscode = null;

    /**
     * @var string $statusDescription
     */
    protected $statusDescription = null;

    /**
     * @param Statuscode $statuscode
     * @param string     $statusDescription
     */
    public function __construct($statuscode, $statusDescription)
    {
        $this->statuscode = $statuscode;
        $this->statusDescription = $statusDescription;
    }

    /**
     * @return Statuscode
     */
    public function getStatuscode()
    {
        return $this->statuscode;
    }

    /**
     * @param Statuscode $statuscode
     * @return Status
     */
    public function setStatuscode($statuscode)
    {
        $this->statuscode = $statuscode;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusDescription()
    {
        return $this->statusDescription;
    }

    /**
     * @param string $statusDescription
     * @return Status
     */
    public function setStatusDescription($statusDescription)
    {
        $this->statusDescription = $statusDescription;
        return $this;
    }

}
