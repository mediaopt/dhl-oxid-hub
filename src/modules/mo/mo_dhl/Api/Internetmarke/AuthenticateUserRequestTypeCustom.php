<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class AuthenticateUserRequestTypeCustom
{

    /**
     * @var string $username
     */
    protected $username = null;

    /**
     * @var string $password
     */
    protected $password = null;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
      $this->username = $username;
      $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
      return $this->username;
    }

    /**
     * @param string $username
     * @return \Mediaopt\DHL\Api\Internetmarke\AuthenticateUserRequestType
     */
    public function setUsername($username)
    {
      $this->username = $username;
      return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
      return $this->password;
    }

    /**
     * @param string $password
     * @return \Mediaopt\DHL\Api\Internetmarke\AuthenticateUserRequestType
     */
    public function setPassword($password)
    {
      $this->password = $password;
      return $this;
    }

}
