<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class AuthenticateUserResponseTypeCustom
{

    /**
     * @var UserToken $userToken
     */
    protected $userToken = null;

    /**
     * @param UserToken $userToken
     */
    public function __construct($userToken)
    {
      $this->userToken = $userToken;
    }

    /**
     * @return UserToken
     */
    public function getUserToken()
    {
      return $this->userToken;
    }

    /**
     * @param UserToken $userToken
     * @return \Mediaopt\DHL\Api\Internetmarke\AuthenticateUserResponseType
     */
    public function setUserToken($userToken)
    {
      $this->userToken = $userToken;
      return $this;
    }

}
