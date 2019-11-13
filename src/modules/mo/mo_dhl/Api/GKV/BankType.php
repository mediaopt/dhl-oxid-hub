<?php

namespace Mediaopt\DHL\Api\GKV;

class BankType
{

    /**
     * @var string $accountOwner
     */
    protected $accountOwner = null;

    /**
     * @var string $bankName
     */
    protected $bankName = null;

    /**
     * @var string $iban
     */
    protected $iban = null;

    /**
     * @var string $note1
     */
    protected $note1 = null;

    /**
     * @var string $note2
     */
    protected $note2 = null;

    /**
     * @var string $bic
     */
    protected $bic = null;

    /**
     * @var string $accountreference
     */
    protected $accountreference = null;

    /**
     * @param string $accountOwner
     * @param string $bankName
     * @param string $iban
     */
    public function __construct($accountOwner, $bankName, $iban)
    {
        $this->accountOwner = $accountOwner;
        $this->bankName = $bankName;
        $this->iban = $iban;
    }

    /**
     * @return string
     */
    public function getAccountOwner()
    {
        return $this->accountOwner;
    }

    /**
     * @param string $accountOwner
     * @return BankType
     */
    public function setAccountOwner($accountOwner)
    {
        $this->accountOwner = $accountOwner;
        return $this;
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * @param string $bankName
     * @return BankType
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;
        return $this;
    }

    /**
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @param string $iban
     * @return BankType
     */
    public function setIban($iban)
    {
        $this->iban = $iban;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote1()
    {
        return $this->note1;
    }

    /**
     * @param string $note1
     * @return BankType
     */
    public function setNote1($note1)
    {
        $this->note1 = $note1;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote2()
    {
        return $this->note2;
    }

    /**
     * @param string $note2
     * @return BankType
     */
    public function setNote2($note2)
    {
        $this->note2 = $note2;
        return $this;
    }

    /**
     * @return string
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * @param string $bic
     * @return BankType
     */
    public function setBic($bic)
    {
        $this->bic = $bic;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccountreference()
    {
        return $this->accountreference;
    }

    /**
     * @param string $accountreference
     * @return BankType
     */
    public function setAccountreference($accountreference)
    {
        $this->accountreference = $accountreference;
        return $this;
    }

}
