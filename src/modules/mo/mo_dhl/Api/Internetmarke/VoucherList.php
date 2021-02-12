<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class VoucherList
{

    /**
     * @var VoucherType[] $voucher
     */
    protected $voucher = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return VoucherType[]
     */
    public function getVoucher()
    {
      return $this->voucher;
    }

    /**
     * @param VoucherType[] $voucher
     * @return VoucherList
     */
    public function setVoucher(array $voucher = null)
    {
      $this->voucher = $voucher;
      return $this;
    }

}
