<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\GKV;

require_once 'BaseGKVTest.php';

use Mediaopt\DHL\Adapter\ParcelShippingConverter;
use Mediaopt\DHL\Api\GKV\CountryType;
use Mediaopt\DHL\Api\GKV\ValidateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\ValidateShipmentOrderType;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Mediaopt GmbH
 */
class ValidateShipmentTest extends BaseGKVTest
{

    public function testValidateShipment()
    {
        $shipment = $this->createShipmentToGermany();
        $shipmentOrder = new ValidateShipmentOrderType('123', $shipment);
        $request = new ValidateShipmentOrderRequest($this->createVersion(), $shipmentOrder);
        $converter = new ParcelShippingConverter();
        [$query, $request] = $converter->convertValidateShipmentOrderRequest($request);
        $response = $this->buildParcelShipping()->createOrders($request, $query, [], \Mediaopt\DHL\Api\MyAccount\Runtime\Client\Client::FETCH_RESPONSE);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $payload = \json_decode($response->getBody(), true);
        $this->assertEquals(200, $response->getStatusCode(), $payload['status']['detail']);
    }

    public function testValidateShipmentOutsideGermany()
    {
        $shipment = $this->createShipmentToGermany();
        $shipment->getReceiver()->getAddress()->setOrigin(new CountryType('AT'));
        $shipmentOrder = new ValidateShipmentOrderType('123', $shipment);
        $request = new ValidateShipmentOrderRequest($this->createVersion(), $shipmentOrder);
        $converter = new ParcelShippingConverter();
        [$query, $request] = $converter->convertValidateShipmentOrderRequest($request);
        $response = $this->buildParcelShipping()->createOrders($request, $query, [], \Mediaopt\DHL\Api\MyAccount\Runtime\Client\Client::FETCH_RESPONSE);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $body = $response->getBody()->getContents();
        $payload = \json_decode($body, true);
        $this->assertEquals(400, $response->getStatusCode(), $payload['status']['detail']);
        $this->assertContains('The product entered is not available for this country.', $body);
    }

    public function testValidateShipmentForYesterday()
    {
        $shipment = $this->createShipmentToGermany();
        $shipment->getShipmentDetails()->setShipmentDate((new \DateTime('-1 day'))->format('Y-m-d'));
        $shipmentOrder = new ValidateShipmentOrderType('123', $shipment);
        $request = new ValidateShipmentOrderRequest($this->createVersion(), $shipmentOrder);
        $converter = new ParcelShippingConverter();
        [$query, $request] = $converter->convertValidateShipmentOrderRequest($request);
        $response = $this->buildParcelShipping()->createOrders($request, $query, [], \Mediaopt\DHL\Api\MyAccount\Runtime\Client\Client::FETCH_RESPONSE);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $body = $response->getBody()->getContents();
        $payload = \json_decode($body, true);
        $this->assertEquals(400, $response->getStatusCode(), $payload['status']['detail']);
        $this->assertContains('Please enter a valid shipping date.', $body);
    }
}
