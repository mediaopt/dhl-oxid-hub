<?php

namespace Mediaopt\DHL\Address;

/**
 * This class represents an address.
 *
 * @author  derksen mediaopt GmbH
 * @package Mediaopt\DHL
 */
class Address
{
    /**
     * @var string
     */
    protected $street;

    /**
     * @var string
     */
    protected $streetNo;

    /**
     * @var string
     */
    protected $zip;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $district;

    /**
     * @var string
     */
    protected $country;

    /**
     * @param string $street
     * @param string $streetNo
     * @param string $zip
     * @param string $city
     * @param string $district
     * @param string $country
     */
    public function __construct($street, $streetNo, $zip, $city, $district = '', $country = 'DEU')
    {
        $this->street = $street;
        $this->streetNo = $streetNo;
        $this->zip = $zip;
        $this->city = $city;
        $this->district = $district;
        $this->country = $country;
    }

    /**
     * @see $city
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @see $country
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @see $district
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * @see $street
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @see $streetNo
     * @return string
     */
    public function getStreetNo()
    {
        return $this->streetNo;
    }

    /**
     * @see $zip
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @return string[]
     */
    public function toArray()
    {
        return [
            'street'   => $this->getStreet(),
            'streetNo' => $this->getStreetNo(),
            'zip'      => $this->getZip(),
            'city'     => $this->getCity(),
            'district' => $this->getDistrict(),
            'country'  => $this->getCountry(),
        ];
    }
}
