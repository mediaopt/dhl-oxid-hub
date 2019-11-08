<?php


use Mediaopt\DHL\Api\Standortsuche;

class ConfiguratorTest extends PHPUnit_Framework_TestCase
{

    protected function getConfiguratorMock()
    {
        return $this
            ->getMockBuilder(\Mediaopt\DHL\Configurator::class)
            ->setMethods(['isProductionEnvironment', 'getLogin', 'getPassword', 'getMapsApiKey', 'buildLogHandler', 'getEkp'])
            ->getMock();
    }

    public function testApisClass()
    {
        $configurator = new TestConfigurator();
        $standortsuche = $configurator->buildStandortsuche(new \Monolog\Logger(__CLASS__));
        $this->assertInstanceOf(Standortsuche::class, $standortsuche);
    }

    public function testEndpointForProductionEnvironment()
    {
        $configuratorMock = $this->getConfiguratorMock();
        $configuratorMock
            ->expects($this->once())
            ->method('isProductionEnvironment')
            ->willReturn(true);

        /** @var Standortsuche $standortsuche */
        $standortsuche = $configuratorMock->buildStandortsuche(new \Monolog\Logger(__CLASS__));
        $this->assertContains('production', $standortsuche->getCredentials()->getEndpoint());
    }

    public function testEndpointForSandboxEnvironment()
    {
        $configuratorMock = $this->getConfiguratorMock();
        $configuratorMock
            ->expects($this->once())
            ->method('isProductionEnvironment')
            ->willReturn(false);

        /** @var Standortsuche $standortsuche */
        $standortsuche = $configuratorMock->buildStandortsuche(new \Monolog\Logger(__CLASS__));
        $this->assertContains('sandbox', $standortsuche->getCredentials()->getEndpoint());
    }

    public function testThatTheLoggerUsesTheLogHandler()
    {
        $configuratorMock = $this->getConfiguratorMock();
        $nullHandler = new Monolog\Handler\NullHandler();
        $configuratorMock
            ->expects($this->once())
            ->method('buildLogHandler')
            ->willReturn($nullHandler);

        $this->assertContains($nullHandler, $configuratorMock->buildLogger()->getHandlers());
    }

    public function testThatAClientHasALogger()
    {
        $configuratorMock = $this->getConfiguratorMock();
        $logger = new \Monolog\Logger(__CLASS__);
        $this->assertSame($logger, $configuratorMock->buildStandortsuche($logger)->getLogger());
    }

    public function testGetName()
    {
        $configuratorMock = $this->getConfiguratorMock();
        $this->assertFalse(empty($configuratorMock->getName()));
    }

}
