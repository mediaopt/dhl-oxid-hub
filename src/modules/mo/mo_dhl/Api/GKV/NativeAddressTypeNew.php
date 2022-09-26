<?php

namespace Mediaopt\DHL\Api\GKV;

class NativeAddressTypeNew
{

    use AssignTrait;

    /**
     * @var string $streetName
     */
    protected $streetName = null;

    /**
     * @var string $streetNumber
     */
    protected $streetNumber = null;

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
     * @param string|null      $streetName
     * @param string|null      $streetNumber
     * @param string|null      $zip
     * @param string|null      $city
     * @param CountryType|null $Origin
     */
    public function __construct(?string $streetName, ?string $streetNumber, ?string $zip, ?string $city, ?CountryType $Origin)
    {
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
        $this->zip = $zip;
        $this->city = $city;
        $this->Origin = $Origin;
    }


    /**
     * @return string
     */
    public function getStreetName()
    {
        return $this->streetName;
    }

    /**
     * @param string $streetName
     * @return NativeAddressTypeNew
     */
    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * @param string $streetNumber
     * @return NativeAddressTypeNew
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
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
     * @return NativeAddressTypeNew
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
     * @return NativeAddressTypeNew
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
     * @return NativeAddressTypeNew
     */
    public function setOrigin($Origin)
    {
        $this->Origin = $Origin;
        return $this;
    }

}
