<?php

namespace Mediaopt\DHL\Api\GKV;

class ReceiverNativeAddressType
{

    /**
     * @var string $name2
     */
    protected $name2 = null;

    /**
     * @var string $name3
     */
    protected $name3 = null;

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
     * @param string      $name2
     * @param string      $name3
     * @param string      $streetName
     * @param string      $streetNumber
     * @param string      $zip
     * @param string      $city
     * @param string      $province
     * @param CountryType $Origin
     */
    public function __construct($name2, $name3, $streetName, $streetNumber, $zip, $city, $province, $Origin)
    {
        $this->name2 = $name2;
        $this->name3 = $name3;
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
    public function getName2()
    {
        return $this->name2;
    }

    /**
     * @param string $name2
     * @return ReceiverNativeAddressType
     */
    public function setName2($name2)
    {
        $this->name2 = $name2;
        return $this;
    }

    /**
     * @return string
     */
    public function getName3()
    {
        return $this->name3;
    }

    /**
     * @param string $name3
     * @return ReceiverNativeAddressType
     */
    public function setName3($name3)
    {
        $this->name3 = $name3;
        return $this;
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
     * @return ReceiverNativeAddressType
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
     * @return ReceiverNativeAddressType
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
     * @return ReceiverNativeAddressType
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
     * @return ReceiverNativeAddressType
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
     * @return ReceiverNativeAddressType
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
     * @return ReceiverNativeAddressType
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
     * @return ReceiverNativeAddressType
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
     * @return ReceiverNativeAddressType
     */
    public function setOrigin($Origin)
    {
        $this->Origin = $Origin;
        return $this;
    }

}
