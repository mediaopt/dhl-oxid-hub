<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class VASDhlRetoure extends \ArrayObject
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
    protected $refNo;
    /**
     * Combines name, address, contact information. The recommended way is to use the mandatory attribute addressStreet and submit the streetname and housenumber together â€“ alternatively addressHouse + addressStreet can be used. For many international addresses there is no house number, please do not set a period or any other sign to indicate that the address does not have a housenumber.
     *
     * @var ContactAddress
     */
    protected $returnAddress;
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
    public function getRefNo() : string
    {
        return $this->refNo;
    }
    /**
     * 
     *
     * @param string $refNo
     *
     * @return self
     */
    public function setRefNo(string $refNo) : self
    {
        $this->initialized['refNo'] = true;
        $this->refNo = $refNo;
        return $this;
    }
    /**
     * Combines name, address, contact information. The recommended way is to use the mandatory attribute addressStreet and submit the streetname and housenumber together â€“ alternatively addressHouse + addressStreet can be used. For many international addresses there is no house number, please do not set a period or any other sign to indicate that the address does not have a housenumber.
     *
     * @return ContactAddress
     */
    public function getReturnAddress() : ContactAddress
    {
        return $this->returnAddress;
    }
    /**
     * Combines name, address, contact information. The recommended way is to use the mandatory attribute addressStreet and submit the streetname and housenumber together â€“ alternatively addressHouse + addressStreet can be used. For many international addresses there is no house number, please do not set a period or any other sign to indicate that the address does not have a housenumber.
     *
     * @param ContactAddress $returnAddress
     *
     * @return self
     */
    public function setReturnAddress(ContactAddress $returnAddress) : self
    {
        $this->initialized['returnAddress'] = true;
        $this->returnAddress = $returnAddress;
        return $this;
    }
}