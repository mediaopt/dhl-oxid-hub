<?php

namespace Mediaopt\DHL\Application\Model;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Mediaopt\DHL\Model\MoDHLLabel;
use Mediaopt\DHL\Model\MoDHLLabelList;
use Mediaopt\DHL\ServiceProvider\Branch;
use OxidEsales\Eshop\Core\Field;

/** @noinspection LongInheritanceChainInspection */

/**
 * Adds functionality to...
 * - ... exclude delivery sets in case the destination is a Packstation or Postfiliale.
 * - ... exclude payment options in case the destination is a Packstation or Postfiliale.
 * - ... add surcharges in case Wunschtag is selected.
 *
 * @author Mediaopt GmbH
 */
class Order extends Order_parent
{

    /**
     * @var MoDHLLabel|false|null
     */
    protected $moDHLRetoureLabel = null;

    /**
     * @extend
     * @param \OxidEsales\Eshop\Application\Model\Basket    $basket
     * @param \OxidEsales\Eshop\Application\Model\User|null $user
     * @return int|string
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    public function validatePayment($basket, $user = null)
    {
        if ($this->moDHLIsPaymentExcluded()) {
            return \OxidEsales\Eshop\Core\Registry::getLang()->translateString('MO_DHL__PAYMENT_EXCLUDED');
        }
        return $user === null ? parent::validatePayment($basket) : parent::validatePayment($basket, $user);
    }

    /**
     * Returns true iff the payment is excluded by configuration.
     *
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    public function moDHLIsPaymentExcluded()
    {
        if (!$this->moDHLIsForcedToUseDhlDelivery()) {
            return false;
        }

        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $paymentId = $this->oxorder__oxpaymenttype->rawValue;
        $query = "SELECT mo_dhl_excluded FROM oxpayments WHERE OXID = {$db->quote($paymentId)}";

        return (int)$db->getOne($query) > 0;
    }

    /**
     * @return bool
     */
    protected function moDHLIsForcedToUseDhlDelivery()
    {
        /** @var \Mediaopt\DHL\Application\Model\User $user */
        $user = $this->getOrderUser();
        return $this->moDHLIsDeliveredToBranch() || $user->moHasSelectedAnyWunschpaketService();
    }

