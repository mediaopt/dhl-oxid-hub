<?php

namespace Mediaopt\DHL\Api\GKV;

use Mediaopt\DHL\Api\GKV\Response\StatusCode;

class Statusinformation
{

    /**
     * @var int $statusCode
     */
    protected $statusCode = null;

    /**
     * @var string $statusText
     */
    protected $statusText = null;

    /**
     * @var string[] $statusMessage
     */
    protected $statusMessage = null;

    /**
     * @param int    $statusCode
     * @param string $statusText
     */
    public function __construct($statusCode, $statusText)
    {
        $this->statusCode = $statusCode;
        $this->statusText = $statusText;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return \Mediaopt\DHL\Api\GKV\Statusinformation
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusText()
    {
        return $this->statusText;
    }

    /**
     * @param string $statusText
     * @return \Mediaopt\DHL\Api\GKV\Statusinformation
     */
    public function setStatusText($statusText)
    {
        $this->statusText = $statusText;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * @param string[] $statusMessage
     * @return \Mediaopt\DHL\Api\GKV\Statusinformation
     */
    public function setStatusMessage(array $statusMessage = null)
    {
        $this->statusMessage = $statusMessage;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        if ($this->getStatusCode() === StatusCode::GKV_STATUS_OK) {
            return [];
        }
        $errors = $this->getStatusMessage();
        array_unshift($errors, $this->getStatusText());
        return array_unique($errors);
    }
}
