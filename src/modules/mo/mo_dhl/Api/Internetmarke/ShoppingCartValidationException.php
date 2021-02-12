<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class ShoppingCartValidationException
{

    /**
     * @var string $message
     */
    protected $message = null;

    /**
     * @var ShoppingCartValidationErrorInfo[] $errors
     */
    protected $errors = null;

    /**
     * @param string $message
     * @param ShoppingCartValidationErrorInfo[] $errors
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
     * @return ShoppingCartValidationException
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

    /**
     * @return ShoppingCartValidationErrorInfo[]
     */
    public function getErrors()
    {
      return $this->errors;
    }

    /**
     * @param ShoppingCartValidationErrorInfo[] $errors
     * @return ShoppingCartValidationException
     */
    public function setErrors(array $errors)
    {
      $this->errors = $errors;
      return $this;
    }

}
