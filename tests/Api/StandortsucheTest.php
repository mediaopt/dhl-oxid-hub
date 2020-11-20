<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 Mediaopt GmbH
 */

namespace sdk\Standortsuche;


use Location\Coordinate;
use Location\Distance\Vincenty;
use Mediaopt\DHL\Address\Address;
use Mediaopt\DHL\Api\Standortsuche;
use Mediaopt\DHL\Api\Standortsuche\ServiceProviderBuilder;
use Mediaopt\DHL\Exception\ServiceProviderException;
use Mediaopt\DHL\Exception\WebserviceException;
use Mediaopt\DHL\ServiceProvider\BasicServiceProvider;
use Mediaopt\DHL\ServiceProvider\Coordinates;
use Mediaopt\DHL\ServiceProvider\ServiceType;
use Monolog\Logger;


class StandortsucheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Coordinates
     */
    public function buildSampleCoordinates()
    {
        return new Coordinates(52.484766, 13.440547);
    }

    /**
     * @return Standortsuche
     */
    public function buildStandortsuche()
    {
        $configurator = new \TestConfigurator();
        return $configurator->buildStandortsuche($configurator->buildLogger());
    }

    /**
     * @return Address
     */
    public function buildSampleAddress()
    {
        return new Address('Elbestr.', '28', '12045', 'Berlin');
    }

    public function buildSampleAddressString()
    {
        return implode(' ', array_filter($this->buildSampleAddress()->toArray()));
    }

    public function testThatAFailingBuildCallIsLogged()
    {
        $serviceProviderBuilderMock = $this
            ->getMockBuilder(ServiceProviderBuilder::class)
            ->setMethods(['build'])
            ->getMock();
        $serviceProviderBuilderMock
            ->expects($this->exactly(50))
            ->method('build')
            ->willThrowException(new ServiceProviderException());

        $loggerMock = $this->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'error'])
            ->getMock();
        $loggerMock
            ->expects($this->exactly(50))
            ->method('error');

        (new \TestConfigurator())
            ->buildStandortsuche($loggerMock, null, $serviceProviderBuilderMock)
            ->getParcellocationByAddress($this->buildSampleAddress());
    }

    /*public function testThatAFailingBuildCallIsLoggedAndAndExceptionIsRaisedWhenFindingByPrimaryKeyFSF()
    {
        $serviceProviderBuilderMock = $this
            ->getMockBuilder(ServiceProviderBuilder::class)
            ->setMethods(['build'])
            ->getMock();
        $serviceProviderBuilderMock
            ->expects($this->once())
            ->method('build')
            ->willThrowException(new ServiceProviderException());

        $loggerMock = $this->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->setMethods(['debug', 'error'])
            ->getMock();
        $loggerMock
            ->expects($this->once())
            ->method('error');

        $this->expectException(WebserviceException::class);
        (new \TestConfigurator())
            ->buildStandortsuche($loggerMock, null, $serviceProviderBuilderMock)
            ->getParcellocationByPrimaryKeyPSF('8003-4096851');
    }*/

    public function testThatNoServiceProviderIsFurtherAwayThan15KmInGermany()
    {
        $standortsuche = $this->buildStandortsuche();
        $address = new Address('', '', '56290', 'Uhler');
        $serviceProviders = $standortsuche->getParcellocationByAddress($address);
        foreach ($serviceProviders->toArray() as $serviceProvider) {
            $this->assertLessThanOrEqual(15000, $serviceProvider->getLocation()->getDistance());
        }
    }

    public function testThatNoServiceProviderIsFurtherAwayThan25KmOutsideOfGermany()
    {
        $standortsuche = $this->buildStandortsuche();
        $address = new Address('', '', '6481', 'Weixmannstall', '', 'at');
        $serviceProviders = $standortsuche->getParcellocationByAddress($address);
        foreach ($serviceProviders->toArray() as $serviceProvider) {
            $this->assertLessThanOrEqual(25000, $serviceProvider->getLocation()->getDistance());
        }
    }

    /*public function testGettingParcelLocationByServiceTypeAndCoordinate()
    {
        $standortsuche = $this->buildStandortsuche();
        $coordinates = $this->buildSampleCoordinates();
        $parcelPickup = ServiceType::create(ServiceType::PARCEL_PICKUP);
        $list = $standortsuche->getParcellocationByServiceTypeAndCoordinate($parcelPickup, $coordinates);
        $this->assertNotEmpty($list->toArray());
        foreach ($list->toArray() as $serviceProvider) {
            /** @noinspection PhpUnitTestsInspection *
            $this->assertTrue(in_array($parcelPickup, $serviceProvider->getServiceTypes(), false));
        }
    }*/

    /*public function testGettingParcelLocationByCoordinate()
    {
        $standortsuche = $this->buildStandortsuche();
        $list = $standortsuche->getParcellocationByCoordinate($this->buildSampleCoordinates());
        $this->assertNotEmpty($list->toArray());
    }*/

    /*public function testGettingParcelLocationByAddressAndServiceType()
    {
        $standortsuche = $this->buildStandortsuche();
        $address = $this->buildSampleAddress();
        $parcelPickup = ServiceType::create(ServiceType::PARCEL_PICKUP);
        $list = $standortsuche->getParcellocationByAddressAndServiceType($parcelPickup, $address);
        $this->assertNotEmpty($list->toArray());
        foreach ($list->toArray() as $serviceProvider) {
            /** @noinspection PhpUnitTestsInspection *
            $this->assertTrue(in_array($parcelPickup, $serviceProvider->getServiceTypes(), false));
        }
    }*/

    /*public function testGettingParcelLocationByAddressStringAndServiceType()
    {
        $standortsuche = $this->buildStandortsuche();
        $addressString = $this->buildSampleAddressString();
        $parcelPickup = ServiceType::create(ServiceType::PARCEL_PICKUP);
        $list = $standortsuche->getParcellocationByAddressAndServiceType($parcelPickup, $addressString);
        $this->assertNotEmpty($list->toArray());
        foreach ($list->toArray() as $serviceProvider) {
            /** @noinspection PhpUnitTestsInspection *
            $this->assertTrue(in_array($parcelPickup, $serviceProvider->getServiceTypes(), false));
        }
    }*/

    public function testGettingParcelLocationByAddress()
    {
        $list = $this->buildStandortsuche()->getParcellocationByAddress($this->buildSampleAddress());
        $this->assertNotEmpty($list->toArray());
    }

    public function testGettingParcelLocationByAddressString()
    {
        $list = $this->buildStandortsuche()->getParcellocationByAddress($this->buildSampleAddressString());
        $this->assertNotEmpty($list->toArray());
    }

    /*public function testGettingParcelLocationByPrimaryKeyPSF()
    {
        $provider = $this->buildStandortsuche()->getParcellocationByPrimaryKeyPSF('8003-4096851');
        $this->assertInstanceOf(BasicServiceProvider::class, $provider);
    }*/

    /**
     * This test will ensure that there would be the right result
     * with provided address contained chars
     * "()-./ABCDEFGHIJKLMNOPQRSTUVWXZabcdefghijklmnopqrstuvwxyz"
     * and utf-8 chars
     */
    public function testGettingTheRightCityWithDirtyAddress()
    {
        //Threshold in meters
        $sameCityDistanceThreshold = 20000;
        $calculator = new Vincenty();

        //List of addresses and right coordinates
        $inputList = [
            [
                'address'    => new Address('Elbestr.', '28/26', '12045', 'Berlin', '', ''),
                'coordinate' => new Coordinate(52.519938, 13.413183),
            ],
            [
                'address'    => new Address('', '', '', 'Auerbach in der Oberpfalz', '', ''),
                'coordinate' => new Coordinate(49.691990, 11.628689),
            ],
            [
                'address'    => new Address('', '', '', 'Auerbach/Vogtl.', '', ''),
                'coordinate' => new Coordinate(50.507884, 12.399722),
            ],
            [
                'address'    => new Address('', '', '', 'Neukirchen/Pleiße', '', ''),
                'coordinate' => new Coordinate(50.792825, 12.379732),
            ],
            [
                'address'    => new Address('', '', '', 'Nienburg (Saale)', '', ''),
                'coordinate' => new Coordinate(51.837269, 11.766504),
            ],
        ];

        foreach ($inputList as $input) {
            /** @var Address $address */
            $address = $input['address'];
            $list = $this->buildStandortsuche()->getParcellocationByAddress($address);
            $this->assertNotEmpty($list->toArray(), 'No result with address: ' . implode(' ', $address->toArray()));

            /** @var $serviceProvider \Mediaopt\DHL\ServiceProvider\BasicServiceProvider */
            $serviceProvider = $list->toArray()[0];
            $location = $serviceProvider->getLocation();
            $coordToCheck = new Coordinate($location->getCoordinates()->getLatitude(), $location->getCoordinates()->getLongitude());
            $dist = abs($calculator->getDistance($input['coordinate'], $coordToCheck));

            $this->assertLessThanOrEqual($sameCityDistanceThreshold, $dist, 'Request with a dirty address returns coordinates outside the threshold distance.');
        }
    }

    public function testGettingEmptyResultOutsideGermany()
    {
        $inputList = [
            new Address('', '', '', 'Málaga', '', ''),
            new Address('', '', '1100', 'Wien', '', ''),
        ];
        foreach ($inputList as $address) {
            $list = $this->buildStandortsuche()->getParcellocationByAddress($address);
            $this->assertEmpty($list->toArray(), 'Got result for non german address: ' . implode(' ', $address->toArray()));
        }
    }

    /**
     * This test will ensure that there would be no result for empty Address request
     */
    public function testThatThereANoResultsInCaseOfAnEmptyAddress()
    {
        $emptyAddress = new Address('', '', '', '', '', '');
        $this->assertEmpty($this->buildStandortsuche()->getParcellocationByAddress($emptyAddress)->toArray());
    }

    /*public function testThatThereANoResultsInCaseOfAnEmptyAddressAndServiceType()
    {
        $emptyAddress = new Address('', '', '', '', '', '');
        $serviceProviders = $this
            ->buildStandortsuche()
            ->getParcellocationByAddressAndServiceType(ServiceType::create(ServiceType::PARCEL_PICKUP), $emptyAddress);
        $this->assertEmpty($serviceProviders->toArray());
    }*/
}
