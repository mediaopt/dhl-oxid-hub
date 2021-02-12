<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CountrySpecificPropertyType
{

    /**
     * @var PropertyType $property
     */
    protected $property = null;

    /**
     * @var CountryType[] $country
     */
    protected $country = null;

    /**
     * @param PropertyType  $property
     * @param CountryType[] $country
     */
    public function __construct($property, array $country)
    {
      $this->property = $property;
      $this->country = $country;
    }

    /**
     * @return PropertyType
     */
    public function getProperty()
    {
      return $this->property;
    }

    /**
     * @param PropertyType $property
     * @return CountrySpecificPropertyType
     */
    public function setProperty($property)
    {
      $this->property = $property;
      return $this;
    }

    /**
     * @return CountryType[]
     */
    public function getCountry()
    {
      return $this->country;
    }

    /**
     * @param CountryType[] $country
     * @return CountrySpecificPropertyType
     */
    public function setCountry(array $country)
    {
      $this->country = $country;
      return $this;
    }

}
