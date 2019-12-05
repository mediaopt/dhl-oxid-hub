<?php

namespace Mediaopt\DHL\Api\GKV;

class NativeAddressType
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
     * @var string[] $addressAddition
     */
    protected $addressAddition = null;

    /**
     * @var string $dispatchingInformation
     */
    protected $dispatchingInformation = null;

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
     * @param string      $streetName
     * @param string      $streetNumber
     * @param string      $zip
     * @param string      $city
     * @param string      $province
     * @param CountryType $Origin
     */
    public function __construct($streetName, $streetNumber, $zip, $city, $province, $Origin)
    {
        $this->streetName = $streetName;
        $this->streetNumber = $streetNumber;
        $this->zip = $zip;
        $this->city = $city;
        $this->province = $province;
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
     * @return NativeAddressType
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
     * @return NativeAddressType
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getAddressAddition()
    {
        return $this->addressAddition;
    }

    /**
     * @param string[] $addressAddition
     * @return NativeAddressType
     */
    public function setAddressAddition(array $addressAddition = null)
    {
        $this->addressAddition = $addressAddition;
        return $this;
    }

    /**
     * @return string
     */
    public function getDispatchingInformation()
    {
        return $this->dispatchingInformation;
    }

    /**
     * @param string $dispatchingInformation
     * @return NativeAddressType
     */
    public function setDispatchingInformation($dispatchingInformation)
    {
        $this->dispatchingInformation = $dispatchingInformation;
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
     * @return NativeAddressType
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
     * @return NativeAddressType
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
     * @return NativeAddressType
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
     * @return NativeAddressType
     */
    public function setOrigin($Origin)
    {
        $this->Origin = $Origin;
        return $this;
    }

}
