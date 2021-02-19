<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class AuthenticateUserResponseType
{

    /**
     * @var UserToken $userToken
     */
    protected $userToken = null;

    /**
     * @var WalletBalance $walletBalance
     */
    protected $walletBalance = null;

    /**
     * @var boolean $showTermsAndConditions
     */
    protected $showTermsAndConditions = null;

    /**
     * @var string $infoMessage
     */
    protected $infoMessage = null;

    /**
     * @param UserToken $userToken
     * @param WalletBalance $walletBalance
     * @param boolean $showTermsAndConditions
     */
    public function __construct($userToken, $walletBalance, $showTermsAndConditions)
    {
      $this->userToken = $userToken;
      $this->walletBalance = $walletBalance;
      $this->showTermsAndConditions = $showTermsAndConditions;
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
     * @return AuthenticateUserResponseType
     */
    public function setUserToken($userToken)
    {
      $this->userToken = $userToken;
      return $this;
    }

    /**
     * @return WalletBalance
     */
    public function getWalletBalance()
    {
      return $this->walletBalance;
    }

    /**
     * @param WalletBalance $walletBalance
     * @return AuthenticateUserResponseType
     */
    public function setWalletBalance($walletBalance)
    {
      $this->walletBalance = $walletBalance;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getShowTermsAndConditions()
    {
      return $this->showTermsAndConditions;
    }

    /**
     * @param boolean $showTermsAndConditions
     * @return AuthenticateUserResponseType
     */
    public function setShowTermsAndConditions($showTermsAndConditions)
    {
      $this->showTermsAndConditions = $showTermsAndConditions;
      return $this;
    }

    /**
     * @return string
     */
    public function getInfoMessage()
    {
      return $this->infoMessage;
    }

    /**
     * @param string $infoMessage
     * @return AuthenticateUserResponseType
     */
    public function setInfoMessage($infoMessage)
    {
      $this->infoMessage = $infoMessage;
      return $this;
    }

}
