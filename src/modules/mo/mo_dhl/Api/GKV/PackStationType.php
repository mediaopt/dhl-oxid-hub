<?php

namespace Mediaopt\DHL\Api\GKV;

class PackStationType
{

    use AssignTrait;

    /**
     * @var string $postNumber
     */
    protected $postNumber = null;

    /**
     * @var string $packstationNumber
     */
    protected $packstationNumber = null;

    /**
     * @var string $zip
     */
    protected $zip = null;

    /**
     * @var string $city
     */
    protected $city = null;

    /**
     * @var string $province
     */
    protected $province = null;

    /**
     * @var CountryType $Origin
     */
    protected $Origin = null;

    /**
     * @param string      $postNumber
     * @param string      $packstationNumber
     * @param string      $zip
     * @param string      $city
     * @param string      $province
     * @param CountryType $Origin
     */
    public function __construct($postNumber, $packstationNumber, $zip, $city, $province = null, $Origin = null)
    {
        $this->postNumber = $postNumber;
        $this->packstationNumber = $packstationNumber;
        $this->zip = $zip;
        $this->city = $city;
        $this->province = $province;
        $this->Origin = $Origin;
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
     * @return PackStationType
     */
    public function setPostNumber($postNumber)
    {
        $this->postNumber = $postNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPackstationNumber()
    {
        return $this->packstationNumber;
    }

    /**
     * @param string $packstationNumber
     * @return PackStationType
     */
    public function setPackstationNumber($packstationNumber)
    {
        $this->packstationNumber = $packstationNumber;
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
     * @return PackStationType
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
     * @return PackStationType
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     * @return PackStationType
     */
    public function setProvince($province)
    {
        $this->province = $province;
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
     * @return PackStationType
     */
    public function setOrigin($Origin)
    {
        $this->Origin = $Origin;
        return $this;
    }

}
