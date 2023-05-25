<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class Shipper extends \ArrayObject
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
     * Line 1 of the street address. This is just the street name. Can also include house number.
     *
     * @var string
     */
    protected $addressStreet;
    /**
     * Line 1 of the street address. This is just the house number. Can be added to street name instead.
     *
     * @var string
     */
    protected $addressHouse;
    /**
     * Mandatory for all countries but Ireland that use a postal code system.
     *
     * @var string
     */
    protected $postalCode;
    /**
     * city
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
     * optional contact name. (this is not the primary name printed on label)
     *
     * @var string
     */
    protected $contactName;
    /**
     * Optional contact email address of the shipper
     *
     * @var string
     */
    protected $email;
    /**
     * Contains a reference to the Shipper data configured in GKP(GeschÃ¤ftskundenportal - Business Costumer Portal). Can be used instead of a detailed shipper address. The shipper reference can be used to print a company logo which is configured in GKP onto the label.
     *
     * @var string
     */
    protected $shipperRef;
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
     * Line 1 of the street address. This is just the street name. Can also include house number.
     *
     * @return string
     */
    public function getAddressStreet() : string
    {
        return $this->addressStreet;
    }
    /**
     * Line 1 of the street address. This is just the street name. Can also include house number.
     *
     * @param string $addressStreet
     *
     * @return self
     */
    public function setAddressStreet(string $addressStreet) : self
    {
        $this->initialized['addressStreet'] = true;
        $this->addressStreet = $addressStreet;
        return $this;
    }
    /**
     * Line 1 of the street address. This is just the house number. Can be added to street name instead.
     *
     * @return string
     */
    public function getAddressHouse() : string
    {
        return $this->addressHouse;
    }
    /**
     * Line 1 of the street address. This is just the house number. Can be added to street name instead.
     *
     * @param string $addressHouse
     *
     * @return self
     */
    public function setAddressHouse(string $addressHouse) : self
    {
        $this->initialized['addressHouse'] = true;
        $this->addressHouse = $addressHouse;
        return $this;
    }
    /**
     * Mandatory for all countries but Ireland that use a postal code system.
     *
     * @return string
     */
    public function getPostalCode() : string
    {
        return $this->postalCode;
    }
    /**
     * Mandatory for all countries but Ireland that use a postal code system.
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
    /**
     * city
     *
     * @return string
     */
    public function getCity() : string
    {
        return $this->city;
    }
    /**
     * city
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
     * optional contact name. (this is not the primary name printed on label)
     *
     * @return string
     */
    public function getContactName() : string
    {
        return $this->contactName;
    }
    /**
     * optional contact name. (this is not the primary name printed on label)
     *
     * @param string $contactName
     *
     * @return self
     */
    public function setContactName(string $contactName) : self
    {
        $this->initialized['contactName'] = true;
        $this->contactName = $contactName;
        return $this;
    }
    /**
     * Optional contact email address of the shipper
     *
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }
    /**
     * Optional contact email address of the shipper
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
     * Contains a reference to the Shipper data configured in GKP(GeschÃ¤ftskundenportal - Business Costumer Portal). Can be used instead of a detailed shipper address. The shipper reference can be used to print a company logo which is configured in GKP onto the label.
     *
     * @return string
     */
    public function getShipperRef() : string
    {
        return $this->shipperRef;
    }
    /**
     * Contains a reference to the Shipper data configured in GKP(GeschÃ¤ftskundenportal - Business Costumer Portal). Can be used instead of a detailed shipper address. The shipper reference can be used to print a company logo which is configured in GKP onto the label.
     *
     * @param string $shipperRef
     *
     * @return self
     */
    public function setShipperRef(string $shipperRef) : self
    {
        $this->initialized['shipperRef'] = true;
        $this->shipperRef = $shipperRef;
        return $this;
    }
}