<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

namespace sdk;

use Mediaopt\DHL\Address\Address;

class AddressTest extends \PHPUnit_Framework_TestCase
{

    protected function getAddressInformation()
    {
        return [
            'street' => 'Elbestr.',
            'streetNo' => '28',
            'zip' => '12045',
            'city' => 'Berlin',
            'district' => 'Neukölln',
            'country' => 'Deutschland',
            'countryIso2Code' => 'DE',
        ];
    }

    protected function buildAddressFromArray(array $information)
    {
        return new Address(
            $information['street'],
            $information['streetNo'],
            $information['zip'],
            $information['city'],
            $information['district'],
            $information['country'],
            $information['countryIso2Code']
        );
    }

    public function testConstructorInjection()
    {
        $information = $this->getAddressInformation();
        $address = $this->buildAddressFromArray($information);
        $this->assertEquals($information['street'], $address->getStreet());
        $this->assertEquals($information['streetNo'], $address->getStreetNo());
        $this->assertEquals($information['zip'], $address->getZip());
        $this->assertEquals($information['city'], $address->getCity());
        $this->assertEquals($information['district'], $address->getDistrict());
        $this->assertEquals($information['country'], $address->getCountry());
        $this->assertEquals($information['countryIso2Code'], $address->getCountryIso2Code());
    }

    public function testToArray()
    {
        $information = $this->getAddressInformation();
        $address = $this->buildAddressFromArray($information);
        $this->assertEquals($address->toArray(), $information);
    }

}