    /**
     * Added call to _setUser to ensure that the delivery address is set.
     *
     * @extend
     * @param \Mediaopt\DHL\Application\Model\Basket   $basket
     * @param \OxidEsales\Eshop\Application\Model\User $user
     * @return int
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function validateOrder($basket, $user)
    {
        $this->_setUser($user);
        $this->_loadFromBasket($basket);
        $this->_setPayment($basket->getPaymentId());
        return parent::validateOrder($basket, $user);
    }

    /**
     * Adds costs for Wunschtag to the delivery costs.
     *
     * @extend
     * @param \OxidEsales\Eshop\Application\Model\Basket $basket
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function _loadFromBasket(\OxidEsales\Eshop\Application\Model\Basket $basket)
    {
        /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
        parent::_loadFromBasket($basket);
        $deliveryCosts = clone $basket->getDeliveryCost();
        $deliveryCosts->add($basket->moDHLGetDeliverySurcharges()->getPrice());
        $this->oxorder__oxdelcost = new Field($deliveryCosts->getBruttoPrice(), Field::T_RAW);
    }

    /**
     * @extend
     * @param \OxidEsales\Eshop\Application\Model\Basket $basket
     * @return string|int
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    public function validateDelivery($basket)
    {
        return $this->moDHLIsDeliveryExcluded() ? \OxidEsales\Eshop\Core\Registry::getLang()->translateString('MO_DHL__DELIVERY_EXCLUDED') : parent::validateDelivery($basket);
    }

    /**
     * Returns true iff the delivery is excluded by configuration.
     *
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    public function moDHLIsDeliveryExcluded()
    {
        if (!$this->moDHLIsForcedToUseDhlDelivery()) {
            return false;
        }

        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $deliverySetId = $this->oxorder__oxdeltype->rawValue;
        $query = "SELECT mo_dhl_excluded FROM oxdeliveryset WHERE OXID = {$db->quote($deliverySetId)}";
        return (int)$db->getOne($query) > 0;
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Basket $basket
     * @param \OxidEsales\Eshop\Application\Model\User   $user
     * @param bool                                       $recalculate
     * @return int
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseException
     */
    public function finalizeOrder(\OxidEsales\Eshop\Application\Model\Basket $basket, $user, $recalculate = false)
    {
        $status = parent::finalizeOrder($basket, $user, $recalculate);
        if ((string)$this->getId() === '') {
            return $status;
        }

        $ekp = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__merchant_ekp');
        $process = $this->getDelSet()->oxdeliveryset__mo_dhl_process->rawValue;
        $participation = $this->getDelSet()->oxdeliveryset__mo_dhl_participation->rawValue;
        $allowNotification = $this->moDHLGetNotificationAllowance();

        $this->oxorder__mo_dhl_ekp = \oxNew(Field::class, $ekp, Field::T_RAW);
        $this->oxorder__mo_dhl_process = \oxNew(Field::class, $process, Field::T_RAW);
        $this->oxorder__mo_dhl_participation = \oxNew(Field::class, $participation, Field::T_RAW);
        $this->oxorder__mo_dhl_allow_notification = \oxNew(Field::class, $allowNotification);
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $query = ' UPDATE oxorder SET MO_DHL_EKP = ?, MO_DHL_PARTICIPATION = ?, MO_DHL_PROCESS = ?, MO_DHL_ALLOW_NOTIFICATION = ? WHERE OXID = ?';
        $db->execute($query, [
            $ekp,
            $participation,
            $process,
            $allowNotification,
            $this->getId(),
        ]);

        return $status;
    }

    /**
     * @return bool
     */
    public function moDHLIsDeliveredToBranch()
    {
        return Branch::isBranch($this->oxorder__oxdelstreet->rawValue);
    }

    /**
     * @param double $amount
     * @return \OxidEsales\Eshop\Core\Price
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function moDHLCalculcateSurcharge($amount)
    {
        /** @var \Mediaopt\DHL\Application\Model\Basket $basket */
        $basket = $this->getBasket();
        return $basket->moDHLCalculateSurcharge($amount);
    }

    /**
     * @param string $field
     * @return mixed
     */
    public function moDHLGetAddressData($field)
    {
        foreach ([
                     'oxdelfname',
                     'oxdellname',
                 ] as $check) {
            if (empty($this->getFieldData($check))) {
                return $this->getFieldData("oxbill$field");
            }
        }
        return $this->getFieldData("oxdel$field");
    }

    /**
     * @return MoDHLLabelList
     */
    public function moDHLGetLabels()
    {
        $labels = \oxNew(MoDHLLabelList::class);
        $labels->loadOrderLabels($this->getId());
        return $labels;
    }

    /**
     * @return MoDHLLabel|false
     */
    public function moDHLGetRetoure()
    {
        if ($this->moDHLRetoureLabel === null) {
            $labels = $this->moDHLGetLabels();
            $this->moDHLRetoureLabel = reset(array_filter($labels->getArray(), function ($label) {return $label->isRetoure();}));
        }
        return $this->moDHLRetoureLabel;
}

    /**
     * @return bool
     */
    public function moDHLHasRetoure()
    {
        return $this->moDHLGetRetoure() !== false;
    }

    /**
     * @return bool
     */
    protected function moDHLGetNotificationAllowance() : bool
    {
        $dynamicValues = $this->getSession()->getVariable('dynvalue');
        return $dynamicValues['mo_dhl_allow_notification'] ?? false;
    }

    /**
     * @param string $status
     */
    public function storeCreationStatus(string $status)
    {
        $this->oxorder__mo_dhl_last_label_creation_status = oxNew(Field::class, $status);
        $this->save();
    }
}
