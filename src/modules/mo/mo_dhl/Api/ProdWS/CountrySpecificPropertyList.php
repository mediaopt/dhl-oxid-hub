<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CountrySpecificPropertyList
{

    /**
     * @var CountrySpecificPropertyType $countrySpecificProperty
     */
    protected $countrySpecificProperty = null;

    /**
     * @param CountrySpecificPropertyType $countrySpecificProperty
     */
    public function __construct($countrySpecificProperty)
    {
      $this->countrySpecificProperty = $countrySpecificProperty;
    }

    /**
     * @return CountrySpecificPropertyType
     */
    public function getCountrySpecificProperty()
    {
      return $this->countrySpecificProperty;
    }

    /**
     * @param CountrySpecificPropertyType $countrySpecificProperty
     * @return CountrySpecificPropertyList
     */
    public function setCountrySpecificProperty($countrySpecificProperty)
    {
      $this->countrySpecificProperty = $countrySpecificProperty;
      return $this;
    }

}
