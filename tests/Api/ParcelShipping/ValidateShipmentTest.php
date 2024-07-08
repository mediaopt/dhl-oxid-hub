<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\ParcelShipping;

require_once 'BaseParcelShippingTest.php';

use Mediaopt\DHL\Adapter\ParcelShippingRequestBuilder;
use Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentOrderRequest;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Mediaopt GmbH
 */
class ValidateShipmentTest extends BaseParcelShippingTest
{

    public function testValidateShipment()
    {
        $shipment = $this->createShipmentToGermany();
        $request = new ShipmentOrderRequest();
        $request->setShipments([$shipment]);
        $request->setProfile(ParcelShippingRequestBuilder::STANDARD_GRUPPENPROFIL);
        $query = $this->buildQueryParams();
        $query['validate'] = true;
        $response = $this->buildParcelShipping()->createOrders($request, $query, [], \Mediaopt\DHL\Api\MyAccount\Runtime\Client\Client::FETCH_RESPONSE);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $payload = \json_decode($response->getBody(), true);
        $this->assertEquals(200, $response->getStatusCode(), $payload['status']['detail']);
    }

    public function testValidateShipmentOutsideGermany()
    {
        $shipment = $this->createShipmentToAustria();
        $request = new ShipmentOrderRequest();
        $request->setShipments([$shipment]);
        $request->setProfile(ParcelShippingRequestBuilder::STANDARD_GRUPPENPROFIL);
        $query = $this->buildQueryParams();
        $query['validate'] = true;
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
        $shipment->setShipDate((new \DateTime('-1 day')));
        $request = new ShipmentOrderRequest();
        $request->setShipments([$shipment]);
        $request->setProfile(ParcelShippingRequestBuilder::STANDARD_GRUPPENPROFIL);
        $query = $this->buildQueryParams();
        $query['validate'] = true;
        $response = $this->buildParcelShipping()->createOrders($request, $query, [], \Mediaopt\DHL\Api\MyAccount\Runtime\Client\Client::FETCH_RESPONSE);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $body = $response->getBody()->getContents();
        $payload = \json_decode($body, true);
        $this->assertEquals(400, $response->getStatusCode(), $payload['status']['detail']);
        $this->assertContains('Please enter a valid shipping date.', $body);
    }
}
