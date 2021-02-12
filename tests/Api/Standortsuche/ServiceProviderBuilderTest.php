<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 Mediaopt GmbH
 */

namespace sdk\Standortsuche;


use Mediaopt\DHL\Api\Standortsuche\ServiceProviderBuilder;
use Mediaopt\DHL\Api\Standortsuche\TimetableBuilder;
use Mediaopt\DHL\Exception\ServiceProviderException;
use Mediaopt\DHL\ServiceProvider\Filiale;
use Mediaopt\DHL\ServiceProvider\Packstation;
use Mediaopt\DHL\ServiceProvider\Paketshop;
use Mediaopt\DHL\ServiceProvider\ServiceType;
use Mediaopt\DHL\ServiceProvider\Timetable\Timetable;

class ServiceProviderBuilderTest extends \PHPUnit_Framework_TestCase
{

    public function buildSamplePackstation()
    {
        $json = '{"countryCode":"de","zipCode":"12045","city":"Berlin","district":"Neukölln","additionalInfo":null,
            "area":null,"street":"Sonnenallee","houseNo":"113","additionalStreet":null,"format1":"csbn7s8n2s3",
            "format2":"csbn2s3n1","routingCode":null,"keyWord":"DHL Packstation","partnerType":"external",
            "shopType":"packStation","shopName":null,"primaryLanguage":"de","secondaryLanguage":null,"tertiaryLanguage":null,
            "geoPosition":{"latitude":52.4813806,"longitude":13.4412213,"distance":1},
            "primaryKeyDeliverySystem":"412045103","primaryKeyZipRegion":"103","systemID":"8007","primaryKeyPSF":"8007-412045103","psfFiles":[],
            "psfServicetypes":["parcelpickup","parcelacceptance"],"psfClosureperiods":[],
            "psfWelcometexts":[{"language":"de","content":"Standorthinweis:#br#Aral-Tankstelle, Rückseite"},
            {"language":"en","content":"We are delighted that you would like to use our Packstation service.#br##br#- Your DHL team"}],
            "openingHours":[
            {"opens":"00:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Monday"},
            {"opens":"00:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Tuesday"},
            {"opens":"00:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Wednesday"},
            {"opens":"00:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Thursday"},
            {"opens":"00:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Friday"},
            {"opens":"00:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Saturday"},
            {"opens":"00:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Sunday"}]}';
        return json_decode($json);
    }

    public function buildSamplePostfiliale()
    {
        $json = '{"countryCode":"de","zipCode":"12043","city":"Berlin","district":"Neuk\u00f6lln","additionalInfo":null,
            "area":null,"street":"Erkstr.","houseNo":"5","additionalStreet":null,"format1":"csbnan7s8n2s3",
            "format2":"csbn2s3n1","routingCode":null,"keyWord":"Postfiliale","partnerType":"external",
            "shopType":"postOffice","shopName":"Getr\u00e4nke-Tabakwaren-Zeitschriften","primaryLanguage":"de","secondaryLanguage":null,"tertiaryLanguage":null,
            "geoPosition":{"latitude":52.481035,"longitude":13.4370483,"distance":478},
            "primaryKeyDeliverySystem":"4116371","primaryKeyZipRegion":"556","systemID":"8003","primaryKeyPSF":"8003-4116371","psfFiles":[],
            "psfServicetypes":["handicappedAccess","parcelacceptance","parcelpickup","parking"],"psfClosureperiods":[],
            "psfWelcometexts":[{},{"language":"de"},{"content":"foo"}],
            "openingHours":[
            {"opens":"07:00:00","closes":"18:00:00","dayOfWeek":"http://schema.org/Monday"},
            {"opens":"07:00:00","closes":"18:00:00","dayOfWeek":"http://schema.org/Tuesday"},
            {"opens":"07:00:00","closes":"18:00:00","dayOfWeek":"http://schema.org/Wednesday"},
            {"opens":"07:00:00","closes":"18:00:00","dayOfWeek":"http://schema.org/Thursday"},
            {"opens":"07:00:00","closes":"18:00:00","dayOfWeek":"http://schema.org/Friday"},
            {"opens":"08:00:00","closes":"13:00:00","dayOfWeek":"http://schema.org/Saturday"}]}';
        return json_decode($json);
    }

    public function buildSamplePaketshop()
    {
        $json = '{"countryCode":"de","zipCode":"12045","city":"Berlin","district":"Neuk\u00f6lln","additionalInfo":"DHL Paketshop",
            "area":null,"street":"Finowstr.","houseNo":"9","additionalStreet":null,"format1":"5sbnan7s8n2s3",
            "format2":"csbn2s3n1","routingCode":null,"keyWord":"Postfiliale","partnerType":"external",
            "shopType":"parcelShop","shopName":"Kiosk Backshop Tunc","primaryLanguage":"de","secondaryLanguage":null,
            "tertiaryLanguage":null,"geoPosition":{"latitude":52.4823116,"longitude":13.4432779,"distance":330},
            "primaryKeyDeliverySystem":"4096851","primaryKeyZipRegion":"443","systemID":"8003",
            "primaryKeyPSF":"8003-4096851","psfFiles":[],"psfServicetypes":["parcelacceptance","parcelpickup"],
            "psfClosureperiods":[],"psfWelcometexts":[],
            "openingHours":[
            {"opens":"09:00:00","closes":"18:00:00","dayOfWeek":"http://schema.org/Monday"},
            {"opens":"09:00:00","closes":"18:00:00","dayOfWeek":"http://schema.org/Tuesday"},
            {"opens":"09:00:00","closes":"18:00:00","dayOfWeek":"http://schema.org/Wednesday"},
            {"opens":"09:00:00","closes":"18:00:00","dayOfWeek":"http://schema.org/Thursday"},
            {"opens":"09:00:00","closes":"18:00:00","dayOfWeek":"http://schema.org/Friday"},
            {"opens":"09:00:00","closes":"15:30:00","dayOfWeek":"http://schema.org/Saturday"}]}';
        return json_decode($json);
    }

    public function testThatBuildingUsingAnObjectWithAnUnknownShopTypeLeadsToAnException()
    {
        $builder = new ServiceProviderBuilder();
        $objectWithInvalidShopType = new \stdClass();
        $objectWithInvalidShopType->shopType = 'unknown';
        $this->expectException(ServiceProviderException::class);
        $builder->build($objectWithInvalidShopType);
    }

    public function testThatBuildingIgnoresUnknownServiceTypes()
    {
        $builder = new ServiceProviderBuilder();
        $sample = $this->buildSamplePackstation();
        $sample->psfServicetypes[] = 'invalidServiceType';
        $packstation = $builder->build($sample);
        $this->assertCount(2, $packstation->getServiceTypes());
    }

    public function testThatBuildingATimetableWithInvalidDayYieldsAnEmptyTimetable()
    {
        $builder = new ServiceProviderBuilder();
        $sample = $this->buildSamplePackstation();
        $sample->openingHours[2]->dayOfWeek = 'potato';
        $packstation = $builder->build($sample);
        $this->assertEquals(
            [
                Timetable::MONDAY => ['0:00-24:00'],
                Timetable::TUESDAY => ['0:00-24:00'],
                Timetable::WEDNESDAY => [],
                Timetable::THURSDAY => ['0:00-24:00'],
                Timetable::FRIDAY => ['0:00-24:00'],
                Timetable::SATURDAY => ['0:00-24:00'],
                Timetable::SUNDAY => ['0:00-24:00'],
            ],
            $packstation->getTimetable()->toArray()
        );
    }

    public function testThatBuildingATimetableWithInvalidTimeYieldsAnEmptyTimetable()
    {
        $builder = new ServiceProviderBuilder();
        $sample = $this->buildSamplePackstation();
        $sample->openingHours[3]->opens = '25:00';
        $sample->openingHours[3]->closes = '42:00';
        $packstation = $builder->build($sample);
        $this->assertEquals(
            [
                Timetable::MONDAY => [],
                Timetable::TUESDAY => [],
                Timetable::WEDNESDAY => [],
                Timetable::THURSDAY => [],
                Timetable::FRIDAY => [],
                Timetable::SATURDAY => [],
                Timetable::SUNDAY => [],
            ],
            $packstation->getTimetable()->toArray()
        );
    }

    public function testThatBuildingWithAllKnownServiceTypesIgnoresNoneOfThem()
    {
        $builder = new ServiceProviderBuilder();
        $sample = $this->buildSamplePackstation();
        $sample->psfServicetypes = array_keys(ServiceProviderBuilder::$API_SERVICE_TYPE_MAPPING);
        $packstation = $builder->build($sample);
        $this->assertCount(count(ServiceProviderBuilder::$API_SERVICE_TYPE_MAPPING), $packstation->getServiceTypes());
        foreach ($packstation->getServiceTypes() as $serviceType) {
            $this->assertContains($serviceType->getName(), ServiceProviderBuilder::$API_SERVICE_TYPE_MAPPING);
        }
    }

    public function testBuildingAPackstation()
    {
        $sample = $this->buildSamplePackstation();
        $timetableBuilderMock = $this
            ->getMockBuilder(TimetableBuilder::class)
            ->setMethods(['build'])
            ->getMock();
        $timetableBuilderMock
            ->expects($this->once())
            ->method('build')
            ->with($sample->openingHours)
            ->willReturn(new Timetable());

        $builder = new ServiceProviderBuilder($timetableBuilderMock);
        $packstation = $builder->build($sample);
        $this->assertInstanceOf(Packstation::class, $packstation);
        /** @var Packstation $packstation */
        $this->assertEquals(103, $packstation->getNumber());
        $this->assertEquals('8007-412045103', $packstation->getId());
        $this->assertEquals('Sonnenallee', $packstation->getAddress()->getStreet());
        $this->assertEquals('113', $packstation->getAddress()->getStreetNo());
        $this->assertEquals('12045', $packstation->getAddress()->getZip());
        $this->assertEquals('Berlin', $packstation->getAddress()->getCity());
        $this->assertEquals('Neukölln', $packstation->getAddress()->getDistrict());
        $this->assertEquals('de', $packstation->getAddress()->getCountry());
        $this->assertLessThan(0.0001, abs($packstation->getLocation()->getCoordinates()->getLatitude() - 52.4813806));
        $this->assertLessThan(0.0001, abs($packstation->getLocation()->getCoordinates()->getLongitude() - 13.4412213));
        $this->assertEquals(1, $packstation->getLocation()->getDistance());
        $serviceTypes = [ServiceType::PARCEL_ACCEPTANCE, ServiceType::PARCEL_PICKUP];
        $this->assertCount(2, $packstation->getServiceTypes());
        foreach ($packstation->getServiceTypes() as $serviceType) {
            $this->assertContains($serviceType->getName(), $serviceTypes);
        }
        $this->assertEquals('Standorthinweis:<br>Aral-Tankstelle, Rückseite', $packstation->getServiceInformation()->getRemark('de'));
    }

    public function testBuildingAPaketshop()
    {
        $sample = $this->buildSamplePaketshop();
        $timetableBuilderMock = $this
            ->getMockBuilder(TimetableBuilder::class)
            ->setMethods(['build'])
            ->getMock();
        $timetableBuilderMock
            ->expects($this->once())
            ->method('build')
            ->with($sample->openingHours)
            ->willReturn(new Timetable());

        $builder = new ServiceProviderBuilder($timetableBuilderMock);
        $paketshop = $builder->build($sample);
        $this->assertInstanceOf(Paketshop::class, $paketshop);
        /** @var Paketshop $paketshop */
        $this->assertEquals(443, $paketshop->getNumber());
        $this->assertEquals('8003-4096851', $paketshop->getId());
        $this->assertEquals('Kiosk Backshop Tunc', $paketshop->getName());
        $this->assertEquals('Finowstr.', $paketshop->getAddress()->getStreet());
        $this->assertEquals('9', $paketshop->getAddress()->getStreetNo());
        $this->assertEquals('12045', $paketshop->getAddress()->getZip());
        $this->assertEquals('Berlin', $paketshop->getAddress()->getCity());
        $this->assertEquals('Neukölln', $paketshop->getAddress()->getDistrict());
        $this->assertEquals('de', $paketshop->getAddress()->getCountry());
        $this->assertLessThan(0.0001, abs($paketshop->getLocation()->getCoordinates()->getLatitude() - 52.4823116));
        $this->assertLessThan(0.0001, abs($paketshop->getLocation()->getCoordinates()->getLongitude() - 13.4432779));
        $this->assertEquals(330, $paketshop->getLocation()->getDistance());
        $serviceTypes = [ServiceType::PARCEL_ACCEPTANCE, ServiceType::PARCEL_PICKUP];
        $this->assertCount(2, $paketshop->getServiceTypes());
        foreach ($paketshop->getServiceTypes() as $serviceType) {
            $this->assertContains($serviceType->getName(), $serviceTypes);
        }
    }

    public function testBuildingAPostfiliale()
    {
        $sample = $this->buildSamplePostfiliale();
        $timetableBuilderMock = $this
            ->getMockBuilder(TimetableBuilder::class)
            ->setMethods(['build'])
            ->getMock();
        $timetableBuilderMock
            ->expects($this->once())
            ->method('build')
            ->with($sample->openingHours)
            ->willReturn(new Timetable());

        $builder = new ServiceProviderBuilder($timetableBuilderMock);
        $postfiliale = $builder->build($sample);
        $this->assertInstanceOf(Filiale::class, $postfiliale);
        /** @var Filiale $postfiliale */
        $this->assertEquals(556, $postfiliale->getNumber());
        $this->assertEquals('8003-4116371', $postfiliale->getId());
        $this->assertEquals('Getränke-Tabakwaren-Zeitschriften', $postfiliale->getName());
        $this->assertEquals('Erkstr.', $postfiliale->getAddress()->getStreet());
        $this->assertEquals('5', $postfiliale->getAddress()->getStreetNo());
        $this->assertEquals('12043', $postfiliale->getAddress()->getZip());
        $this->assertEquals('Berlin', $postfiliale->getAddress()->getCity());
        $this->assertEquals('Neukölln', $postfiliale->getAddress()->getDistrict());
        $this->assertEquals('de', $postfiliale->getAddress()->getCountry());
        $this->assertLessThan(0.0001, abs($postfiliale->getLocation()->getCoordinates()->getLatitude() - 52.481035));
        $this->assertLessThan(0.0001, abs($postfiliale->getLocation()->getCoordinates()->getLongitude() - 13.4370483));
        $this->assertEquals(478, $postfiliale->getLocation()->getDistance());
        $serviceTypes = [
            ServiceType::HANDICAPPED_ACCESS,
            ServiceType::PARCEL_ACCEPTANCE,
            ServiceType::PARCEL_PICKUP,
            ServiceType::PARKING
        ];
        $this->assertCount(4, $postfiliale->getServiceTypes());
        foreach ($postfiliale->getServiceTypes() as $serviceType) {
            $this->assertContains($serviceType->getName(), $serviceTypes);
        }
    }

}
