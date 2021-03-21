<?php

namespace Mediaopt\DHL\Controller\Admin;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Mediaopt\DHL\Adapter\DHLAdapter;
use Mediaopt\DHL\Adapter\GKVCreateShipmentOrderRequestBuilder;
use Mediaopt\DHL\Api\GKV\Response\CreateShipmentOrderResponse;
use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Export\CsvExporter;
use Mediaopt\DHL\Model\MoDHLLabel;
use Mediaopt\DHL\Model\MoDHLLabelList;
use Mediaopt\DHL\Shipment\RetoureRequest;
use Mediaopt\DHL\Shipment\Shipment;
use Mediaopt\DHL\Shipment\Process;
use OxidEsales\Eshop\Core\Registry;

/** @noinspection LongInheritanceChainInspection */

/**
 * This controller provides functionality to export orders into a CSV that can be imported in the Geschäftskundenportal.
 *
 * @author Mediaopt GmbH
 */
class OrderBatchController extends \OxidEsales\Eshop\Application\Controller\Admin\OrderList
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
    protected $_iDefViewListSize = 10;

    /**
     * @var int[]
     */
    const MO_DHL__LIST_SIZE_OPTIONS = [10, 20, 50, 100];

    /**
     * @extend
     * @return string
     */
    public function render()
    {
        parent::render();

        $orderIds = [];
        foreach ($this->_oList as $item) {
            $orderIds[] = $item->getId();
        }

        $labels = \oxNew(MoDHLLabelList::class);
        $labels->loadOrderLabels($orderIds);

        $orderLabels = [];
        foreach ($labels as $label) {
            $orderLabels[$label->getFieldData('orderId')][$label->getFieldData('type')] = true;
        }

        $this->_aViewData["OrderLabels"] = $orderLabels;
        if (Registry::getConfig()->getShopConfVar('mo_dhl__retoure_admin_approve')) {
            $retoureRequestStatuses = RetoureRequest::getRetoureRequestStatuses();
            $retoureRequestStatusFilter = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("RetoureRequestStatusFilter");
            $deliveryLabelStatusFilter = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("DeliveryLabelStatusFilter");
            $retoureLabelStatusFilter = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("RetoureLabelStatusFilter");

            $this->_aViewData["RetoureRequestStatuses"] = $retoureRequestStatuses;
            $this->_aViewData["RetoureRequestStatusFilter"] = $retoureRequestStatusFilter;
            $this->_aViewData["DeliveryLabelStatusFilter"] = $deliveryLabelStatusFilter;
            $this->_aViewData["RetoureLabelStatusFilter"] = $retoureLabelStatusFilter ;
            $this->_aViewData["RetoureAdminApprove"] = Registry::getConfig()->getShopConfVar('mo_dhl__retoure_admin_approve');
        }

        return 'mo_dhl__order_batch.tpl';
    }

    /**
     * Adding retoure request status check
     *
     * @param array  $whereQuery SQL condition array
     * @param string $fullQuery  SQL query string
     *
     * @return string
     */
    protected function _prepareWhereQuery($whereQuery, $fullQuery)
    {
        $database = \OxidEsales\Eshop\Core\DatabaseProvider::getDb();
        $query = parent::_prepareWhereQuery($whereQuery, $fullQuery);

        $retoureRequestStatusFilter = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('RetoureRequestStatusFilter');

        if (isset((RetoureRequest::getRetoureRequestStatuses())[$retoureRequestStatusFilter])) {
            $query .= " and ( oxorder.mo_dhl_retoure_request_status = " . $database->quote($retoureRequestStatusFilter) . " )";
        } elseif ($retoureRequestStatusFilter === '-') {
            $query .= " and ( oxorder.mo_dhl_retoure_request_status IS NULL )";
        }

        $deliveryLabelStatusFilter = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('DeliveryLabelStatusFilter');
        $retoureLabelStatusFilter = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('RetoureLabelStatusFilter');

        if (!empty($deliveryLabelStatusFilter)) {
            $joinQuery = 'from oxorder left join mo_dhl_labels mdl_delivery on oxorder.OXID = mdl_delivery.orderId and mdl_delivery.type = "delivery"';
            $query = str_replace('from oxorder', $joinQuery, $query);
            if ("-" === $deliveryLabelStatusFilter) {
                $query .= ' and mdl_delivery.OXID IS NULL ';
            } else {
                $query .= ' and mdl_delivery.OXID IS NOT NULL ';
            }
        }

        if (!empty($retoureLabelStatusFilter)) {
            $joinQuery = 'from oxorder left join mo_dhl_labels mdl_retoure on oxorder.OXID = mdl_retoure.orderId and mdl_retoure.type = "retoure"';
            $query = str_replace('from oxorder', $joinQuery, $query);
            if ("-" === $retoureLabelStatusFilter) {
                $query .= ' and mdl_retoure.OXID IS NULL ';
            } else {
                $query .= ' and mdl_retoure.OXID IS NOT NULL  ';
            }
        }

        return $query;
    }

    /**
     * @inheritDoc
     */
    protected function _getViewListSize()
    {
        return $this->_getUserDefListSize() ?: parent::_getViewListSize();
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

        $splittedOrderIds = $this->splitOrderIdsByProcess($orderIds);

        if (array_key_exists(Process::WARENPOST_INTERNATIONAL, $splittedOrderIds)) {
            $this->createWarenpostInternationalLabels($splittedOrderIds[Process::WARENPOST_INTERNATIONAL]);
        }
        if (array_key_exists('default', $splittedOrderIds)) {
            $this->handleCreationResponse($this->callCreation($splittedOrderIds['default']));
        }
    }

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function createRetoureLabels()
    {
        $orderIds = (array)Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('order');
        if (empty($orderIds)) {
            $message = Registry::getLang()->translateString('MO_DHL__BATCH_ERROR_NO_ORDER_SELECTED');
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay(new \OxidEsales\Eshop\Core\Exception\StandardException($message));
            return;
        }

        $orderDHLController = oxNew(OrderDHLController::class);
        $order = oxNew(Order::class);
        foreach ($orderIds as $orderId) {
            $order->load($orderId);
            $orderDHLController->createRetoure($order);
        }
    }

    /**
     * @param string[] $orderIds
     * @return CreateShipmentOrderResponse
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function callCreation(array $orderIds)
    {
        $request = Registry::get(GKVCreateShipmentOrderRequestBuilder::class)->build($orderIds);
        return Registry::get(DHLAdapter::class)->buildGKV()->createShipmentOrder($request);
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
            $order->storeCreationStatus($statusInformation->getStatusText());
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

        $tableViewNameGenerator = oxNew(\OxidEsales\Eshop\Core\TableViewNameGenerator::class);
        $orderView = $tableViewNameGenerator->getViewName('oxorder');
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
     * @return int[]
     */
    public function getListSizeOptions()
    {
        return self::MO_DHL__LIST_SIZE_OPTIONS;
    }

    /**
     * @return string
     */
    public function getFilterStringForLink(): string
    {
        return '&amp;' . http_build_query(['where' => $this->getListFilter(), 'viewListSize' => $this->getViewListSize()]);
    }

    /**
     * @param array $orderIds
     * @return array
     */
    protected function splitOrderIdsByProcess(array $orderIds): array
    {
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $sql = 'SELECT oxid, MO_DHL_PROCESS  from oxorder where OXID in ("' . implode('", "', $orderIds) . '")';
        $orders = $db->getAll($sql);

        $idsByProcess = [];
        foreach ($orders as $orderData) {
            $process = 'default';
            if ($orderData['MO_DHL_PROCESS'] === Process::WARENPOST_INTERNATIONAL) {
                $process = Process::WARENPOST_INTERNATIONAL;
            }
            $idsByProcess[$process][] = $orderData['oxid'];
        }

        return $idsByProcess;
    }

    /**
     * @param array $orderIds
     */
    protected function createWarenpostInternationalLabels(array $orderIds)
    {
        $orderDHLController = oxNew(OrderDHLController::class);
        $order =  oxNew(Order::class);
        foreach ($orderIds as $orderId) {
            $order->load($orderId);
            $orderDHLController->createWarenpostLabel($order);
        }
    }
}
