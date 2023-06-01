<?php


use Mediaopt\DHL\Api\Standortsuche;
use PhpUnit\Framework\TestCase;

class ConfiguratorTest extends TestCase
{

    protected function getConfiguratorMock()
    {
        return $this
            ->getMockBuilder(\Mediaopt\DHL\Configurator::class)
            ->setMethods([
                'isProductionEnvironment',
                'getProdLogin',
                'getProdPassword',
                'getSandboxLogin',
                'getSandboxPassword',
                'getCustomerGKVLogin',
                'getCustomerGKVPassword',
                'getCustomerParcelShippingPassword',
                'getCustomerParcelShippingUsername',
                'getParcelShippingApiKey',
                'getCustomerRetoureLogin',
                'getCustomerRetourePassword',
                'getStandortsucheKeyName',
                'getProdStandortsuchePassword',
                'getSandboxStandortsuchePassword',
                'getInternetmarkeProdLogin',
                'getInternetmarkeProdSignature',
                'getInternetmarkeSandboxLogin',
                'getInternetmarkeSandboxSignature',
                'getCustomerPortokasseProdLogin',
                'getCustomerPortokasseProdPassword',
                'getCustomerPortokasseSandboxLogin',
                'getCustomerPortokasseSandboxPassword',
                'getProdWSLogin',
                'getProdWSPassword',
                'getCustomerProdWSMandantId',
                'getMapsApiKey',
                'buildLogHandler',
                'getEkp',
            ])
            ->getMock();
    }

    public function testApisClass()
    {
        $configurator = new TestConfigurator();
        $standortsuche = $configurator->buildStandortsuche(new \Monolog\Logger(__CLASS__));
        $this->assertInstanceOf(Standortsuche::class, $standortsuche);
    }

    public function testSoapEndpointForProductionEnvironment()
    {
        $configuratorMock = $this->getConfiguratorMock();
        $configuratorMock
            ->expects($this->once())
            ->method('isProductionEnvironment')
            ->willReturn(true);

        /** @var Standortsuche $standortsuche */
        $standortsuche = $configuratorMock->buildGKV(new \Monolog\Logger(__CLASS__));
        $this->assertContains('production', $standortsuche->getSoapCredentials()->getEndpoint());
    }

    public function testEndpointForSandboxEnvironment()
    {
        $configuratorMock = $this->getConfiguratorMock();
        $configuratorMock
            ->expects($this->once())
            ->method('isProductionEnvironment')
            ->willReturn(false);

        /** @var Standortsuche $standortsuche */
        $standortsuche = $configuratorMock->buildGKV(new \Monolog\Logger(__CLASS__));
        $this->assertContains('sandbox', $standortsuche->getSoapCredentials()->getEndpoint());
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
