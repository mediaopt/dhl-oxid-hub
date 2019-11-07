<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 derksen mediaopt GmbH
 */

use Mediaopt\DHL\Shipment\Contact;

/**
 * @author  derksen mediaopt GmbH
 */
class ContactTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorInjection()
    {
        $name = 'Arno Nühm';
        $email = 'arno@nue.hm';
        $phone = '007';
        $company = 'derksen mediaopt GmbH';
        $contact = new Contact($name, $email, $phone, $company);
        $this->assertEquals($name, $contact->getName());
        $this->assertEquals($email, $contact->getEmail());
        $this->assertEquals($phone, $contact->getPhone());
        $this->assertEquals($company, $contact->getCompany());
    }

    public function testConstructorInjectionWithoutCompany()
    {
        $name = 'Arno Nühm';
        $email = 'arno@nue.hm';
        $phone = '007';
        $contact = new Contact($name, $email, $phone);
        $this->assertEquals($name, $contact->getName());
        $this->assertEquals($email, $contact->getEmail());
        $this->assertEquals($phone, $contact->getPhone());
        $this->assertEquals('', $contact->getCompany());
    }

    public function testConstructorInjectionWithoutCompanyAndPhone()
    {
        $name = 'Arno Nühm';
        $email = 'arno@nue.hm';
        $contact = new Contact($name, $email);
        $this->assertEquals($name, $contact->getName());
        $this->assertEquals($email, $contact->getEmail());
        $this->assertEquals('', $contact->getPhone());
        $this->assertEquals('', $contact->getCompany());
    }

    public function testConstructorInjectionWithoutCompanyAndPhoneAndEmail()
    {
        $name = 'Arno Nühm';
        $contact = new Contact($name);
        $this->assertEquals($name, $contact->getName());
        $this->assertEquals('', $contact->getEmail());
        $this->assertEquals('', $contact->getPhone());
        $this->assertEquals('', $contact->getCompany());
    }
}
