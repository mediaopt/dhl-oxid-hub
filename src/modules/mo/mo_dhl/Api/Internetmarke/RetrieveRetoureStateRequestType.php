<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class RetrieveRetoureStateRequestType
{

    /**
     * @var UserToken $userToken
     */
    protected $userToken = null;

    /**
     * @var string $startDate
     */
    protected $startDate = null;

    /**
     * @var string $endDate
     */
    protected $endDate = null;

    /**
     * @var int $retoureTransactionId
     */
    protected $retoureTransactionId = null;

    /**
     * @var string $shopRetoureId
     */
    protected $shopRetoureId = null;

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
     * @return \Mediaopt\DHL\Api\Internetmarke\RetrieveRetoureStateRequestType
     */
    public function setUserToken($userToken)
    {
      $this->userToken = $userToken;
      return $this;
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
      return $this->startDate;
    }

    /**
     * @param string $startDate
     * @return \Mediaopt\DHL\Api\Internetmarke\RetrieveRetoureStateRequestType
     */
    public function setStartDate($startDate)
    {
      $this->startDate = $startDate;
      return $this;
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
      return $this->endDate;
    }

    /**
     * @param string $endDate
     * @return \Mediaopt\DHL\Api\Internetmarke\RetrieveRetoureStateRequestType
     */
    public function setEndDate($endDate)
    {
      $this->endDate = $endDate;
      return $this;
    }

    /**
     * @return int
     */
    public function getRetoureTransactionId()
    {
      return $this->retoureTransactionId;
    }

    /**
     * @param int $retoureTransactionId
     * @return \Mediaopt\DHL\Api\Internetmarke\RetrieveRetoureStateRequestType
     */
    public function setRetoureTransactionId($retoureTransactionId)
    {
      $this->retoureTransactionId = $retoureTransactionId;
      return $this;
    }

    /**
     * @return ShopRetourstringeId
     */
    public function getShopRetoureId()
    {
      return $this->shopRetoureId;
    }

    /**
     * @param string $shopRetoureId
     * @return \Mediaopt\DHL\Api\Internetmarke\RetrieveRetoureStateRequestType
     */
    public function setShopRetoureId($shopRetoureId)
    {
      $this->shopRetoureId = $shopRetoureId;
      return $this;
    }

}
