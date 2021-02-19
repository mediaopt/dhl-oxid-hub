<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class VoucherType
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
     * @return VoucherType
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
     * @return VoucherType
     */
    public function setTrackId($trackId)
    {
      $this->trackId = $trackId;
      return $this;
    }

}
