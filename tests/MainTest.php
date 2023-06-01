<?php

use Mediaopt\DHL\Api\Standortsuche;
use Mediaopt\DHL\Api\Wunschpaket;
use Mediaopt\DHL\Main;
use PhpUnit\Framework\TestCase;

class MainTest extends TestCase
{

    public function testGetConfigurator()
    {
        $configurator = new TestConfigurator();
        $main = new Main($configurator);
        $this->assertSame($configurator, $main->getConfigurator());
    }

    public function testSetConfigurator()
    {
        $main = new Main(new TestConfigurator());
        $configurator = new TestConfigurator();
        $this->assertSame($configurator, $main->setConfigurator($configurator)->getConfigurator());
    }

    public function testGetLogger()
    {
        $configuratorMock = $this
            ->getMockBuilder('TestConfigurator')
            ->setMethods(['buildLogger'])
            ->getMock();
        $logger = new \Monolog\Logger(__CLASS__);
        $configuratorMock
            ->expects($this->once())
            ->method('buildLogger')
            ->willReturn($logger);

        $main = new Main($configuratorMock);
        $this->assertSame($logger, $main->getLogger());
    }

    public function testBuildStandortsuche()
    {
        $this->assertInstanceOf(Standortsuche::class, (new Main(new TestConfigurator()))->buildStandortsuche());
    }

    public function testBuildWunschpaket()
    {
        $this->assertInstanceOf(Wunschpaket::class, (new Main(new TestConfigurator()))->buildWunschpaket());
    }

}
