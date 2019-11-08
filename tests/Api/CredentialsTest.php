<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 Mediaopt GmbH
 */

namespace sdk;

use Mediaopt\DHL\Api\Credentials;


class CredentialsTest extends \PHPUnit_Framework_TestCase
{

    public function testSandboxEndpoint()
    {
        $credentials = Credentials::createSandboxEndpoint('foo', 'bar', '1234567890');
        $this->assertEquals('foo', $credentials->getUsername());
        $this->assertEquals('bar', $credentials->getPassword());
        $this->assertEquals('1234567890', $credentials->getEkp());
        $this->assertEquals('https://cig.dhl.de/services/sandbox/rest', $credentials->getEndpoint());
    }

    public function testProductionEndpoint()
    {
        $credentials = Credentials::createProductionEndpoint('bar', 'foo', '1234567890');
        $this->assertEquals('bar', $credentials->getUsername());
        $this->assertEquals('foo', $credentials->getPassword());
        $this->assertEquals('1234567890', $credentials->getEkp());
        $this->assertEquals('https://cig.dhl.de/services/production/rest', $credentials->getEndpoint());
    }

}
