<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class CreateRetoureIdException
{

    /**
     * @var string $message
     */
    protected $message = null;

    /**
     * @var CreateRetoureIdErrorCodes[] $errors
     */
    protected $errors = null;

    /**
     * @param string $message
     * @param CreateRetoureIdErrorCodes[] $errors
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
     * @return \Mediaopt\DHL\Api\Internetmarke\CreateRetoureIdException
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

    /**
     * @return CreateRetoureIdErrorCodes[]
     */
    public function getErrors()
    {
      return $this->errors;
    }

    /**
     * @param CreateRetoureIdErrorCodes[] $errors
     * @return \Mediaopt\DHL\Api\Internetmarke\CreateRetoureIdException
     */
    public function setErrors(array $errors)
    {
      $this->errors = $errors;
      return $this;
    }

}
