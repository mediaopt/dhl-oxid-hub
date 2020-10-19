<?php


namespace Mediaopt\DHL\Api\ProdWS;

class AccountServiceReferenceList
{

    /**
     * @var AccountProdReferenceType $accountServiceReference
     */
    protected $accountServiceReference = null;

    /**
     * @param AccountProdReferenceType $accountServiceReference
     */
    public function __construct($accountServiceReference)
    {
      $this->accountServiceReference = $accountServiceReference;
    }

    /**
     * @return AccountProdReferenceType
     */
    public function getAccountServiceReference()
    {
      return $this->accountServiceReference;
    }

    /**
     * @param AccountProdReferenceType $accountServiceReference
     * @return AccountServiceReferenceList
     */
    public function setAccountServiceReference($accountServiceReference)
    {
      $this->accountServiceReference = $accountServiceReference;
      return $this;
    }

}
