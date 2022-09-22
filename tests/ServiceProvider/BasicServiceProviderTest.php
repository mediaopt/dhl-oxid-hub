<?php

use Mediaopt\DHL\Address\Address;
use Mediaopt\DHL\ServiceProvider\BasicServiceProvider;
use Mediaopt\DHL\ServiceProvider\Coordinates;
use Mediaopt\DHL\ServiceProvider\Filiale;
use Mediaopt\DHL\ServiceProvider\Location;
use Mediaopt\DHL\ServiceProvider\Packstation;
use Mediaopt\DHL\ServiceProvider\Paketshop;
use Mediaopt\DHL\ServiceProvider\ServiceInformation;
use Mediaopt\DHL\ServiceProvider\ServiceType;
use Mediaopt\DHL\ServiceProvider\Timetable\PointInTime;
use Mediaopt\DHL\ServiceProvider\Timetable\Time;
use Mediaopt\DHL\ServiceProvider\Timetable\Timetable;

class BasicServiceProviderTest extends PHPUnit_Framework_TestCase
{

    use \sdk\AddressCreationTrait;

    public function testToArrayBasic()
    {
        $array = [
            'id'        => '123',
            'number'    => 456,
            'address'   => [
                'street'   => 'Elbestr.',
                'streetNo' => '28',
                'zip'      => '12045',
                'city'     => 'Berlin',
                'district' => 'Neukölln',
                'country'  => 'DEU',
                'countryIso2Code'  => 'DE',
                'countryId' => '',
            ],
            'location'  => [
                'latitude'  => 52.484766,
                'longitude' => 13.440547,
                'distance'  => 0,
            ],
            'timetable' => [
                '1' => [],
                '2' => [],
                '3' => ['18:00'],
                '4' => [],
                '5' => [],
                '6' => [],
                '7' => [],
            ],
            'groupedTimetable' => [
                1 => [
                    'dayGroup' => '1, 2, 4 - 7',
                    'openPeriods' => ''
                ],
                2 => [
                    'dayGroup' => '3',
                    'openPeriods' => '18:00'

                ]
            ],
            'remark'    => $this->buildSampleRemark(),
            'services'  => $this->buildSampleServiceTypes(),
        ];
        $this->assertEquals($array, $this->buildSampleServiceProvider()->toArray());
    }

    public function testToArrayPackstation()
    {
        $array = [
            'type'      => 'Packstation',
            'id'        => '123',
            'number'    => 456,
            'address'   => [
                'street'   => 'Elbestr.',
                'streetNo' => '28',
                'zip'      => '12045',
                'city'     => 'Berlin',
                'district' => 'Neukölln',
                'country'  => 'DEU',
                'countryIso2Code'  => 'DE',
                'countryId' => '',
            ],
            'location'  => [
                'latitude'  => 52.484766,
                'longitude' => 13.440547,
                'distance'  => 0,
            ],
            'timetable' => [
                '1' => [],
                '2' => [],
                '3' => ['18:00'],
                '4' => [],
                '5' => [],
                '6' => [],
                '7' => [],
            ],
            'groupedTimetable' => [
                1 => [
                    'dayGroup' => '1, 2, 4 - 7',
                    'openPeriods' => ''
                ],
                2 => [
                    'dayGroup' => '3',
                    'openPeriods' => '18:00'

                ]
            ],
            'remark'    => $this->buildSampleRemark(),
            'services'  => $this->buildSampleServiceTypes(),
        ];
        $this->assertEquals($array, $this->buildSamplePackstation()->toArray());
    }

    public function testToArrayPaketshop()
    {
        $array = [
            'type'      => 'Paketshop',
            'name'      => 'Unter der Brücke',
            'id'        => '123',
            'number'    => 456,
            'address'   => [
                'street'   => 'Elbestr.',
                'streetNo' => '28',
                'zip'      => '12045',
                'city'     => 'Berlin',
                'district' => 'Neukölln',
                'country'  => 'DEU',
                'countryIso2Code'  => 'DE',
                'countryId' => '',
            ],
            'location'  => [
                'latitude'  => 52.484766,
                'longitude' => 13.440547,
                'distance'  => 0,
            ],
            'timetable' => [
                '1' => [],
                '2' => [],
                '3' => ['18:00'],
                '4' => [],
                '5' => [],
                '6' => [],
                '7' => [],
            ],
            'groupedTimetable' => [
                1 => [
                    'dayGroup' => '1, 2, 4 - 7',
                    'openPeriods' => ''
                ],
                2 => [
                    'dayGroup' => '3',
                    'openPeriods' => '18:00'

                ]
            ],
            'remark'    => $this->buildSampleRemark(),
            'services'  => $this->buildSampleServiceTypes(),
        ];
        $this->assertEquals($array, $this->buildSamplePaketshop()->toArray());
    }

