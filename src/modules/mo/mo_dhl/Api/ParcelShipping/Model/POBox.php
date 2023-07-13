<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class POBox extends \ArrayObject
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
     * Name1. Line 1 of name information
     *
     * @var string
     */
    protected $name1;
    /**
     * An optional, additional line of name information
     *
     * @var string
     */
    protected $name2;
    /**
     * An optional, additional line of name information
     *
     * @var string
     */
    protected $name3;
    /**
     * Number of P.O. Box (Postfach)
     *
     * @var int
     */
    protected $poBoxID;
    /**
     * Email address of the consignee
     *
     * @var string
     */
    protected $email;
    /**
     * City of the P.O. Box (Postfach) location
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
     * Postal code of the P.O. Box (Postfach) location
     *
     * @var string
     */
    protected $postalCode;
    /**
     * Name1. Line 1 of name information
     *
     * @return string
     */
    public function getName1() : string
    {
        return $this->name1;
    }
    /**
     * Name1. Line 1 of name information
     *
     * @param string $name1
     *
     * @return self
     */
    public function setName1(string $name1) : self
    {
        $this->initialized['name1'] = true;
        $this->name1 = $name1;
        return $this;
    }
    /**
     * An optional, additional line of name information
     *
     * @return string
     */
    public function getName2() : string
    {
        return $this->name2;
    }
    /**
     * An optional, additional line of name information
     *
     * @param string $name2
     *
     * @return self
     */
    public function setName2(string $name2) : self
    {
        $this->initialized['name2'] = true;
        $this->name2 = $name2;
        return $this;
    }
    /**
     * An optional, additional line of name information
     *
     * @return string
     */
    public function getName3() : string
    {
        return $this->name3;
    }
    /**
     * An optional, additional line of name information
     *
     * @param string $name3
     *
     * @return self
     */
    public function setName3(string $name3) : self
    {
        $this->initialized['name3'] = true;
        $this->name3 = $name3;
        return $this;
    }
    /**
     * Number of P.O. Box (Postfach)
     *
     * @return int
     */
    public function getPoBoxID() : int
    {
        return $this->poBoxID;
    }
    /**
     * Number of P.O. Box (Postfach)
     *
     * @param int $poBoxID
     *
     * @return self
     */
    public function setPoBoxID(int $poBoxID) : self
    {
        $this->initialized['poBoxID'] = true;
        $this->poBoxID = $poBoxID;
        return $this;
    }
    /**
     * Email address of the consignee
     *
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }
    /**
     * Email address of the consignee
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email) : self
    {
        $this->initialized['email'] = true;
        $this->email = $email;
        return $this;
    }
    /**
     * City of the P.O. Box (Postfach) location
     *
     * @return string
     */
    public function getCity() : string
    {
        return $this->city;
    }
    /**
     * City of the P.O. Box (Postfach) location
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
     * Postal code of the P.O. Box (Postfach) location
     *
     * @return string
     */
    public function getPostalCode() : string
    {
        return $this->postalCode;
    }
    /**
     * Postal code of the P.O. Box (Postfach) location
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