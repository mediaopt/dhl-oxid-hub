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
     * An optional, additional line of address. It's only usable for a few countries, e.g. Belgium. It is positioned below name3 on the label.
     *
     * @var string
     */
    protected $dispatchingInformation;
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
     * Additional information that is positioned either behind or below addressStreet on the label. If it is printed and where exactly depends on the country.
     *
     * @var string
     */
    protected $additionalAddressInformation1;
    /**
     * Additional information that is positioned either behind or below addressStreet on the label. If it is printed and where exactly depends on the country.
     *
     * @var string
     */
    protected $additionalAddressInformation2;
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
     * State, province or territory. For the USA please use the official regional ISO-Codes, e.g. US-AL.
     *
     * @var string
     */
    protected $state;
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
     * Please note that, in accordance with Art. 4 No. 11 GDPR, you must obtain the recipient's consent to forward their phone number to Deutsche Post DHL Group. For shipments within Germany, the phone number cannot be transmitted. In some countries the provision of a telephone number and/or e-mail address is mandatory for a delivery to a droppoint. If your recipient has objected to the disclosure of their telephone number and/or e-mail address, the shipment can only be delivered in these countries using the service Premium.
     *
     * @var string
     */
    protected $phone;
    /**
     * Please note that, in accordance with Art. 4 No. 11 GDPR, you must obtain the recipient's consent to forward their e-mail address to Deutsche Post DHL Group. For shipments within Germany, the e-mail address is used to send a DHL Parcel Notification to the recipient. The e-mail address is not mandatory for shipments within Germany. In some countries the provision of a telephone number and/or e-mail address is mandatory for a delivery to a droppoint. If your recipient has objected to the disclosure of their telephone number and/or e-mail address, the shipment can only be delivered in these countries using the service Premium.
     *
     * @var string
     */
    protected $email;
    /**
     * Contains a reference to the Shipper data configured in GKP(Geschäftskundenportal - Business Costumer Portal). Can be used instead of a detailed shipper address. The shipper reference can be used to print a company logo which is configured in GKP onto the label.
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
     * An optional, additional line of address. It's only usable for a few countries, e.g. Belgium. It is positioned below name3 on the label.
     *
     * @return string
     */
    public function getDispatchingInformation() : string
    {
        return $this->dispatchingInformation;
    }
    /**
     * An optional, additional line of address. It's only usable for a few countries, e.g. Belgium. It is positioned below name3 on the label.
     *
     * @param string $dispatchingInformation
     *
     * @return self
     */
    public function setDispatchingInformation(string $dispatchingInformation) : self
    {
        $this->initialized['dispatchingInformation'] = true;
        $this->dispatchingInformation = $dispatchingInformation;
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
     * Additional information that is positioned either behind or below addressStreet on the label. If it is printed and where exactly depends on the country.
     *
     * @return string
     */
    public function getAdditionalAddressInformation1() : string
    {
        return $this->additionalAddressInformation1;
    }
    /**
     * Additional information that is positioned either behind or below addressStreet on the label. If it is printed and where exactly depends on the country.
     *
     * @param string $additionalAddressInformation1
     *
     * @return self
     */
    public function setAdditionalAddressInformation1(string $additionalAddressInformation1) : self
    {
        $this->initialized['additionalAddressInformation1'] = true;
        $this->additionalAddressInformation1 = $additionalAddressInformation1;
        return $this;
    }
    /**
     * Additional information that is positioned either behind or below addressStreet on the label. If it is printed and where exactly depends on the country.
     *
     * @return string
     */
    public function getAdditionalAddressInformation2() : string
    {
        return $this->additionalAddressInformation2;
    }
    /**
     * Additional information that is positioned either behind or below addressStreet on the label. If it is printed and where exactly depends on the country.
     *
     * @param string $additionalAddressInformation2
     *
     * @return self
     */
    public function setAdditionalAddressInformation2(string $additionalAddressInformation2) : self
    {
        $this->initialized['additionalAddressInformation2'] = true;
        $this->additionalAddressInformation2 = $additionalAddressInformation2;
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
     * State, province or territory. For the USA please use the official regional ISO-Codes, e.g. US-AL.
     *
     * @return string
     */
    public function getState() : string
    {
        return $this->state;
    }
    /**
     * State, province or territory. For the USA please use the official regional ISO-Codes, e.g. US-AL.
     *
     * @param string $state
     *
     * @return self
     */
    public function setState(string $state) : self
    {
        $this->initialized['state'] = true;
        $this->state = $state;
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
     * Please note that, in accordance with Art. 4 No. 11 GDPR, you must obtain the recipient's consent to forward their phone number to Deutsche Post DHL Group. For shipments within Germany, the phone number cannot be transmitted. In some countries the provision of a telephone number and/or e-mail address is mandatory for a delivery to a droppoint. If your recipient has objected to the disclosure of their telephone number and/or e-mail address, the shipment can only be delivered in these countries using the service Premium.
     *
     * @return string
     */
    public function getPhone() : string
    {
        return $this->phone;
    }
    /**
     * Please note that, in accordance with Art. 4 No. 11 GDPR, you must obtain the recipient's consent to forward their phone number to Deutsche Post DHL Group. For shipments within Germany, the phone number cannot be transmitted. In some countries the provision of a telephone number and/or e-mail address is mandatory for a delivery to a droppoint. If your recipient has objected to the disclosure of their telephone number and/or e-mail address, the shipment can only be delivered in these countries using the service Premium.
     *
     * @param string $phone
     *
     * @return self
     */
    public function setPhone(string $phone) : self
    {
        $this->initialized['phone'] = true;
        $this->phone = $phone;
        return $this;
    }
    /**
     * Please note that, in accordance with Art. 4 No. 11 GDPR, you must obtain the recipient's consent to forward their e-mail address to Deutsche Post DHL Group. For shipments within Germany, the e-mail address is used to send a DHL Parcel Notification to the recipient. The e-mail address is not mandatory for shipments within Germany. In some countries the provision of a telephone number and/or e-mail address is mandatory for a delivery to a droppoint. If your recipient has objected to the disclosure of their telephone number and/or e-mail address, the shipment can only be delivered in these countries using the service Premium.
     *
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }
    /**
     * Please note that, in accordance with Art. 4 No. 11 GDPR, you must obtain the recipient's consent to forward their e-mail address to Deutsche Post DHL Group. For shipments within Germany, the e-mail address is used to send a DHL Parcel Notification to the recipient. The e-mail address is not mandatory for shipments within Germany. In some countries the provision of a telephone number and/or e-mail address is mandatory for a delivery to a droppoint. If your recipient has objected to the disclosure of their telephone number and/or e-mail address, the shipment can only be delivered in these countries using the service Premium.
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
     * Contains a reference to the Shipper data configured in GKP(Geschäftskundenportal - Business Costumer Portal). Can be used instead of a detailed shipper address. The shipper reference can be used to print a company logo which is configured in GKP onto the label.
     *
     * @return string
     */
    public function getShipperRef() : string
    {
        return $this->shipperRef;
    }
    /**
     * Contains a reference to the Shipper data configured in GKP(Geschäftskundenportal - Business Costumer Portal). Can be used instead of a detailed shipper address. The shipper reference can be used to print a company logo which is configured in GKP onto the label.
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