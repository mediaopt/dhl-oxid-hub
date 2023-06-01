<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 Mediaopt GmbH
 */

namespace sdk\ServiceProvider;


use Mediaopt\DHL\ServiceProvider\ServiceInformation;
use Mediaopt\DHL\ServiceProvider\ServiceType;
use Mediaopt\DHL\ServiceProvider\Timetable\Timetable;
use PhpUnit\Framework\TestCase;

class ServiceInformationTest extends TestCase
{

    public function testConstructorInjection()
    {
        $timetable = new Timetable();
        $serviceTypes = [
            ServiceType::create(ServiceType::PARCEL_ACCEPTANCE),
            ServiceType::create(ServiceType::PARCEL_PICKUP),
        ];
        $remark = ['de' => 'Bemerkung', 'en' => 'Remark'];
        $serviceInformation = new ServiceInformation($timetable, $serviceTypes, $remark);
        $this->assertSame($timetable, $serviceInformation->getTimetable());
        $this->assertEquals($serviceTypes, $serviceInformation->getServiceTypes());
        $this->assertEquals('Bemerkung', $serviceInformation->getRemark('de'));
        $this->assertEquals('Remark', $serviceInformation->getRemark('en'));
        $this->assertEquals($remark, $serviceInformation->getRemarkInEachLanguage());
    }

    public function testSetters()
    {
        $serviceInformation = new ServiceInformation(new Timetable(), []);
        $timetable = new Timetable();
        $serviceTypes = [
            ServiceType::create(ServiceType::PARCEL_ACCEPTANCE),
            ServiceType::create(ServiceType::PARCEL_PICKUP),
        ];
        $serviceInformation->setTimetable($timetable);
        $serviceInformation->setServiceTypes($serviceTypes);
        $serviceInformation->setRemark('de', 'Bemerkung');
        $this->assertSame($timetable, $serviceInformation->getTimetable());
        $this->assertEquals($serviceTypes, $serviceInformation->getServiceTypes());
        $this->assertEquals('Bemerkung', $serviceInformation->getRemark('de'));
        $this->assertEquals(['de' => 'Bemerkung'], $serviceInformation->getRemarkInEachLanguage());
    }

    public function testThatServiceTypesWillBeSortedWhenInjectedViaConstructor()
    {
        $serviceTypes = [
            ServiceType::create(ServiceType::PARCEL_PICKUP),
            ServiceType::create(ServiceType::PARCEL_ACCEPTANCE),
        ];
        $serviceInformation = new ServiceInformation(new Timetable(), $serviceTypes);
        $this->assertEquals([$serviceTypes[1], $serviceTypes[0]], $serviceInformation->getServiceTypes());
    }


    public function testThatServiceTypesWillBeSortedWhenInjectedViaSetter()
    {
        $serviceTypes = [
            ServiceType::create(ServiceType::PARCEL_PICKUP),
            ServiceType::create(ServiceType::PARCEL_ACCEPTANCE),
        ];
        $serviceInformation = new ServiceInformation(new Timetable(), []);
        $serviceInformation->setServiceTypes($serviceTypes);
        $this->assertEquals([$serviceTypes[1], $serviceTypes[0]], $serviceInformation->getServiceTypes());
    }

}
