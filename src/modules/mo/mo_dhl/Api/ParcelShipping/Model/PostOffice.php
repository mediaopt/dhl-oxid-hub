<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class PostOffice extends \ArrayObject
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
     * Id or Number of Post office / Filiale / outlet / parcel shop
     *
     * @var int
     */
    protected $retailID;
    /**
     * postNumber (Postnummer) is the official account number a private DHL Customer gets upon registration. To address a post office or retail outlet directly, either the post number or e-mail address of the consignee is needed.
     *
     * @var string
     */
    protected $postNumber;
    /**
     * Email address of the consignee. To address a post office or retail outlet directly, either the post number or e-mail address of the consignee is needed.
     *
     * @var string
     */
    protected $email;
    /**
     * City where the retail location is
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
     * Id or Number of Post office / Filiale / outlet / parcel shop
     *
     * @return int
     */
    public function getRetailID() : int
    {
        return $this->retailID;
    }
    /**
     * Id or Number of Post office / Filiale / outlet / parcel shop
     *
     * @param int $retailID
     *
     * @return self
     */
    public function setRetailID(int $retailID) : self
    {
        $this->initialized['retailID'] = true;
        $this->retailID = $retailID;
        return $this;
    }
    /**
     * postNumber (Postnummer) is the official account number a private DHL Customer gets upon registration. To address a post office or retail outlet directly, either the post number or e-mail address of the consignee is needed.
     *
     * @return string
     */
    public function getPostNumber() : string
    {
        return $this->postNumber;
    }
    /**
     * postNumber (Postnummer) is the official account number a private DHL Customer gets upon registration. To address a post office or retail outlet directly, either the post number or e-mail address of the consignee is needed.
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
     * Email address of the consignee. To address a post office or retail outlet directly, either the post number or e-mail address of the consignee is needed.
     *
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }
    /**
     * Email address of the consignee. To address a post office or retail outlet directly, either the post number or e-mail address of the consignee is needed.
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
     * City where the retail location is
     *
     * @return string
     */
    public function getCity() : string
    {
        return $this->city;
    }
    /**
     * City where the retail location is
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