<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class AuthenticateUserException
{

    /**
     * @var AuthenticateUserErrorCodes $id
     */
    protected $id = null;

    /**
     * @var string $message
     */
    protected $message = null;

    /**
     * @param AuthenticateUserErrorCodes $id
     * @param string $message
     */
    public function __construct($id, $message)
    {
      $this->id = $id;
      $this->message = $message;
    }

    /**
     * @return AuthenticateUserErrorCodes
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param AuthenticateUserErrorCodes $id
     * @return AuthenticateUserException
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
     * @return AuthenticateUserException
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

}
