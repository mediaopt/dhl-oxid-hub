<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\ParcelShipping;

require_once 'BaseParcelShippingTest.php';

use Mediaopt\DHL\Adapter\ParcelShippingRequestBuilder;
use Mediaopt\DHL\Api\MyAccount\Runtime\Client\Client;
use Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentOrderRequest;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Mediaopt GmbH
 */
class CreateShipmentOrderTest extends BaseParcelShippingTest
{

    public function testCreateShipment()
    {
        $shipment = $this->createShipmentToGermany();
        $request = new ShipmentOrderRequest();
        $request->setShipments([$shipment]);
        $request->setProfile(ParcelShippingRequestBuilder::STANDARD_GRUPPENPROFIL);
        $query = $this->buildQueryParams();
        $response = $this->buildParcelShipping()->createOrders($request, $query, [], Client::FETCH_RESPONSE);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $payload = \json_decode($response->getBody(), true);
        $this->assertEquals(200, $response->getStatusCode(), $payload['status']['detail']);
    }

    public function testCreateShipmentOutsideGermany()
    {
        $shipment = $this->createShipmentToAustria();
        $request = new ShipmentOrderRequest();
        $request->setShipments([$shipment]);
        $request->setProfile(ParcelShippingRequestBuilder::STANDARD_GRUPPENPROFIL);
        $query = $this->buildQueryParams();
        $response = $this->buildParcelShipping()->createOrders($request, $query, [], Client::FETCH_RESPONSE);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $body = $response->getBody()->getContents();
        $payload = \json_decode($body, true);
        $this->assertEquals(400, $response->getStatusCode(), $payload['status']['detail']);
        $this->assertContains('The product entered is not available for this country.', $body);
    }

}
