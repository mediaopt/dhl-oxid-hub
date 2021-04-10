<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Adapter;

use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Application\Model\OrderArticle;

/**
 * This class transforms an \oxOrder object into a Shipment object.
 *
 * @author Mediaopt GmbH
 */
class BaseShipmentBuilder
{
    /**
     * @var float minimum weight for the order
     */
    const MO_DHL__MIN_WEIGHT_FOR_ORDER = 0.01;

    /**
     * @var float minimum weight for order items in export documents
     */
    const MO_DHL__MIN_WEIGHT_FOR_ORDERITEMS = 0.001;
    /**
     * @var string
     */
    protected $ekp;

    /**
     * @var string[]
     */
    protected $deliverySetToProcessIdentifier = [];

    /**
     * @var string[]
     */
    protected $deliverySetToParticipationNumber = [];

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    public function __construct()
    {
        $this->ekp = Registry::getConfig()->getConfigParam('mo_dhl__merchant_ekp');
        $this->loadProcessAndParticipationForDeliverySets();
    }

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    protected function loadProcessAndParticipationForDeliverySets()
    {
        $query = ' SELECT OXID, MO_DHL_PROCESS, MO_DHL_PARTICIPATION' . ' FROM ' . getViewName('oxdeliveryset');
        foreach ((array)\OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC)->getAll($query) as $row) {
            $this->deliverySetToProcessIdentifier[$row['OXID']] = $row['MO_DHL_PROCESS'];
            $this->deliverySetToParticipationNumber[$row['OXID']] = $row['MO_DHL_PARTICIPATION'];
        }
    }

    /**
     * @param Order $order
     * @return float
     */
    protected function calculateWeight(Order $order): float
    {
        $config = Registry::getConfig();
        $weight = 0.0;
        foreach ($order->getOrderArticles() as $orderArticle) {
            $articleWeight = $this->getArticleWeight($orderArticle, $config, $this->isInternational($order));
            $weight += $articleWeight * $orderArticle->getFieldData('oxamount');
        }
        $weight *= 1 + (float)$config->getShopConfVar('mo_dhl__packing_weight_in_percent') / 100.0;
        $weight += (float)$config->getShopConfVar('mo_dhl__packing_weight_absolute');
        return max(self::MO_DHL__MIN_WEIGHT_FOR_ORDER, $weight);
    }

    /**
     * @param Order $order
     * @return Ekp|null
     */
    protected function getEkp(Order $order)
    {
        try {
            return Ekp::build($order->oxorder__mo_dhl_ekp->rawValue ?: $this->ekp);
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }

    /**
     * @param Order $order
     * @return Process|null
     */
    protected function getProcess(Order $order)
    {
        try {
            $identifier = $order->oxorder__mo_dhl_process->rawValue ?: $this->deliverySetToProcessIdentifier[$order->oxorder__oxdeltype->rawValue];
            return Process::build($identifier);
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }

    /**
     * @param Order $order
     * @return Process|null
     */
    protected function getReturnProcess(Order $order)
    {
        try {
            $identifier = $order->oxorder__mo_dhl_process->rawValue ?: $this->deliverySetToProcessIdentifier[$order->oxorder__oxdeltype->rawValue];
            return Process::buildForRetoure($identifier);
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }

    /**
     * @param Order $order
     * @return Participation|null
     */
    protected function getParticipation(Order $order)
    {
        try {
            $number = $order->oxorder__mo_dhl_participation->rawValue ?: $this->deliverySetToParticipationNumber[$order->oxorder__oxdeltype->rawValue];
            return Participation::build($number);
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }

    /**
     * @param OrderArticle $orderArticle
     * @param \OxidEsales\Eshop\Core\Config $config
     * @param bool $isInternationalShipment
     * @return float|mixed
     */
    protected function getArticleWeight(OrderArticle $orderArticle, \OxidEsales\Eshop\Core\Config $config, bool $isInternationalShipment)
    {
        /** @var OrderArticle $orderArticle */
        $articleWeight = $config->getShopConfVar('mo_dhl__calculate_weight')
            ? (float)$orderArticle->getFieldData('oxweight')
            : (float)$config->getShopConfVar('mo_dhl__default_weight');
        if ($isInternationalShipment && $articleWeight < self::MO_DHL__MIN_WEIGHT_FOR_ORDERITEMS) {
            $articleWeight = max(self::MO_DHL__MIN_WEIGHT_FOR_ORDERITEMS, (float)$config->getShopConfVar('mo_dhl__default_weight'));
        }
        return $articleWeight;
    }

    /**
     * @param Order $order
     * @return bool
     */
    protected function isInternational(Order $order): bool
    {
        return $this->getProcess($order)->isInternational();
    }
}
