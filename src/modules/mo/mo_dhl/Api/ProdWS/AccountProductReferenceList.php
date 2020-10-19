<?php


namespace Mediaopt\DHL\Api\ProdWS;

class AccountProductReferenceList
{

    /**
     * @var AccountProdReferenceType $accountProductReference
     */
    protected $accountProductReference = null;

    /**
     * @param AccountProdReferenceType $accountProductReference
     */
    public function __construct($accountProductReference)
    {
      $this->accountProductReference = $accountProductReference;
    }

    /**
     * @return AccountProdReferenceType
     */
    public function getAccountProductReference()
    {
      return $this->accountProductReference;
    }

    /**
     * @param AccountProdReferenceType $accountProductReference
     * @return AccountProductReferenceList
     */
    public function setAccountProductReference($accountProductReference)
    {
      $this->accountProductReference = $accountProductReference;
      return $this;
    }

}
