<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class BillingNoToSheetNo extends \ArrayObject
{
    /**
     * @var array
     */
    protected $initialized = array();
    public function isInitialized($property) : bool
    {
        return array_key_exists($property, $this->initialized);
    }
    /**
     * 
     *
     * @var string
     */
    protected $billingNumber;
    /**
     * 
     *
     * @var string
     */
    protected $sheetNo;
    /**
     * 
     *
     * @return string
     */
    public function getBillingNumber() : string
    {
        return $this->billingNumber;
    }
    /**
     * 
     *
     * @param string $billingNumber
     *
     * @return self
     */
    public function setBillingNumber(string $billingNumber) : self
    {
        $this->initialized['billingNumber'] = true;
        $this->billingNumber = $billingNumber;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getSheetNo() : string
    {
        return $this->sheetNo;
    }
    /**
     * 
     *
     * @param string $sheetNo
     *
     * @return self
     */
    public function setSheetNo(string $sheetNo) : self
    {
        $this->initialized['sheetNo'] = true;
        $this->sheetNo = $sheetNo;
        return $this;
    }
}