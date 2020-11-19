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


class StandortsucheTest extends \PHPUnit_Framework_TestCase
{
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

    public function testGettingParcelLocationByAddress()
    {
        $standortsuche = $this->buildStandortsuche();
        $address = $this->buildSampleAddress();
        $list = $standortsuche->getParcellocationByAddress($address);
        $this->assertNotEmpty($list->toArray());
    }

    public function testGettingParcelLocationByAdressZipCity()
    {
        $standortsuche = $this->buildStandortsuche();
        $address = $this->buildSampleAddress();
        $list = $standortsuche->getParcellocationByAddress(
            $address->getStreet() . ' ' . $address->getStreetNo(),
            $address->getZip(),
            $address->getCity()
        );
        $this->assertNotEmpty($list->toArray());
    }

    public function testThatThereANoResultsInCaseOfAnEmptyAddress()
    {
        $emptyAddress = new Address('', '', '', '', '', '');
        $serviceProviders = $this
            ->buildStandortsuche()
            ->getParcellocationByAddress($emptyAddress);
        $this->assertEmpty($serviceProviders->toArray());
    }
}
