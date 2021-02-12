<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class VoucherTypeCustom
{

    /**
     * @var string $voucherId
     */
    protected $voucherId = null;

    /**
     * @var string $trackId
     */
    protected $trackId = null;

    /**
     * @param string $voucherId
     */
    public function __construct($voucherId)
    {
      $this->voucherId = $voucherId;
    }

    /**
     * @return string
     */
    public function getVoucherId()
    {
      return $this->voucherId;
    }

    /**
     * @param string $voucherId
     * @return \Mediaopt\DHL\Api\Internetmarke\VoucherType
     */
    public function setVoucherId($voucherId)
    {
      $this->voucherId = $voucherId;
      return $this;
    }

    /**
     * @return string
     */
    public function getTrackId()
    {
      return $this->trackId;
    }

    /**
     * @param string $trackId
     * @return \Mediaopt\DHL\Api\Internetmarke\VoucherType
     */
    public function setTrackId($trackId)
    {
      $this->trackId = $trackId;
      return $this;
    }

}
