<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class InvalidMotiveException
{

    /**
     * @var string $message
     */
    protected $message = null;

    /**
     * @param string $message
     */
    public function __construct($message)
    {
      $this->message = $message;
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
     * @return InvalidMotiveException
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

}
