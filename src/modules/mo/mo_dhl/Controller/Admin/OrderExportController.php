<?php

namespace Mediaopt\DHL\Controller\Admin;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 derksen mediaopt GmbH
 */

use Mediaopt\DHL\Export\CsvExporter;
use Mediaopt\DHL\Shipment\Shipment;

/** @noinspection LongInheritanceChainInspection */

/**
 * This controller provides functionality to export orders into a CSV that can be imported in the Geschäftskundenportal.
 *
 * @author derksen mediaopt GmbH
 */
class OrderExportController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
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
        return 'mo_dhl__order_export.tpl';
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
        $orderIds = (array) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('order');
        if (empty($orderIds)) {
            $message = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('MO_DHL__EXPORT_ERROR_NO_ORDER_SELECTED');
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay(new \OxidEsales\Eshop\Core\Exception\StandardException($message));
            return;
        }

        \OxidEsales\Eshop\Core\Registry::getSession()->setVariable(self::EXPORTED_CSV, $this->exportOrders($orderIds));
        header('Refresh: 0; url=' . $this->getDownloadUrl());
    }

    /**
     *
     */
    public function download()
    {
        $session = \OxidEsales\Eshop\Core\Registry::getSession();
        $csv = $session->getVariable(self::EXPORTED_CSV);
        $session->deleteVariable(self::EXPORTED_CSV);
        header('Content-Type: text/plain; charset=ISO-8859-1');
        header('Content-Disposition: attachment; filename=' . static::EXPORT_FILE . '-' . date('Ymd') . '.csv');
        \OxidEsales\Eshop\Core\Registry::getUtils()->showMessageAndExit($csv);
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
        $orders = array_map([\oxNew(\Mediaopt\DHL\Adapter\DHLShipmentBuilder::class), 'build'], $orderList->getArray());
        $this->notifyAboutOrdersWithoutBillingNumber($orders);
        $exporter = new CsvExporter(\OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('iUtfMode') ? 'UTF-8' : 'ISO-8859-15');
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
        $unsanitizedPage = \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('page');
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
        return ['orders' => $orders, 'page' => max(1, (int) $sanitizedPage), 'pages' => ceil($foundRows / $maximum)];
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
        $translation = \OxidEsales\Eshop\Core\Registry::getLang()->translateString($key);
        $message = sprintf($translation, implode(', ', $idsOfOrdersWithoutBillingNumber));
        /** @noinspection PhpParamsInspection */
        \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($message);
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
        $url = \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsUrl::class)->processUrl($prefix . 'index.php?cl=' . __CLASS__ . '&fnc=download');
        return str_replace('&amp;', '&', $url);
    }
}
