<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CountryNegativList
{

    /**
     * @var CountryType $country
     */
    protected $country = null;

    /**
     * @param CountryType $country
     */
    public function __construct($country)
    {
      $this->country = $country;
    }

    /**
     * @return CountryType
     */
    public function getCountry()
    {
      return $this->country;
    }

    /**
     * @param CountryType $country
     * @return CountryNegativList
     */
    public function setCountry($country)
    {
      $this->country = $country;
      return $this;
    }

}
