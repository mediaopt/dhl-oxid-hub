<?php


namespace Mediaopt\DHL\Api\ProdWS;

class AccountProdReferenceType
{

    /**
     * @var CountryNegativList $countryNegativList
     */
    protected $countryNegativList = null;

    /**
     * @var string $ProdWSID
     */
    protected $ProdWSID = null;

    /**
     * @var int $version
     */
    protected $version = null;

    /**
     * @param string $ProdWSID
     * @param int $version
     */
    public function __construct($ProdWSID, $version)
    {
      $this->ProdWSID = $ProdWSID;
      $this->version = $version;
    }

    /**
     * @return CountryNegativList
     */
    public function getCountryNegativList()
    {
      return $this->countryNegativList;
    }

    /**
     * @param CountryNegativList $countryNegativList
     * @return AccountProdReferenceType
     */
    public function setCountryNegativList($countryNegativList)
    {
      $this->countryNegativList = $countryNegativList;
      return $this;
    }

    /**
     * @return string
     */
    public function getProdWSID()
    {
      return $this->{'ProdWS-ID'};
    }

    /**
     * @param string $ProdWSID
     * @return AccountProdReferenceType
     */
    public function setProdWSID($ProdWSID)
    {
      $this->ProdWSID = $ProdWSID;
      return $this;
    }

    /**
     * @return int
     */
    public function getVersion()
    {
      return $this->version;
    }

    /**
     * @param int $version
     * @return AccountProdReferenceType
     */
    public function setVersion($version)
    {
      $this->version = $version;
      return $this;
    }

}
