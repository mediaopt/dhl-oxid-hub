<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class VoucherSetType
{

    /**
     * @var string[] $voucherNo
     */
    protected $voucherNo = null;

    /**
     * @param string[] $voucherNo
     */
    public function __construct(array $voucherNo)
    {
      $this->voucherNo = $voucherNo;
    }

    /**
     * @return string[]
     */
    public function getVoucherNo()
    {
      return $this->voucherNo;
    }

    /**
     * @param string[] $voucherNo
     * @return \Mediaopt\DHL\Api\Internetmarke\VoucherSetType
     */
    public function setVoucherNo(array $voucherNo)
    {
      $this->voucherNo = $voucherNo;
      return $this;
    }

}
