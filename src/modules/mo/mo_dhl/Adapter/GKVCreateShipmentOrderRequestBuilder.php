<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Adapter;


use Mediaopt\DHL\Api\GKV\Request\CreateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\Serviceconfiguration;
use Mediaopt\DHL\Api\GKV\ShipmentOrderType;
use Mediaopt\DHL\Application\Model\Order;
use OxidEsales\Eshop\Core\Registry;

/**
 * @author Mediaopt GmbH
 */
class GKVCreateShipmentOrderRequestBuilder
{

    /**
     * @param array $orderIds
     * @return CreateShipmentOrderRequest
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function build(array $orderIds): CreateShipmentOrderRequest
    {
        $shipmentOrders = array_map([$this, 'buildShipmentOrder'], $orderIds);
        $gkvClient = Registry::get(DHLAdapter::class)->buildGKV();
        $request = new CreateShipmentOrderRequest($gkvClient->buildVersion(), $shipmentOrders);
        return $request->setCombinedPrinting(0);
    }

    /**
     * @param string $orderId
     * @return ShipmentOrderType
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildShipmentOrder(string $orderId): ShipmentOrderType
    {
        $order = \oxNew(Order::class);
        $order->load($orderId);
        $shipmentOrder = new ShipmentOrderType($orderId, Registry::get(GKVShipmentBuilder::class)->build($order));
        if (Registry::getConfig()->getShopConfVar('mo_dhl__only_with_leitcode')) {
            $shipmentOrder->setPrintOnlyIfCodeable(new Serviceconfiguration(true));
        }
        return $shipmentOrder;
    }
}
