<?php

namespace Mediaopt\DHL\Core;

use Mediaopt\Empfaengerservices\Api\Wunschpaket;
/**
 * @author derksen mediaopt GmbH
 */
class Email extends Email_parent
{
    /**
     * @param \Mediaopt\DHL\Application\Model\Order $order
     * @return \Mediaopt\DHL\Application\Model\Order
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function _addUserInfoOrderEMail($order)
    {
        return $this->moEmpfaengerservicesProcessRemarks($order);
    }

    /**
     * @param \Mediaopt\DHL\Application\Model\Order $order
     * @return \Mediaopt\DHL\Application\Model\Order
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function moEmpfaengerservicesProcessRemarks($order)
    {
        $remark = $order->oxorder__oxremark->value;
        $this->moEmpfaengerservicesAddPreferredDay($remark);
        $this->moEmpfaengerservicesAddPreferredTime($remark);
        $this->moEmpfaengerservicesAddPreferredNeighbour($remark);
        $this->moEmpfaengerservicesAddPreferredLocation($remark);
        $this->moEmpfaengerservicesAddSurcharge($order, $remark);
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        /** @var \Mediaopt\DHL\Application\Model\Order $enrichedOrder */
        $enrichedOrder = clone parent::_addUserInfoOrderEMail($order);
        $enrichedOrder->oxClone($enrichedOrder);
        $enrichedOrder->oxorder__oxremark->value = $wunschpaket->removeWunschpaketTags($remark);
        return $enrichedOrder;
    }

    /**
     * @param string $remark
     */
    protected function moEmpfaengerservicesAddPreferredDay($remark)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        /** @var \Smarty $smarty */
        $smarty = $this->_getSmarty();
        $smarty->assign('moEmpfaengerservicesPreferredDay', $wunschpaket->extractWunschtag($remark));
    }

    /**
     * @param string $remark
     */
    protected function moEmpfaengerservicesAddPreferredTime($remark)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        /** @var \Smarty $smarty */
        $smarty = $this->_getSmarty();
        $preferredTime = $wunschpaket->extractTime($remark);
        $formattedPreferredTime = $preferredTime !== '' ? Wunschpaket::formatPreferredTime($preferredTime) : '';
        $smarty->assign('moEmpfaengerservicesPreferredTime', $formattedPreferredTime);
    }

    /**
     * @param string $remark
     */
    protected function moEmpfaengerservicesAddPreferredNeighbour($remark)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        list($type, $neighbourAddress, $neighbourName) = $wunschpaket->extractLocation($remark);
        /** @var \Smarty $smarty */
        $smarty = $this->_getSmarty();
        if ($type !== Wunschpaket::WUNSCHNACHBAR) {
            $smarty->assign('moEmpfaengerservicesPreferredNeighbour', '');
            return;
        }
        $preferredNeighbour = $neighbourName . ', ' . $neighbourAddress;
        $smarty->assign('moEmpfaengerservicesPreferredNeighbour', $preferredNeighbour);
    }

    /**
     * @param string $remark
     */
    protected function moEmpfaengerservicesAddPreferredLocation($remark)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        list($type, $location) = $wunschpaket->extractLocation($remark);
        /** @var \Smarty $smarty */
        $smarty = $this->_getSmarty();
        $smarty->assign('moEmpfaengerservicesPreferredLocation', $type === Wunschpaket::WUNSCHORT ? $location : '');
    }

    /**
     * @param \Mediaopt\DHL\Application\Model\Order $order
     * @param string $remark
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function moEmpfaengerservicesAddSurcharge($order, $remark)
    {
        list($label, $surcharge) = $this->moEmpfaengerservicesDetermineSurcharge($remark);
        if ($label !== '') {
            $label .= $order->isNettoMode() || \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('blShowVATForDelivery') ? '_NET' : '_GROSS';
        }
        /** @var \Smarty $smarty */
        $smarty = $this->_getSmarty();
        $smarty->assign('moEmpfaengerservicesSurchargeLabel', $label);
        $smarty->assign('moEmpfaengerservicesSurcharge', $order->moEmpfaengerservicesCalculcateSurcharge($surcharge));
    }

    /**
     * @param string $remark
     * @return mixed[] the first element is a label (as language key) and the second is the actual surcharge (as double)
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function moEmpfaengerservicesDetermineSurcharge($remark)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        if ($wunschpaket->hasWunschtag($remark) && $wunschpaket->hasWunschzeit($remark)) {
            return ['MO_EMPFAENGERSERVICES__COMBINATION_SURCHARGE', $wunschpaket->getCombinedWunschtagAndWunschzeitSurcharge()];
        }
        if ($wunschpaket->hasWunschtag($remark)) {
            return ['MO_EMPFAENGERSERVICES__WUNSCHTAG_COSTS', $wunschpaket->getWunschtagSurcharge()];
        }
        if ($wunschpaket->hasWunschzeit($remark)) {
            return ['MO_EMPFAENGERSERVICES__WUNSCHZEIT_COSTS', $wunschpaket->getWunschzeitSurcharge()];
        }
        return ['', 0];
    }
}