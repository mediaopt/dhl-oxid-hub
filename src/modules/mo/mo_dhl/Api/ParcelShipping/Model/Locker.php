<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class Locker extends \ArrayObject
{
    /**
     * @var array
     */
    protected $initialized = array();
    public function isInitialized($property) : bool
    {
        return array_key_exists($property, $this->initialized);
    }
    /**
     * Name
     *
     * @var string
     */
    protected $name;
    /**
     * Packstationnummer. Three digit number identifying the parcel locker in conjunction with city and postal code
     *
     * @var int
     */
    protected $lockerID;
    /**
     * postNumber (Postnummer) is the official account number a private DHL Customer gets upon registration.
     *
     * @var string
     */
    protected $postNumber;
    /**
     * City where the locker is located
     *
     * @var string
     */
    protected $city;
    /**
     * A valid country code consisting of three characters according to ISO 3166-1 alpha-3.
     *
     * @var string
     */
    protected $country;
    /**
     * 
     *
     * @var string
     */
    protected $postalCode;
    /**
     * Name
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * Name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name) : self
    {
        $this->initialized['name'] = true;
        $this->name = $name;
        return $this;
    }
    /**
     * Packstationnummer. Three digit number identifying the parcel locker in conjunction with city and postal code
     *
     * @return int
     */
    public function getLockerID() : int
    {
        return $this->lockerID;
    }
    /**
     * Packstationnummer. Three digit number identifying the parcel locker in conjunction with city and postal code
     *
     * @param int $lockerID
     *
     * @return self
     */
    public function setLockerID(int $lockerID) : self
    {
        $this->initialized['lockerID'] = true;
        $this->lockerID = $lockerID;
        return $this;
    }
    /**
     * postNumber (Postnummer) is the official account number a private DHL Customer gets upon registration.
     *
     * @return string
     */
    public function getPostNumber() : string
    {
        return $this->postNumber;
    }
    /**
     * postNumber (Postnummer) is the official account number a private DHL Customer gets upon registration.
     *
     * @param string $postNumber
     *
     * @return self
     */
    public function setPostNumber(string $postNumber) : self
    {
        $this->initialized['postNumber'] = true;
        $this->postNumber = $postNumber;
        return $this;
    }
    /**
     * City where the locker is located
     *
     * @return string
     */
    public function getCity() : string
    {
        return $this->city;
    }
    /**
     * City where the locker is located
     *
     * @param string $city
     *
     * @return self
     */
    public function setCity(string $city) : self
    {
        $this->initialized['city'] = true;
        $this->city = $city;
        return $this;
    }
    /**
     * A valid country code consisting of three characters according to ISO 3166-1 alpha-3.
     *
     * @return string
     */
    public function getCountry() : string
    {
        return $this->country;
    }
    /**
     * A valid country code consisting of three characters according to ISO 3166-1 alpha-3.
     *
     * @param string $country
     *
     * @return self
     */
    public function setCountry(string $country) : self
    {
        $this->initialized['country'] = true;
        $this->country = $country;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getPostalCode() : string
    {
        return $this->postalCode;
    }
    /**
     * 
     *
     * @param string $postalCode
     *
     * @return self
     */
    public function setPostalCode(string $postalCode) : self
    {
        $this->initialized['postalCode'] = true;
        $this->postalCode = $postalCode;
        return $this;
    }
}