<?php

namespace Mediaopt\DHL\Api\GKV;

class ValidationState
{

    /**
     * @var string $sequenceNumber
     */
    protected $sequenceNumber = null;

    /**
     * @var Statusinformation $Status
     */
    protected $Status = null;

    /**
     * @param string            $sequenceNumber
     * @param Statusinformation $Status
     */
    public function __construct($sequenceNumber, $Status)
    {
        $this->sequenceNumber = $sequenceNumber;
        $this->Status = $Status;
    }

    /**
     * @return string
     */
    public function getSequenceNumber()
    {
        return $this->sequenceNumber;
    }

    /**
     * @param string $sequenceNumber
     * @return ValidationState
     */
    public function setSequenceNumber($sequenceNumber)
    {
        $this->sequenceNumber = $sequenceNumber;
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
     * @return ValidationState
     */
    public function setStatus($Status)
    {
        $this->Status = $Status;
        return $this;
    }

}
