<?php

namespace Mediaopt\DHL\Controller\Admin;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Mediaopt\DHL\Adapter\DHLAdapter;
use Mediaopt\DHL\Adapter\GKVShipmentBuilder;
use Mediaopt\DHL\Api\GKV\Request\CreateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\Response\CreateShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\Serviceconfiguration;
use Mediaopt\DHL\Api\GKV\ShipmentOrderType;
use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Export\CsvExporter;
use Mediaopt\DHL\Model\MoDHLLabel;
use Mediaopt\DHL\Shipment\Shipment;
use OxidEsales\Eshop\Core\Registry;

/** @noinspection LongInheritanceChainInspection */

/**
 * This controller provides functionality to export orders into a CSV that can be imported in the Geschäftskundenportal.
 *
 * @author Mediaopt GmbH
 */
class OrderBatchController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{
    /**
     * @var string
     */
    const EXPORTED_CSV = 'moDHLCsv';

    /**
     * Prefix of the file that is transmitted to the user.
     *
     * @var string
     */
    const EXPORT_FILE = 'lieferadressen-export';

    /**
     * @var int
     */
    const ORDERS_PER_PAGE = 20;

    /**
     * @extend
     * @return string
     */
    public function render()
    {
        parent::render();
        return 'mo_dhl__order_batch.tpl';
    }

    /**
     * If at least one order was selected, every selected order is stored in the session.
     *
     * We redirect to the download page to ensure that non-critical notifications to the user are provided.
     *
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function export()
    {
        $orderIds = (array)Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('order');
        if (empty($orderIds)) {
            $message = Registry::getLang()->translateString('MO_DHL__BATCH_ERROR_NO_ORDER_SELECTED');
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay(new \OxidEsales\Eshop\Core\Exception\StandardException($message));
            return;
        }

        Registry::getSession()->setVariable(self::EXPORTED_CSV, $this->exportOrders($orderIds));
        header('Refresh: 0; url=' . $this->getDownloadUrl());
    }

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function createLabels()
    {
        $orderIds = (array)Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('order');
        if (empty($orderIds)) {
            $message = Registry::getLang()->translateString('MO_DHL__BATCH_ERROR_NO_ORDER_SELECTED');
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay(new \OxidEsales\Eshop\Core\Exception\StandardException($message));
            return;
        }
        $this->handleCreationResponse($this->callCreation($orderIds));
    }

    /**
     * @param string[] $orderIds
     * @return CreateShipmentOrderResponse
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function callCreation(array $orderIds)
    {
        $shipmentOrders = array_map([$this, 'buildShipmentOrder'], $orderIds);
        $gkvClient = Registry::get(DHLAdapter::class)->buildGKV();
        $request = new CreateShipmentOrderRequest($gkvClient->buildVersion(), $shipmentOrders);
        return $gkvClient->createShipmentOrder($request->setCombinedPrinting(0));
    }

    /**
     * @param CreateShipmentOrderResponse $response
     * @throws \Exception
     */
    protected function handleCreationResponse(CreateShipmentOrderResponse $response)
    {
        foreach ($response->getCreationState() as $creationState) {
            $statusInformation = $creationState->getLabelData()->getStatus();
            $order = \oxNew(Order::class);
            $order->load($creationState->getSequenceNumber());
            if ($errors = $statusInformation->getErrors()) {
                $message = Registry::getLang()->translateString('MO_DHL__BATCH_ERROR_CREATION_ERROR');
                $message = sprintf($message, $order->getFieldData('oxordernr'), implode(' ', $errors));
                Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($message);
                continue;
            }
            $label = MoDHLLabel::fromOrderAndCreationState($order, $creationState);
            $label->save();
        }
    }

    /**
     *
     */
    public function download()
    {
        $session = Registry::getSession();
        $csv = $session->getVariable(self::EXPORTED_CSV);
        $session->deleteVariable(self::EXPORTED_CSV);
        header('Content-Type: text/plain; charset=ISO-8859-1');
        header('Content-Disposition: attachment; filename=' . static::EXPORT_FILE . '-' . date('Ymd') . '.csv');
        Registry::getUtils()->showMessageAndExit($csv);
    }

    /**
     * Exports the supplied orders (via their id) as CSV.
     *
     * @param string[] $orderIds
     * @return string
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function exportOrders(array $orderIds)
    {
        assert(!empty($orderIds));
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $sanitizedIds = implode(', ', array_map([$db, 'quote'], $orderIds));
        $orderView = \getViewName('oxorder');
        $query = "SELECT * FROM  {$orderView} WHERE OXID IN ({$sanitizedIds})";
        $orderList = \oxNew(\OxidEsales\Eshop\Core\Model\ListModel::class);
        $orderList->init('oxOrder');
        $orderList->selectString($query);
        $orders = array_map([\oxNew(\Mediaopt\DHL\Export\ShipmentBuilder::class), 'build'], $orderList->getArray());
        $this->notifyAboutOrdersWithoutBillingNumber($orders);
        $exporter = new CsvExporter(Registry::getConfig()->getConfigParam('iUtfMode') ? 'UTF-8' : 'ISO-8859-15');
        $exporter->export($orders);
        return $exporter->save();
    }

    /**
     * @return array
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function loadOrders()
    {
        $maximum = self::ORDERS_PER_PAGE;
        $unsanitizedPage = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('page');
        $sanitizedPage = max(1, (int) filter_var($unsanitizedPage, FILTER_SANITIZE_NUMBER_INT));
        $offset = $maximum * ($sanitizedPage - 1);

        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM oxorder WHERE OXSHOPID = ? ORDER BY OXORDERDATE DESC LIMIT {$offset}, {$maximum}";
        $rows = $db->getAll($query, [$this->getConfig()->getShopId()]);
        $foundRows = (int) $db->getOne('SELECT FOUND_ROWS()');
        $orders = [];
        foreach ($rows as $row) {
            $order = \oxNew(\OxidEsales\Eshop\Application\Model\Order::class);
            $order->assign($row);
            $orders[] = $order;
        }
        return ['orders' => $orders, 'page' => max(1, (int)$sanitizedPage), 'pages' => max(1, ceil($foundRows / $maximum))];
    }

    /**
     * @param Shipment[] $orders
     * @return bool
     */
    protected function notifyAboutOrdersWithoutBillingNumber(array $orders)
    {
        $idsOfOrdersWithoutBillingNumber = [];
        foreach ($orders as $order) {
            if ($order->getBillingNumber() === null) {
                $idsOfOrdersWithoutBillingNumber[] = $order->getReference();
            }
        }

        if ($idsOfOrdersWithoutBillingNumber === []) {
            return false;
        }

        $key = 'MO_DHL__EXPORT_ORDERS_WITHOUT_BILLING_NUMBER';
        $translation = Registry::getLang()->translateString($key);
        $message = sprintf($translation, implode(', ', $idsOfOrdersWithoutBillingNumber));
        /** @noinspection PhpParamsInspection */
        Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($message);
        return true;
    }

    /**
     * @return string
     */
    protected function getDownloadUrl()
    {
        $config = $this->getConfig();
        $prefix = $config->getConfigParam('sShopURL') . $config->getConfigParam('sAdminDir') . '/';
        if ($config->getConfigParam('sAdminSSLURL')) {
            $prefix = $config->getConfigParam('sAdminSSLURL');
        }
        $url = Registry::get(\OxidEsales\Eshop\Core\UtilsUrl::class)->processUrl($prefix . 'index.php?cl=' . __CLASS__ . '&fnc=download');
        return str_replace('&amp;', '&', $url);
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
