<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ExceptionDetailType
{

    /**
     * @var int $errorNumber
     */
    protected $errorNumber = null;

    /**
     * @var string $errorMessage
     */
    protected $errorMessage = null;

    /**
     * @var string $errorDetail
     */
    protected $errorDetail = null;

    /**
     * @param int $errorNumber
     * @param string $errorMessage
     */
    public function __construct($errorNumber, $errorMessage)
    {
      $this->errorNumber = $errorNumber;
      $this->errorMessage = $errorMessage;
    }

    /**
     * @return int
     */
    public function getErrorNumber()
    {
      return $this->errorNumber;
    }

    /**
     * @param int $errorNumber
     * @return ExceptionDetailType
     */
    public function setErrorNumber($errorNumber)
    {
      $this->errorNumber = $errorNumber;
      return $this;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
      return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     * @return ExceptionDetailType
     */
    public function setErrorMessage($errorMessage)
    {
      $this->errorMessage = $errorMessage;
      return $this;
    }

    /**
     * @return string
     */
    public function getErrorDetail()
    {
      return $this->errorDetail;
    }

    /**
     * @param string $errorDetail
     * @return ExceptionDetailType
     */
    public function setErrorDetail($errorDetail)
    {
      $this->errorDetail = $errorDetail;
      return $this;
    }

}
