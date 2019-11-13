<?php

namespace Mediaopt\DHL\Api\GKV;

class CountryType
{

    /**
     * @var string $country
     */
    protected $country = null;

    /**
     * @var string $countryISOCode
     */
    protected $countryISOCode = null;

    /**
     * @var string $state
     */
    protected $state = null;

    /**
     * @param string $countryISOCode
     */
    public function __construct($countryISOCode)
    {
        $this->countryISOCode = $countryISOCode;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return CountryType
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryISOCode()
    {
        return $this->countryISOCode;
    }

    /**
     * @param string $countryISOCode
     * @return CountryType
     */
    public function setCountryISOCode($countryISOCode)
    {
        $this->countryISOCode = $countryISOCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return CountryType
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

}
