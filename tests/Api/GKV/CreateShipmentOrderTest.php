<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\GKV;

require_once 'BaseGKVTest.php';

use Mediaopt\DHL\Adapter\ParcelShippingConverter;
use Mediaopt\DHL\Api\GKV\CreateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\ShipmentOrderType;
use Mediaopt\DHL\Api\MyAccount\Runtime\Client\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Mediaopt GmbH
 */
class CreateShipmentOrderTest extends BaseGKVTest
{

    public function testCreateShipment()
    {
        $shipment = $this->createShipmentToGermany();
        $shipmentOrder = new ShipmentOrderType('123', $shipment);
        $request = new CreateShipmentOrderRequest($this->createVersion(), $shipmentOrder);
        $converter = new ParcelShippingConverter();
        [$query, $request] = $converter->convertCreateShipmentOrderRequest($request);
        $response = $this->buildParcelShipping()->createOrders($request, $query, [], Client::FETCH_RESPONSE);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $payload = \json_decode($response->getBody(), true);
        $this->assertEquals(200, $response->getStatusCode(), $payload['status']['detail']);
    }

    public function testCreateShipmentOutsideGermany()
    {
        $shipment = $this->createShipmentToAustria();
        $shipmentOrder = new ShipmentOrderType('123', $shipment);
        $request = new CreateShipmentOrderRequest($this->createVersion(), $shipmentOrder);
        $converter = new ParcelShippingConverter();
        [$query, $request] = $converter->convertCreateShipmentOrderRequest($request);
        $response = $this->buildParcelShipping()->createOrders($request, $query, [], Client::FETCH_RESPONSE);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $body = $response->getBody()->getContents();
        $payload = \json_decode($body, true);
        $this->assertEquals(400, $response->getStatusCode(), $payload['status']['detail']);
        $this->assertContains('The product entered is not available for this country.', $body);
    }

}
