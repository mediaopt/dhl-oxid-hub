<?php

namespace Mediaopt\DHL\Api\GKV;

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
     * @var string $statusType
     */
    protected $statusType = null;

    /**
     * @var StatusElement[] $errorMessage
     */
    protected $errorMessage = null;

    /**
     * @var StatusElement[] $warningMessage
     */
    protected $warningMessage = null;

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
     * @return Statusinformation
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
     * @return Statusinformation
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
     * @return Statusinformation
     */
    public function setStatusMessage(array $statusMessage = null)
    {
        $this->statusMessage = $statusMessage;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusType()
    {
        return $this->statusType;
    }

    /**
     * @param string $statusType
     * @return Statusinformation
     */
    public function setStatusType($statusType)
    {
        $this->statusType = $statusType;
        return $this;
    }

    /**
     * @return StatusElement[]
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param StatusElement[] $errorMessage
     * @return Statusinformation
     */
    public function setErrorMessage(array $errorMessage = null)
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    /**
     * @return StatusElement[]
     */
    public function getWarningMessage()
    {
        return $this->warningMessage;
    }

    /**
     * @param StatusElement[] $warningMessage
     * @return Statusinformation
     */
    public function setWarningMessage(array $warningMessage = null)
    {
        $this->warningMessage = $warningMessage;
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
        $errors = $this->getStatusMessage() ?: $this->getErrorMessage() ?: $this->getWarningMessage() ?: [];
        array_unshift($errors, $this->getStatusText());
        return array_unique($errors);
    }
}
