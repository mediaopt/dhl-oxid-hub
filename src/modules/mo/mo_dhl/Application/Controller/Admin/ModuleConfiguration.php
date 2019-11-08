<?php

namespace Mediaopt\DHL\Application\Controller\Admin;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;

/** @noinspection LongInheritanceChainInspection */

/**
 * Extends the module configuration to allow the user to download logs.
 *
 * @author Mediaopt GmbH
 */
class ModuleConfiguration extends ModuleConfiguration_parent
{
    /**
     * @extend
     * @return string
     */
    public function render()
    {
        $this->addTplParam('processes', Process::getAvailableProcesses());
        return parent::render();
    }

    /**
     * Streams the chosen log to the user.
     */
    public function moDownload()
    {
        $log = \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('log');
        if (!in_array($log, $this->moGetLogs(), true)) {
            return;
        }

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename=' . $log);
        fpassthru(fopen(\OxidEsales\Eshop\Core\Registry::getConfig()->getLogsDir() . $log, 'rb'));
        exit;
    }

    /**
     * @return array
     */
    public function moGetLogs()
    {
        $logs = array_reverse(glob(\OxidEsales\Eshop\Core\Registry::getConfig()->getLogsDir() . 'mo_dhl_*.log'));
        return array_map('basename', $logs);
    }

    /**
     * @extend
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function saveConfVars()
    {
        parent::saveConfVars();

        if ($this->getEditObjectId() === 'mo_dhl') {
            $config = \OxidEsales\Eshop\Core\Registry::getConfig();
            $this->moSaveExcludedPaymentOptions((array) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('payment'));
            $this->moSaveExcludedDeliveryOptions((array) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('delivery'));
            $this->moSaveExcludedDeliverySetOptions((array) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('deliveryset'));
            $this->moSaveProcessIdentifiers((array) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('processIdentifier'));
            $this->moSaveParticipationNumbers((array) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('participationNumber'));
            $this->moReviewEkp();
        }
    }

    /**
     * @param string[] $excludedPaymentOptions
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    protected function moSaveExcludedPaymentOptions($excludedPaymentOptions)
    {
        if (!is_array($excludedPaymentOptions)) {
            $this->moSaveExcludedPaymentOptions([]);
            return;
        }

        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $db->execute('UPDATE `oxpayments` SET mo_dhl_excluded = 0');
        if (!empty($excludedPaymentOptions)) {
            $values = implode(', ', array_map([$db, 'quote'], $this->moSanitizeOptions($excludedPaymentOptions)));
            $db->execute("UPDATE `oxpayments` SET mo_dhl_excluded = 1 WHERE OXID IN ({$values})");
        }
    }

    /**
     * @param string[] $options
     * @return string[]
     */
    protected function moSanitizeOptions(array $options)
    {
        return array_map(function ($option) {
            return filter_var($option, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        }, $options);
    }

    /**
     * @param string[] $excludedDeliveryOptions
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    protected function moSaveExcludedDeliveryOptions($excludedDeliveryOptions)
    {
        if (!is_array($excludedDeliveryOptions)) {
            $this->moSaveExcludedDeliveryOptions([]);
            return;
        }

        $delivery = \getViewName('oxdelivery');
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $db->execute("UPDATE {$delivery} SET mo_dhl_excluded = 0");
        if (!empty($excludedDeliveryOptions)) {
            $values = implode(', ', array_map([$db, 'quote'], $this->moSanitizeOptions($excludedDeliveryOptions)));
            $db->execute("UPDATE {$delivery} SET mo_dhl_excluded = 1 WHERE OXID IN ({$values})");
        }
    }

    /**
     * @param string[] $excludedDeliverySetOptions
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    protected function moSaveExcludedDeliverySetOptions($excludedDeliverySetOptions)
    {
        if (!is_array($excludedDeliverySetOptions)) {
            $this->moSaveExcludedDeliverySetOptions([]);
            return;
        }

        $deliverySet = \getViewName('oxdeliveryset');
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $db->execute("UPDATE {$deliverySet} SET mo_dhl_excluded = 0");
        if (!empty($excludedDeliverySetOptions)) {
            $values = implode(', ', array_map([$db, 'quote'], $this->moSanitizeOptions($excludedDeliverySetOptions)));
            $db->execute("UPDATE {$deliverySet} SET mo_dhl_excluded = 1 WHERE OXID IN ({$values})");
        }
    }

    /**
     * @return \OxidEsales\Eshop\Application\Model\Payment[]
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function moGetPaymentOptions()
    {
        $paymentList = \oxNew(\OxidEsales\Eshop\Application\Model\PaymentList::class);
        $paymentList->getList();
        return $paymentList->getArray();
    }

    /**
     * @return \OxidEsales\Eshop\Application\Model\DeliverySet[]
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function moGetDeliveryOptions()
    {
        $deliverySetList = \oxNew(\OxidEsales\Eshop\Application\Model\DeliveryList::class);
        $deliverySetList->getList();
        return $deliverySetList->getArray();
    }

    /**
     * @return \OxidEsales\Eshop\Application\Model\DeliverySet[]
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function moGetDeliverySetOptions()
    {
        $deliverySetList = \oxNew(\OxidEsales\Eshop\Application\Model\DeliverySetList::class);
        $deliverySetList->getList();
        return $deliverySetList->getArray();
    }

    /**
     * @param string[] $identifiers
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    protected function moSaveProcessIdentifiers($identifiers)
    {
        $deliverySet = \getViewName('oxdeliveryset');
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $db->execute("UPDATE {$deliverySet} SET MO_DHL_PROCESS = NULL");
        $query = "UPDATE {$deliverySet} SET MO_DHL_PROCESS = %s WHERE OXID = %s";
        foreach ($identifiers as $oxid => $identifier) {
            if (empty($identifier)) {
                continue;
            }

            try {
                Process::build($identifier);
                $db->execute(sprintf($query, $db->quote($identifier), $db->quote($oxid)));
            } catch (\InvalidArgumentException $exception) {
                /** @noinspection PhpParamsInspection */
                \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__PROCESS_IDENTIFIER_ERROR');
            }
        }
    }

    /**
     * @param string[] $numbers
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    protected function moSaveParticipationNumbers($numbers)
    {
        $deliverySet = \getViewName('oxdeliveryset');
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $db->execute("UPDATE {$deliverySet} SET MO_DHL_PARTICIPATION = NULL");
        $query = "UPDATE {$deliverySet} SET MO_DHL_PARTICIPATION = %s WHERE OXID = %s";
        foreach ($numbers as $oxid => $number) {
            if (empty($number)) {
                continue;
            }

            try {
                Participation::build($number);
                $db->execute(sprintf($query, $db->quote($number), $db->quote($oxid)));
            } catch (\InvalidArgumentException $exception) {
                /** @noinspection PhpParamsInspection */
                \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__PARTICIPATION_NUMBER_ERROR');
            }
        }
    }

    /**
     */
    protected function moReviewEkp()
    {
        $ekpVariable = 'mo_dhl__merchant_ekp';
        $ekp = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam($ekpVariable);
        if (empty($ekp)) {
            return;
        }

        try {
            Ekp::build($ekp);
        } catch (\InvalidArgumentException $exception) {
            \OxidEsales\Eshop\Core\Registry::getConfig()->saveShopConfVar('string', $ekpVariable, '', '', 'module:mo_dhl');
            /** @noinspection PhpParamsInspection */
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__EKP_ERROR');
        }
    }
}
