<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 derksen mediaopt GmbH
 */

namespace sdk;

use Mediaopt\DHL\Address\Address;
use Mediaopt\DHL\Address\Sender;

class SenderTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructorInjection()
    {
        $address = new Address('Elbestr.', '29', '12045', 'Berlin');
        $line1 = 'Line #1';
        $line2 = 'Line #2';
        $line3 = 'Line #3';
        $sender = new Sender($address, $line1, $line2, $line3);
        $this->assertEquals($address, $sender->getAddress());
        $this->assertEquals($line1, $sender->getLine1());
        $this->assertEquals($line2, $sender->getLine2());
        $this->assertEquals($line3, $sender->getLine3());
    }

}
