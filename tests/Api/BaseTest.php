<?php

namespace sdk;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Stream\BufferStream;
use GuzzleHttp\Stream\NullStream;
use Mediaopt\DHL\Api\Credentials;
use Mediaopt\DHL\Api\Standortsuche;
use Mediaopt\DHL\Exception\WebserviceException;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    public function testGetLogger()
    {
        $configurator = new \TestConfigurator();
        $logger = $configurator->buildLogger();
        $api = $configurator->buildStandortsuche($logger);
        $this->assertSame($logger, $api->getLogger());
    }

    public function testGetClient()
    {
        $configurator = new \TestConfigurator();
        $client = $configurator->buildClient();
        $api = $configurator->buildStandortsuche(null, $client);
        $this->assertSame($client, $api->getClient());
    }

    public function testGetCredentials()
    {
        $configurator = new \TestConfigurator();
        $credentials = new Credentials('???', '???', '???');
        $api = new Standortsuche($credentials, $configurator->buildLogger(), $configurator->buildClient());
        $this->assertSame($credentials, $api->getCredentials());
    }

    public function testThatAnApiCallWithNonJsonResponseLeadsToAnException()
    {
        $buffer = new BufferStream();
        $buffer->write(md5(mt_rand()));
        $clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();
        $clientMock
            ->method('get')
            ->willReturn(new Response('200', [], $buffer));

        $this->expectException(WebserviceException::class);
        $this->expectExceptionMessageRegExp('/unexpected/');
        (new \TestConfigurator())
            ->buildStandortsuche((new \TestConfigurator())->buildLogger(), $clientMock)
            ->getParcellocationByPrimaryKeyPSF('8003-4096851');
    }
}
