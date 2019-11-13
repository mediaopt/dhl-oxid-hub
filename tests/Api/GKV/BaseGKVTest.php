<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\GKV;

use Mediaopt\DHL\Api\GKV\CountryType;
use Mediaopt\DHL\Api\GKV\NameType;
use Mediaopt\DHL\Api\GKV\NativeAddressType;
use Mediaopt\DHL\Api\GKV\ReceiverNativeAddressType;
use Mediaopt\DHL\Api\GKV\ReceiverType;
use Mediaopt\DHL\Api\GKV\Shipment;
use Mediaopt\DHL\Api\GKV\ShipmentDetailsTypeType;
use Mediaopt\DHL\Api\GKV\ShipmentItemType;
use Mediaopt\DHL\Api\GKV\ShipperType;
use Mediaopt\DHL\Api\GKV\Version;

/**
 * @author Mediaopt GmbH
 */
class BaseGKVTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return \Mediaopt\DHL\Api\GKV
     */
    protected function buildGKV()
    {
        return (new \TestConfigurator())->buildGKV();
    }

    /**
     * @return string
     */
    protected function getUniqueShipmentId()
    {
        return '22220104' . substr(uniqid(), 0, 6);
    }

    /**
     * @param string $product
     * @return Shipment
     */
    protected function createShipmentToGermany($product = 'V01PAK'): Shipment
    {
        $ShipmentDetails = new ShipmentDetailsTypeType($product, '22222222220101', (new \DateTime())->format('Y-m-d'), new ShipmentItemType(12));
        $Receiver = (new ReceiverType('a b'))->setAddress(new ReceiverNativeAddressType(null, null, 'Elbestr.', '28/29', '12045', 'Berlin', null, new CountryType('DE')));
        $Shipper = (new ShipperType(new NameType('a b', null, null), new NativeAddressType('Elbestr.', '28', '12045', 'Berlin', null, new CountryType('DE'))));
        $shipment = new Shipment($ShipmentDetails, $Shipper, $Receiver);
        return $shipment;
    }

    /**
     * @param string $product
     * @return Shipment
     */
    protected function createShipmentToAustria($product = 'V01PAK'): Shipment
    {
        $ShipmentDetails = new ShipmentDetailsTypeType($product, '22222222220101', (new \DateTime())->format('Y-m-d'), new ShipmentItemType(12));
        $Receiver = (new ReceiverType('a b'))->setAddress(new ReceiverNativeAddressType(null, null, 'Dr.-Rudolf-Tyrolt-Gasse', '124-122', '8786', 'Rottenmann', null, new CountryType('AT')));
        $Shipper = (new ShipperType(new NameType('a b', null, null), new NativeAddressType('Elbestr.', '28', '12045', 'Berlin', null, new CountryType('DE'))));
        $shipment = new Shipment($ShipmentDetails, $Shipper, $Receiver);
        return $shipment;
    }

    /**
     * @return Version
     */
    protected function createVersion(): Version
    {
        return new Version(3, 0, null);
    }

    public function testDummy()
    {
        $this->assertTrue(true);
    }
}
