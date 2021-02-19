<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class RetrieveOrderException
{

    /**
     * @var string $message
     */
    protected $message = null;

    /**
     * @var RetrieveOrderErrorCodes[] $errors
     */
    protected $errors = null;

    /**
     * @param string $message
     * @param RetrieveOrderErrorCodes[] $errors
     */
    public function __construct($message, array $errors)
    {
      $this->message = $message;
      $this->errors = $errors;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
      return $this->message;
    }

    /**
     * @param string $message
     * @return RetrieveOrderException
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

    /**
     * @return RetrieveOrderErrorCodes[]
     */
    public function getErrors()
    {
      return $this->errors;
    }

    /**
     * @param RetrieveOrderErrorCodes[] $errors
     * @return RetrieveOrderException
     */
    public function setErrors(array $errors)
    {
      $this->errors = $errors;
      return $this;
    }

}
