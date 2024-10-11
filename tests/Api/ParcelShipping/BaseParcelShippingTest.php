<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\ParcelShipping;


use Mediaopt\DHL\Api\ParcelShipping\Model\Shipment;
use Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentDetails;
use Mediaopt\DHL\Api\ParcelShipping\Model\Shipper;
use Mediaopt\DHL\Api\ParcelShipping\Model\Weight;
use Mediaopt\DHL\Export\CsvExporter;
use Mediaopt\DHL\Shipment\BillingNumber;
use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;
use PHPUnit\Framework\TestCase;

/**
 * @author Mediaopt GmbH
 */
class BaseParcelShippingTest extends TestCase
{

    /**
     * @return \Mediaopt\DHL\Api\ParcelShipping\Client
     */
    protected function buildParcelShipping()
    {
        return (new \TestConfigurator())->buildParcelShipping();
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
        $receiver = [
            'name1'         => 'a b',
            'contactName'   => 'a b',
            'phone'         => '030123',
            'email'         => 'a@b.de',
            'city'          => 'Berlin',
            'postalCode'    => '12045',
            'addressStreet' => 'Elbestr.',
            'addressHouse'  => '28/29',
            'country'       => 'DEU',
        ];
        $shipper = (new Shipper())->setName1('a b')->setAddressStreet('Elbestr.')->setAddressHouse('28')->setPostalCode('12045')->setCity('Berlin')->setCountry('DEU');
        $shipment = new Shipment();
        $shipment->setShipper($shipper);
        $shipment->setConsignee($receiver);
        $shipmentDetails = new ShipmentDetails();
        $weight = new Weight();
        $weight->setUom('kg');
        $weight->setValue(12);
        $shipmentDetails->setWeight($weight);
        $shipment->setDetails($shipmentDetails);
        $shipment->setCreationSoftware(CsvExporter::CREATOR_TAG);
        $shipment->setBillingNumber(new BillingNumber(Ekp::build('3333333333'), Process::build(Process::PAKET), Participation::build('01')));
        $shipment->setProduct($product);
        $shipment->setRefNo('Bestellnr. 123');
        $shipment->setShipDate((new \DateTime()));
        return $shipment;
    }

    /**
     * @param string $product
     * @return Shipment
     */
    protected function createShipmentToAustria($product = 'V01PAK'): Shipment
    {
        $shipment = $this->createShipmentToGermany($product);
        $receiver = $shipment->getConsignee();
        $receiver['country'] = 'AUT';
        $shipment->setConsignee($receiver);
        return $shipment;
    }

    protected function buildQueryParams(): array
    {
        return [
            'includeDocs' => 'URL',
            'combine'     => false,
            'mustEncode'  => false,
        ];
    }

    public function testDummy()
    {
        $this->assertTrue(true);
    }
}
