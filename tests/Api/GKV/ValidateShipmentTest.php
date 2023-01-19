<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace sdk\GKV;

require_once 'BaseGKVTest.php';

use Mediaopt\DHL\Api\GKV\CountryType;
use Mediaopt\DHL\Api\GKV\ValidateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\ValidateShipmentOrderType;
use Mediaopt\DHL\Api\GKV\ValidateShipmentResponse;

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
        $response = $this->buildGKV()->validateShipment($request);
        $this->assertInstanceOf(ValidateShipmentResponse::class, $response);
        $this->assertEquals(0, $response->getStatus()->getStatusCode(), $response->getStatus()->getStatusText());
    }

    public function testValidateShipmentOutsideGermany()
    {
        $shipment = $this->createShipmentToGermany();
        $shipment->getReceiver()->getAddress()->setOrigin(new CountryType('AT'));
        $shipmentOrder = new ValidateShipmentOrderType('123', $shipment);
        $request = new ValidateShipmentOrderRequest($this->createVersion(), $shipmentOrder);
        $response = $this->buildGKV()->validateShipment($request);
        $this->assertInstanceOf(ValidateShipmentResponse::class, $response);
        $this->assertEquals(1101, $response->getStatus()->getStatusCode(), $response->getStatus()->getStatusText());
        $this->assertContains('Das angegebene Produkt ist für das Land nicht verfügbar.', $response->getValidationState()[0]->getStatus()->getStatusMessage(), implode(', ', $response->getValidationState()[0]->getStatus()->getStatusMessage()));
    }

    public function testValidateShipmentForYesterday()
    {
        $shipment = $this->createShipmentToGermany();
        $shipment->getShipmentDetails()->setShipmentDate((new \DateTime('-1 day'))->format('Y-m-d'));
        $shipmentOrder = new ValidateShipmentOrderType('123', $shipment);
        $request = new ValidateShipmentOrderRequest($this->createVersion(), $shipmentOrder);
        $response = $this->buildGKV()->validateShipment($request);
        $this->assertInstanceOf(ValidateShipmentResponse::class, $response);
        $this->assertEquals(1101, $response->getStatus()->getStatusCode(), $response->getStatus()->getStatusText());
        $this->assertContains('Bitte geben Sie ein gültiges Sendungsdatum an.', $response->getValidationState()[0]->getStatus()->getStatusMessage(), implode(', ', $response->getValidationState()[0]->getStatus()->getStatusMessage()));
    }
}
