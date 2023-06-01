<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 Mediaopt GmbH
 */

namespace sdk;

use Mediaopt\DHL\Api\Credentials;
use PhpUnit\Framework\TestCase;

class CredentialsTest extends TestCase
{

    public function testSandboxRestEndpoint()
    {
        $credentials = Credentials::createSandboxRestEndpoint('foo', 'bar', '1234567890');
        $this->assertEquals('foo', $credentials->getUsername());
        $this->assertEquals('bar', $credentials->getPassword());
        $this->assertEquals('1234567890', $credentials->getEkp());
        $this->assertEquals('https://cig.dhl.de/services/sandbox/rest', $credentials->getEndpoint());
    }

    public function testProductionRestEndpoint()
    {
        $credentials = Credentials::createProductionRestEndpoint('bar', 'foo', '1234567890');
        $this->assertEquals('bar', $credentials->getUsername());
        $this->assertEquals('foo', $credentials->getPassword());
        $this->assertEquals('1234567890', $credentials->getEkp());
        $this->assertEquals('https://cig.dhl.de/services/production/rest', $credentials->getEndpoint());
    }

    public function testSandboxSoapEndpoint()
    {
        $credentials = Credentials::createSandboxSoapEndpoint('foo', 'bar', '1234567890');
        $this->assertEquals('foo', $credentials->getUsername());
        $this->assertEquals('bar', $credentials->getPassword());
        $this->assertEquals('1234567890', $credentials->getEkp());
        $this->assertEquals('https://cig.dhl.de/services/sandbox/soap', $credentials->getEndpoint());
    }

    public function testProductionSoapEndpoint()
    {
        $credentials = Credentials::createProductionSoapEndpoint('bar', 'foo', '1234567890');
        $this->assertEquals('bar', $credentials->getUsername());
        $this->assertEquals('foo', $credentials->getPassword());
        $this->assertEquals('1234567890', $credentials->getEkp());
        $this->assertEquals('https://cig.dhl.de/services/production/soap', $credentials->getEndpoint());
    }
}
