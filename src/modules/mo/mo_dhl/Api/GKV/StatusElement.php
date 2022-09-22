<?php

namespace Mediaopt\DHL\Api\GKV;

class StatusElement
{

    /**
     * @var string $statusElement
     */
    protected $statusElement = null;

    /**
     * @var string $statusMessage
     */
    protected $statusMessage = null;

    /**
     * @param string $statusElement
     * @param string $statusMessage
     */
    public function __construct($statusElement, $statusMessage)
    {
        $this->statusElement = $statusElement;
        $this->statusMessage = $statusMessage;
    }

    /**
     * @return string
     */
    public function getStatusElement()
    {
        return $this->statusElement;
    }

    /**
     * @param string $statusElement
     * @return StatusElement
     */
    public function setStatusElement($statusElement)
    {
        $this->statusElement = $statusElement;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * @param string $statusMessage
     * @return StatusElement
     */
    public function setStatusMessage($statusMessage)
    {
        $this->statusMessage = $statusMessage;
        return $this;
    }

}
