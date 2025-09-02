<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class VASCashOnDelivery extends \ArrayObject
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
     * Currency and numeric value.
     *
     * @var Value
     */
    protected $amount;
    /**
     * Bank account data used for CoD (Cash on Delivery).
     *
     * @var BankAccount
     */
    protected $bankAccount;
    /**
     * Reference to bank account details. Account references are maintained in customer settings in Post & DHL business customer portal under Ship -> Settings -> Cash on delivery. Please note, that the default account reference is used if the provided account reference does not exist in your customer settings!
     *
     * @var string
     */
    protected $accountReference;
    /**
     * 
     *
     * @var string
     */
    protected $transferNote1;
    /**
     * 
     *
     * @var string
     */
    protected $transferNote2;
    /**
     * Currency and numeric value.
     *
     * @return Value
     */
    public function getAmount() : Value
    {
        return $this->amount;
    }
    /**
     * Currency and numeric value.
     *
     * @param Value $amount
     *
     * @return self
     */
    public function setAmount(Value $amount) : self
    {
        $this->initialized['amount'] = true;
        $this->amount = $amount;
        return $this;
    }
    /**
     * Bank account data used for CoD (Cash on Delivery).
     *
     * @return BankAccount
     */
    public function getBankAccount() : BankAccount
    {
        return $this->bankAccount;
    }
    /**
     * Bank account data used for CoD (Cash on Delivery).
     *
     * @param BankAccount $bankAccount
     *
     * @return self
     */
    public function setBankAccount(BankAccount $bankAccount) : self
    {
        $this->initialized['bankAccount'] = true;
        $this->bankAccount = $bankAccount;
        return $this;
    }
    /**
     * Reference to bank account details. Account references are maintained in customer settings in Post & DHL business customer portal under Ship -> Settings -> Cash on delivery. Please note, that the default account reference is used if the provided account reference does not exist in your customer settings!
     *
     * @return string
     */
    public function getAccountReference() : string
    {
        return $this->accountReference;
    }
    /**
     * Reference to bank account details. Account references are maintained in customer settings in Post & DHL business customer portal under Ship -> Settings -> Cash on delivery. Please note, that the default account reference is used if the provided account reference does not exist in your customer settings!
     *
     * @param string $accountReference
     *
     * @return self
     */
    public function setAccountReference(string $accountReference) : self
    {
        $this->initialized['accountReference'] = true;
        $this->accountReference = $accountReference;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getTransferNote1() : string
    {
        return $this->transferNote1;
    }
    /**
     * 
     *
     * @param string $transferNote1
     *
     * @return self
     */
    public function setTransferNote1(string $transferNote1) : self
    {
        $this->initialized['transferNote1'] = true;
        $this->transferNote1 = $transferNote1;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getTransferNote2() : string
    {
        return $this->transferNote2;
    }
    /**
     * 
     *
     * @param string $transferNote2
     *
     * @return self
     */
    public function setTransferNote2(string $transferNote2) : self
    {
        $this->initialized['transferNote2'] = true;
        $this->transferNote2 = $transferNote2;
        return $this;
    }
}