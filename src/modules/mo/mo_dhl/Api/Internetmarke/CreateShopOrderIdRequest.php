<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class CreateShopOrderIdRequest
{

    /**
     * @var UserToken $userToken
     */
    protected $userToken = null;

    /**
     * @return UserToken
     */
    public function getUserToken()
    {
      return $this->userToken;
    }

    /**
     * @param UserToken $userToken
     * @return CreateShopOrderIdRequest
     */
    public function setUserToken($userToken)
    {
      $this->userToken = $userToken;
      return $this;
    }

}
