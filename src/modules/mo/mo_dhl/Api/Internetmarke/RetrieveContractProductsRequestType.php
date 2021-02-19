<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class RetrieveContractProductsRequestType
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
     * @return RetrieveContractProductsRequestType
     */
    public function setUserToken($userToken)
    {
      $this->userToken = $userToken;
      return $this;
    }

}
