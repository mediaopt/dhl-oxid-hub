<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 derksen mediaopt GmbH
 */

use Mediaopt\DHL\Address\Address;
use Mediaopt\DHL\Address\Receiver;
use Mediaopt\DHL\Shipment\Contact;


/**
 *
 *
 * @author derksen mediaopt GmbH
 */
class ReceiverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Address
     */
    protected function buildSampleAddress()
    {
        return new Address('Elbestr.', '29', '12045', 'Berlin');
    }

    public function testConstructorInjection()
    {
        $contact = new Contact('Arno Nühm', 'arno@nue.hm', '007', 'derksen mediopt GmbH');
        $postnummer = '123456789';
        $address = $this->buildSampleAddress();
        $locationType = 'Wunschnachbar';
        $location = 'Rudi Mentär';
        $time = '12001400';
        $wunschtag = date('d.m.Y', strtotime('next Wednesday'));

        $receiver = new Receiver($contact, $postnummer, $address, $locationType, $location, $time, $wunschtag);
        $this->assertEquals($contact, $receiver->getReceiver());
        $this->assertEquals($postnummer, $receiver->getPostnummer());
        $this->assertEquals($address, $receiver->getAddress());
        $this->assertEquals($locationType, $receiver->getDesiredLocationType());
        $this->assertEquals($location, $receiver->getDesiredLocation());
        $this->assertEquals($time, $receiver->getDesiredTime());
    }

    public function testLinesWithNameOnly()
    {
        $name = Faker\Factory::create('de')->name;
        $contact = new Contact($name);
        $receiver = new Receiver($contact, '', $this->buildSampleAddress(), '', '', '', '');
        $this->assertEquals($name, $receiver->getLine1());
        $this->assertEquals('', $receiver->getLine2());
        $this->assertEquals('', $receiver->getLine3());
    }

    public function testLinesWithNameAndPostnummer()
    {
        $name = Faker\Factory::create('de')->name;
        $contact = new Contact($name);
        $postnummer = '1234567890';
        $receiver = new Receiver($contact, $postnummer, $this->buildSampleAddress(), '', '', '', '');
        $this->assertEquals($name, $receiver->getLine1());
        $this->assertEquals($postnummer, $receiver->getLine2());
        $this->assertEquals('', $receiver->getLine3());
    }

    public function testLinesWithNameAndCompany()
    {
        $faker = Faker\Factory::create('de');
        $name = $faker->name;
        $company = $faker->company;
        $contact = new Contact($name, '', '', $company);
        $receiver = new Receiver($contact, '', $this->buildSampleAddress(), '', '', '', '');
        $this->assertEquals($company, $receiver->getLine1());
        $this->assertEquals($name, $receiver->getLine2());
        $this->assertEquals('', $receiver->getLine3());
    }

    public function testLinesWithNameAndPostnummerAndCompany()
    {
        $faker = Faker\Factory::create('de');
        $name = $faker->name;
        $company = $faker->company;
        $contact = new Contact($name, '', '', $company);
        $postnummer = '1234567890';
        $receiver = new Receiver($contact, $postnummer, $this->buildSampleAddress(), '', '', '', '');
        $this->assertEquals($company, $receiver->getLine1());
        $this->assertEquals($postnummer, $receiver->getLine2());
        $this->assertEquals($name, $receiver->getLine3());
    }
}
