<?php

use Mediaopt\DHL\Address\Address;
use Mediaopt\DHL\ServiceProvider\BasicServiceProvider;
use Mediaopt\DHL\ServiceProvider\Coordinates;
use Mediaopt\DHL\ServiceProvider\Filiale;
use Mediaopt\DHL\ServiceProvider\Location;
use Mediaopt\DHL\ServiceProvider\Packstation;
use Mediaopt\DHL\ServiceProvider\Paketshop;
use Mediaopt\DHL\ServiceProvider\ServiceInformation;
use Mediaopt\DHL\ServiceProvider\ServiceProviderList;
use Mediaopt\DHL\ServiceProvider\Timetable\Timetable;

class ServiceProviderListTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var int
     */
    const NUMBER_OF_PACKSTATIONS = 10;

    /**
     * @var int
     */
    const NUMBER_OF_FILIALES = 9;

    /**
     * @var int
     */
    const NUMBER_OF_PAKETSHOPS = 5;

    /**
     * @param int $length
     * @return ServiceProviderList
     */
    protected function buildServiceProviderListWithRandomDistance($length)
    {
        $serviceProviders = [];
        for ($i = 0; $i < $length; $i++) {
            $serviceProviders[] = $this->buildServiceProviderWithRandomDistance();
        }
        return new ServiceProviderList($serviceProviders);
    }

    protected function buildServiceProviderWithRandomDistance()
    {
        $address = new Address('Elbestr.', '28', '12045', 'Berlin', 'Neukölln');
        $location = new Location(new Coordinates(52.481380600000001, 13.4412213), mt_rand(1, 10000));
        $serviceInformation = new ServiceInformation(new Timetable(), []);
        return new BasicServiceProvider((string)mt_rand(), mt_rand(), $address, $location, $serviceInformation);
    }

    public function testThatAServiceProviderListIsSorted()
    {
        $serviceProviderList = $this->buildServiceProviderListWithRandomDistance(100);
        $serviceProviders = $serviceProviderList->toArray();
        $numberOfServiceProviders = count($serviceProviders);
        for ($i = 0; $i + 1 < $numberOfServiceProviders; $i++) {
            $distanceOfCurrent = $serviceProviders[$i]->getLocation()->getDistance();
            $distanceOfNext = $serviceProviders[$i + 1]->getLocation()->getDistance();
            $this->assertTrue($distanceOfCurrent <= $distanceOfNext);
        }
    }

    public function testMergingTwoLists()
    {
        $additionalList = $this->buildServiceProviderListWithRandomDistance(mt_rand(10, 30));
        $mainList = $this->buildServiceProviderListWithRandomDistance(mt_rand(10, 30));
        $serviceProviders = array_merge($mainList->toArray(), $additionalList->toArray());

        $mainList->merge($additionalList);
        foreach ($mainList->toArray() as $serviceProviderInUnion) {
            $found = false;
            foreach ($serviceProviders as $serviceProviderInEitherList) {
                /** @noinspection TypeUnsafeComparisonInspection */
                if ($serviceProviderInUnion == $serviceProviderInEitherList) {
                    $found = true;
                    break;
                }
            }
            $this->assertTrue($found);
        }
    }

    public function testFilteringPackstation()
    {
        $serviceProviderList = $this->buildSampleServiceProviderList();
        $this->assertCount(self::NUMBER_OF_PACKSTATIONS, $serviceProviderList->filterPackstation()->toArray());
    }

    public function testFilteringPaketshop()
    {
        $serviceProviderList = $this->buildSampleServiceProviderList();
        $this->assertCount(self::NUMBER_OF_PAKETSHOPS, $serviceProviderList->filterPaketshop()->toArray());
    }

    public function testFilteringFiliale()
    {
        $serviceProviderList = $this->buildSampleServiceProviderList();
        $this->assertCount(self::NUMBER_OF_FILIALES, $serviceProviderList->filterFiliale()->toArray());
    }

    protected function buildSampleServiceProviderList()
    {
        $packstations = $this->buildSamplePackstations(self::NUMBER_OF_PACKSTATIONS);
        $filiales = $this->buildSampleFiliales(self::NUMBER_OF_FILIALES);
        $paketshops = $this->buildSamplePaketshops(self::NUMBER_OF_PAKETSHOPS);
        $serviceProviders = array_merge($packstations, $filiales, $paketshops);
        /** @noinspection NonSecureShuffleUsageInspection */
        shuffle($serviceProviders);
        return new ServiceProviderList($serviceProviders);
    }

    public function testCombinedFilteringWithNothing()
    {
        $serviceProviders = $this->buildSampleServiceProviderList()->toArray();
        $expectedProviderList = new ServiceProviderList([]);
        $actualProviders = (new ServiceProviderList($serviceProviders))->filter(false, false, false);
        $this->assertEquals($expectedProviderList->toArray(), $actualProviders->toArray());
    }

    public function testCombinedFilteringWithPackstation()
    {
        $serviceProviders = $this->buildSampleServiceProviderList()->toArray();
        $expectedProviderList = new ServiceProviderList([]);
        $expectedProviderList->merge((new ServiceProviderList($serviceProviders))->filterPackstation());
        $actualProviders = (new ServiceProviderList($serviceProviders))->filter(true, false, false);
        $this->assertEquals($expectedProviderList->toArray(), $actualProviders->toArray());
    }

    public function testCombinedFilteringWithPackstationAndFiliale()
    {
        $serviceProviders = $this->buildSampleServiceProviderList()->toArray();
        $expectedProviderList = new ServiceProviderList([]);
        $expectedProviderList->merge((new ServiceProviderList($serviceProviders))->filterPackstation());
        $expectedProviderList->merge((new ServiceProviderList($serviceProviders))->filterFiliale());
        $actualProviders = (new ServiceProviderList($serviceProviders))->filter(true, true, false);
        $this->assertEquals($expectedProviderList->toArray(), $actualProviders->toArray());
    }

    public function testCombinedFilteringWithPackstationAndPaketshop()
    {
        $serviceProviders = $this->buildSampleServiceProviderList()->toArray();
        $expectedProviderList = new ServiceProviderList([]);
        $expectedProviderList->merge((new ServiceProviderList($serviceProviders))->filterPackstation());
        $expectedProviderList->merge((new ServiceProviderList($serviceProviders))->filterPaketshop());
        $actualProviders = (new ServiceProviderList($serviceProviders))->filter(true, false, true);
        $this->assertEquals($expectedProviderList->toArray(), $actualProviders->toArray());
    }

    public function testCombinedFilteringWithPackstationAndFilialeAndPaketshop()
    {
        $serviceProviders = $this->buildSampleServiceProviderList()->toArray();
        $expectedProviderList = new ServiceProviderList([]);
        $expectedProviderList->merge((new ServiceProviderList($serviceProviders))->filterPackstation());
        $expectedProviderList->merge((new ServiceProviderList($serviceProviders))->filterFiliale());
        $expectedProviderList->merge((new ServiceProviderList($serviceProviders))->filterPaketshop());
        $actualProviders = (new ServiceProviderList($serviceProviders))->filter(true, true, true);
        $this->assertCount(count($expectedProviderList->toArray()), $actualProviders->toArray());
        $this->assertEquals($expectedProviderList->toArray(), $actualProviders->toArray());
    }

    public function testCombinedFilteringWithFiliale()
    {
        $serviceProviders = $this->buildSampleServiceProviderList()->toArray();
        $expectedProviderList = new ServiceProviderList([]);
        $expectedProviderList->merge((new ServiceProviderList($serviceProviders))->filterFiliale());
        $actualProviders = (new ServiceProviderList($serviceProviders))->filter(false, true, false);
        $this->assertEquals($expectedProviderList->toArray(), $actualProviders->toArray());
    }

    public function testCombinedFilteringWithFilialeAndPaketshop()
    {
        $serviceProviders = $this->buildSampleServiceProviderList()->toArray();
        $expectedProviderList = new ServiceProviderList([]);
        $expectedProviderList->merge((new ServiceProviderList($serviceProviders))->filterFiliale());
        $expectedProviderList->merge((new ServiceProviderList($serviceProviders))->filterPaketshop());
        $actualProviders = (new ServiceProviderList($serviceProviders))->filter(false, true, true);
        $this->assertEquals($expectedProviderList->toArray(), $actualProviders->toArray());
    }

    public function testCombinedFilteringWithPaketshop()
    {
        $serviceProviders = $this->buildSampleServiceProviderList()->toArray();
        $expectedProviderList = new ServiceProviderList([]);
        $expectedProviderList->merge((new ServiceProviderList($serviceProviders))->filterPaketshop());
        $actualProviders = (new ServiceProviderList($serviceProviders))->filter(false, false, true);
        $this->assertEquals($expectedProviderList->toArray(), $actualProviders->toArray());
    }

    /**
     * @param int $count
     * @return array
     */
    protected function buildSamplePackstations($count)
    {
        $packstations = [];
        for ($i = 0; $i < $count; $i++) {
            $sample = $this->buildServiceProviderWithRandomDistance();
            $packstation = new Packstation(
                $sample->getId(),
                mt_rand(1, 1000),
                $sample->getAddress(),
                $sample->getLocation(),
                $sample->getServiceInformation()
            );
            $packstations[] = $packstation;
        }
        return $packstations;
    }

    /**
     * @param int $count
     * @return array
     */
    protected function buildSampleFiliales($count)
    {
        $filiales = [];
        for ($i = 0; $i < $count; $i++) {
            $sample = $this->buildServiceProviderWithRandomDistance();
            $filiales[] = new Filiale(
                $sample->getId(),
                mt_rand(1, 1000),
                'Postfiliale ' . mt_rand(1, 100),
                $sample->getAddress(),
                $sample->getLocation(),
                $sample->getServiceInformation()
            );
        }
        return $filiales;
    }

    /**
     * @param int $count
     * @return array
     */
    protected function buildSamplePaketshops($count)
    {
        $paketshops = [];
        for ($i = 0; $i < $count; $i++) {
            $sample = $this->buildServiceProviderWithRandomDistance();
            $paketshops[] = new Paketshop(
                $sample->getId(),
                mt_rand(1, 1000),
                'Paketshop ' . mt_rand(1, 100),
                $sample->getAddress(),
                $sample->getLocation(),
                $sample->getServiceInformation()
            );
        }
        return $paketshops;
    }
}
