<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class ShoppingCartValidationErrorInfo
{

    /**
     * @var ShoppingCartValidationErrorCodes $id
     */
    protected $id = null;

    /**
     * @var string $message
     */
    protected $message = null;

    /**
     * @param ShoppingCartValidationErrorCodes $id
     * @param string $message
     */
    public function __construct($id, $message)
    {
      $this->id = $id;
      $this->message = $message;
    }

    /**
     * @return ShoppingCartValidationErrorCodes
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param ShoppingCartValidationErrorCodes $id
     * @return ShoppingCartValidationErrorInfo
     */
    public function setId($id)
    {
      $this->id = $id;
      return $this;
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
     * @return ShoppingCartValidationErrorInfo
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

}