    public function testToArrayPostfiliale()
    {
        $array = [
            'type'      => 'Filiale',
            'name'      => 'Am Bahnhof',
            'id'        => '123',
            'number'    => 456,
            'address'   => [
                'street'   => 'Elbestr.',
                'streetNo' => '28',
                'zip'      => '12045',
                'city'     => 'Berlin',
                'district' => 'Neukölln',
                'country'  => 'DEU',
                'countryIso2Code'  => 'DE',
                'countryId' => '',
            ],
            'location'  => [
                'latitude'  => 52.484766,
                'longitude' => 13.440547,
                'distance'  => 0,
            ],
            'timetable' => [
                '1' => [],
                '2' => [],
                '3' => ['18:00'],
                '4' => [],
                '5' => [],
                '6' => [],
                '7' => [],
            ],
            'groupedTimetable' => [
                1 => [
                    'dayGroup' => '1, 2, 4 - 7',
                    'openPeriods' => ''
                ],
                2 => [
                    'dayGroup' => '3',
                    'openPeriods' => '18:00'

                ]
            ],
            'remark'    => $this->buildSampleRemark(),
            'services'  => $this->buildSampleServiceTypes(),
        ];
        $this->assertEquals($array, $this->buildSamplePostfiliale()->toArray());
    }

    public function testPackstation()
    {
        $this->assertEquals(456, $this->buildSamplePackstation()->getNumber());
    }

    public function testPostfiliale()
    {
        $this->assertEquals(456, $this->buildSamplePostfiliale()->getNumber());
    }

    public function testPaketshop()
    {
        $this->assertEquals(456, $this->buildSamplePaketshop()->getNumber());
    }

    /**
     * @return Timetable
     */
    protected function buildSampleTimetable()
    {
        $timetable = new Timetable();
        $timetable->enter(new PointInTime(new Time(18, 0), 2), 3);
        return $timetable;
    }

    protected function buildSampleServiceTypes()
    {
        return [
            ServiceType::create(ServiceType::PARCEL_ACCEPTANCE),
            ServiceType::create(ServiceType::PARCEL_PICKUP),
        ];
    }

    protected function buildSampleRemark()
    {
        return ['de' => 'Bemerkung', 'en' => 'Remark'];
    }

    /**
     * @return ServiceInformation
     */
    protected function buildSampleServiceInformation()
    {
        return new ServiceInformation(
            $this->buildSampleTimetable(),
            $this->buildSampleServiceTypes(),
            $this->buildSampleRemark()
        );
    }

    public function testConstructorInjection()
    {
        $serviceProvider = $this->buildSampleServiceProvider();
        $this->assertEquals($this->buildSampleAddress(), $serviceProvider->getAddress());
        $this->assertEquals($this->buildSampleLocation(), $serviceProvider->getLocation());
        $this->assertEquals($this->buildSampleTimetable(), $serviceProvider->getTimetable());
        $this->assertEquals(123, $serviceProvider->getId());
        $this->assertEquals(456, $serviceProvider->getNumber());
    }

    public function testFilteringTimetable()
    {
        $serviceProvider = $this->buildSampleServiceProvider();
        $serviceProvider->filterTimetable(1);
        $this->assertEmpty($serviceProvider->getTimetable()->toArray()[3]);
    }

    /**
     * @return Address
     */
    protected function buildSampleAddress()
    {
        return $this->buildAddress('Elbestr.', '28', '12045', 'Berlin', 'Neukölln');
    }

    /**
     * @return Location
     */
    protected function buildSampleLocation()
    {
        return new Location(new Coordinates(52.484766, 13.440547), 0);
    }

    /**
     * @return Packstation
     */
    protected function buildSamplePackstation()
    {
        $address = $this->buildSampleAddress();
        $location = $this->buildSampleLocation();
        $serviceInformation = $this->buildSampleServiceInformation();
        return new Packstation('123', 456, $address, $location, $serviceInformation);
    }

    /**
     * @return Paketshop
     */
    protected function buildSamplePaketshop()
    {
        $address = $this->buildSampleAddress();
        $location = $this->buildSampleLocation();
        $serviceInformation = $this->buildSampleServiceInformation();
        return new Paketshop('123', 456, 'Unter der Brücke', $address, $location, $serviceInformation);
    }

    /**
     * @return Filiale
     */
    protected function buildSamplePostfiliale()
    {
        $address = $this->buildSampleAddress();
        $location = $this->buildSampleLocation();
        $serviceInformation = $this->buildSampleServiceInformation();
        return new Filiale('123', 456, 'Am Bahnhof', $address, $location, $serviceInformation);
    }

    /**
     * @return BasicServiceProvider
     */
    protected function buildSampleServiceProvider()
    {
        $address = $this->buildAddress('Elbestr.', '28', '12045', 'Berlin', 'Neukölln');
        $location = new Location(new Coordinates(52.484766, 13.440547), 0);
        $serviceInformation = $this->buildSampleServiceInformation();
        $serviceProvider = new BasicServiceProvider('123', 456, $address, $location, $serviceInformation);
        return $serviceProvider;
    }

}
