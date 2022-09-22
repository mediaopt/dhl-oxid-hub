<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\GKV;

require_once 'BaseGKVTest.php';

use Mediaopt\DHL\Api\GKV\CreateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\CreateShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\ShipmentOrderType;
use Mediaopt\DHL\Api\GKV\Version;

/**
 * @author Mediaopt GmbH
 */
class CreateShipmentOrderTest extends BaseGKVTest
{

    public function testCreateShipment()
    {
        $shipment = $this->createShipmentToGermany();
        $shipmentOrder = new ShipmentOrderType('123', $shipment);
        $request = new CreateShipmentOrderRequest(new Version(3, 4, 0), $shipmentOrder);
        $response = $this->buildGKV()->createShipmentOrder($request);
        $this->assertInstanceOf(CreateShipmentOrderResponse::class, $response);
        $this->assertEquals(0, $response->getStatus()->getStatusCode(), implode(', ', $response->getCreationState()[0]->getLabelData()->getStatus()->getStatusMessage()));
    }

    public function testCreateShipmentOutsideGermany()
    {
        $shipment = $this->createShipmentToAustria();
        $shipmentOrder = new ShipmentOrderType('123', $shipment);
        $request = new CreateShipmentOrderRequest(new Version(3, 4, 0), $shipmentOrder);
        $response = $this->buildGKV()->createShipmentOrder($request);
        $this->assertInstanceOf(CreateShipmentOrderResponse::class, $response);
        $this->assertEquals(1101, $response->getStatus()->getStatusCode(), $response->getStatus()->getStatusText());
        $this->assertContains('Das angegebene Produkt ist für das Land nicht verfügbar.', $response->getCreationState()[0]->getLabelData()->getStatus()->getStatusMessage());
    }

}
