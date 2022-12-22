<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class BankAccount extends \ArrayObject
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
    protected $accountHolder;
    /**
     * 
     *
     * @var string
     */
    protected $bankName;
    /**
     * 
     *
     * @var string
     */
    protected $iban;
    /**
     * 
     *
     * @var string
     */
    protected $bic;
    /**
     * 
     *
     * @return string
     */
    public function getAccountHolder() : string
    {
        return $this->accountHolder;
    }
    /**
     * 
     *
     * @param string $accountHolder
     *
     * @return self
     */
    public function setAccountHolder(string $accountHolder) : self
    {
        $this->initialized['accountHolder'] = true;
        $this->accountHolder = $accountHolder;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getBankName() : string
    {
        return $this->bankName;
    }
    /**
     * 
     *
     * @param string $bankName
     *
     * @return self
     */
    public function setBankName(string $bankName) : self
    {
        $this->initialized['bankName'] = true;
        $this->bankName = $bankName;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getIban() : string
    {
        return $this->iban;
    }
    /**
     * 
     *
     * @param string $iban
     *
     * @return self
     */
    public function setIban(string $iban) : self
    {
        $this->initialized['iban'] = true;
        $this->iban = $iban;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getBic() : string
    {
        return $this->bic;
    }
    /**
     * 
     *
     * @param string $bic
     *
     * @return self
     */
    public function setBic(string $bic) : self
    {
        $this->initialized['bic'] = true;
        $this->bic = $bic;
        return $this;
    }
}