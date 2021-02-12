<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class RetoureStateType
{

    /**
     * @var int $retoureTransactionId
     */
    protected $retoureTransactionId = null;

    /**
     * @var string $shopRetoureId
     */
    protected $shopRetoureId = null;

    /**
     * @var int $totalCount
     */
    protected $totalCount = null;

    /**
     * @var int $countStillOpen
     */
    protected $countStillOpen = null;

    /**
     * @var int $retourePrice
     */
    protected $retourePrice = null;

    /**
     * @var string $creationDate
     */
    protected $creationDate = null;

    /**
     * @var string $serialnumber
     */
    protected $serialnumber = null;

    /**
     * @var VoucherList $refundedVouchers
     */
    protected $refundedVouchers = null;

    /**
     * @var VoucherList $notRefundedVouchers
     */
    protected $notRefundedVouchers = null;

    /**
     * @param int $retoureTransactionId
     * @param string $shopRetoureId
     * @param int $totalCount
     * @param int $countStillOpen
     * @param int $retourePrice
     * @param string $creationDate
     * @param string $serialnumber
     * @param VoucherList $refundedVouchers
     * @param VoucherList $notRefundedVouchers
     */
    public function __construct($retoureTransactionId, $shopRetoureId, $totalCount, $countStillOpen, $retourePrice, $creationDate, $serialnumber, $refundedVouchers, $notRefundedVouchers)
    {
      $this->retoureTransactionId = $retoureTransactionId;
      $this->shopRetoureId = $shopRetoureId;
      $this->totalCount = $totalCount;
      $this->countStillOpen = $countStillOpen;
      $this->retourePrice = $retourePrice;
      $this->creationDate = $creationDate;
      $this->serialnumber = $serialnumber;
      $this->refundedVouchers = $refundedVouchers;
      $this->notRefundedVouchers = $notRefundedVouchers;
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
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureStateType
     */
    public function setRetoureTransactionId($retoureTransactionId)
    {
      $this->retoureTransactionId = $retoureTransactionId;
      return $this;
    }

    /**
     * @return string
     */
    public function getShopRetoureId()
    {
      return $this->shopRetoureId;
    }

    /**
     * @param string $shopRetoureId
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureStateType
     */
    public function setShopRetoureId($shopRetoureId)
    {
      $this->shopRetoureId = $shopRetoureId;
      return $this;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
      return $this->totalCount;
    }

    /**
     * @param int $totalCount
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureStateType
     */
    public function setTotalCount($totalCount)
    {
      $this->totalCount = $totalCount;
      return $this;
    }

    /**
     * @return int
     */
    public function getCountStillOpen()
    {
      return $this->countStillOpen;
    }

    /**
     * @param int $countStillOpen
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureStateType
     */
    public function setCountStillOpen($countStillOpen)
    {
      $this->countStillOpen = $countStillOpen;
      return $this;
    }

    /**
     * @return int
     */
    public function getRetourePrice()
    {
      return $this->retourePrice;
    }

    /**
     * @param int $retourePrice
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureStateType
     */
    public function setRetourePrice($retourePrice)
    {
      $this->retourePrice = $retourePrice;
      return $this;
    }

    /**
     * @return string
     */
    public function getCreationDate()
    {
      return $this->creationDate;
    }

    /**
     * @param string $creationDate
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureStateType
     */
    public function setCreationDate($creationDate)
    {
      $this->creationDate = $creationDate;
      return $this;
    }

    /**
     * @return string
     */
    public function getSerialnumber()
    {
      return $this->serialnumber;
    }

    /**
     * @param string $serialnumber
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureStateType
     */
    public function setSerialnumber($serialnumber)
    {
      $this->serialnumber = $serialnumber;
      return $this;
    }

    /**
     * @return VoucherList
     */
    public function getRefundedVouchers()
    {
      return $this->refundedVouchers;
    }

    /**
     * @param VoucherList $refundedVouchers
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureStateType
     */
    public function setRefundedVouchers($refundedVouchers)
    {
      $this->refundedVouchers = $refundedVouchers;
      return $this;
    }

    /**
     * @return VoucherList
     */
    public function getNotRefundedVouchers()
    {
      return $this->notRefundedVouchers;
    }

    /**
     * @param VoucherList $notRefundedVouchers
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureStateType
     */
    public function setNotRefundedVouchers($notRefundedVouchers)
    {
      $this->notRefundedVouchers = $notRefundedVouchers;
      return $this;
    }

}
