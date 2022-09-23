<?php


namespace sdk;


use Mediaopt\DHL\Address\Address;

trait AddressCreationTrait
{

    protected function buildAddress($street, $streetNo, $zip, $city, $district = '', $country = 'DEU', $countryIso2Code = 'DE')
    {
        return $this
            ->getMockBuilder(Address::class)
            ->setMethods(['getCountryId'])
            ->setConstructorArgs([$street, $streetNo, $zip, $city, $district, $country, $countryIso2Code])
            ->getMock();
    }
}