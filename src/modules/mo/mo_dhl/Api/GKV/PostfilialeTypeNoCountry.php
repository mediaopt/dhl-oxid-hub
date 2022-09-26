<?php

namespace Mediaopt\DHL\Api\GKV;

class PostfilialeTypeNoCountry
{

    /**
     * @var string $postfilialNumber
     */
    protected $postfilialNumber = null;

    /**
     * @var string $postNumber
     */
    protected $postNumber = null;

    /**
     * @var string $zip
     */
    protected $zip = null;

    /**
     * @var string $city
     */
    protected $city = null;

    /**
     * @var CountryType $Origin
     */
    protected $Origin = null;

    /**
     * @param string $postfilialNumber
     * @param string $postNumber
     * @param string $zip
     * @param string $city
     */
    public function __construct($postfilialNumber, $postNumber, $zip, $city)
    {
        $this->postfilialNumber = $postfilialNumber;
        $this->postNumber = $postNumber;
        $this->zip = $zip;
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getPostfilialNumber()
    {
        return $this->postfilialNumber;
    }

    /**
     * @param string $postfilialNumber
     * @return PostfilialeTypeNoCountry
     */
    public function setPostfilialNumber($postfilialNumber)
    {
        $this->postfilialNumber = $postfilialNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostNumber()
    {
        return $this->postNumber;
    }

    /**
     * @param string $postNumber
     * @return PostfilialeTypeNoCountry
     */
    public function setPostNumber($postNumber)
    {
        $this->postNumber = $postNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     * @return PostfilialeTypeNoCountry
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return PostfilialeTypeNoCountry
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return CountryType
     */
    public function getOrigin()
    {
        return $this->Origin;
    }

    /**
     * @param CountryType $Origin
     * @return PostfilialeTypeNoCountry
     */
    public function setOrigin($Origin)
    {
        $this->Origin = $Origin;
        return $this;
    }

}
