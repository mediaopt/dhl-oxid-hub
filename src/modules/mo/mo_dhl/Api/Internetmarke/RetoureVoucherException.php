<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class RetoureVoucherException
{

    /**
     * @var string $message
     */
    protected $message = null;

    /**
     * @var RetoureVoucherErrorInfo[] $errors
     */
    protected $errors = null;

    /**
     * @param string $message
     * @param RetoureVoucherErrorInfo[] $errors
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
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureVoucherException
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

    /**
     * @return RetoureVoucherErrorInfo[]
     */
    public function getErrors()
    {
      return $this->errors;
    }

    /**
     * @param RetoureVoucherErrorInfo[] $errors
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureVoucherException
     */
    public function setErrors(array $errors)
    {
      $this->errors = $errors;
      return $this;
    }

}
