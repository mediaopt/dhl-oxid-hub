<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class RetoureVouchersResponseType
{

    /**
     * @var int $retoureTransactionId
     */
    protected $retoureTransactionId = null;

    /**
     * @param int $retoureTransactionId
     */
    public function __construct($retoureTransactionId)
    {
      $this->retoureTransactionId = $retoureTransactionId;
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
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureVouchersResponseType
     */
    public function setRetoureTransactionId($retoureTransactionId)
    {
      $this->retoureTransactionId = $retoureTransactionId;
      return $this;
    }

}
