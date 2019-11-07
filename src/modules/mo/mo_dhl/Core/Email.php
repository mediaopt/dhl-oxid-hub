<?php

namespace Mediaopt\DHL\Core;

use Mediaopt\DHL\Api\Wunschpaket;
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
        return $this->moDHLProcessRemarks($order);
    }

    /**
     * @param \Mediaopt\DHL\Application\Model\Order $order
     * @return \Mediaopt\DHL\Application\Model\Order
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function moDHLProcessRemarks($order)
    {
        $remark = $order->oxorder__oxremark->value;
        $this->moDHLAddPreferredDay($remark);
        $this->moDHLAddPreferredTime($remark);
        $this->moDHLAddPreferredNeighbour($remark);
        $this->moDHLAddPreferredLocation($remark);
        $this->moDHLAddSurcharge($order, $remark);
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        /** @var \Mediaopt\DHL\Application\Model\Order $enrichedOrder */
        $enrichedOrder = clone parent::_addUserInfoOrderEMail($order);
        $enrichedOrder->oxClone($enrichedOrder);
        $enrichedOrder->oxorder__oxremark->value = $wunschpaket->removeWunschpaketTags($remark);
        return $enrichedOrder;
    }

    /**
     * @param string $remark
     */
    protected function moDHLAddPreferredDay($remark)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        /** @var \Smarty $smarty */
        $smarty = $this->_getSmarty();
        $smarty->assign('moDHLPreferredDay', $wunschpaket->extractWunschtag($remark));
    }

    /**
     * @param string $remark
     */
    protected function moDHLAddPreferredTime($remark)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        /** @var \Smarty $smarty */
        $smarty = $this->_getSmarty();
        $preferredTime = $wunschpaket->extractTime($remark);
        $formattedPreferredTime = $preferredTime !== '' ? Wunschpaket::formatPreferredTime($preferredTime) : '';
        $smarty->assign('moDHLPreferredTime', $formattedPreferredTime);
    }

    /**
     * @param string $remark
     */
    protected function moDHLAddPreferredNeighbour($remark)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        list($type, $neighbourAddress, $neighbourName) = $wunschpaket->extractLocation($remark);
        /** @var \Smarty $smarty */
        $smarty = $this->_getSmarty();
        if ($type !== Wunschpaket::WUNSCHNACHBAR) {
            $smarty->assign('moDHLPreferredNeighbour', '');
            return;
        }
        $preferredNeighbour = $neighbourName . ', ' . $neighbourAddress;
        $smarty->assign('moDHLPreferredNeighbour', $preferredNeighbour);
    }

    /**
     * @param string $remark
     */
    protected function moDHLAddPreferredLocation($remark)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        list($type, $location) = $wunschpaket->extractLocation($remark);
        /** @var \Smarty $smarty */
        $smarty = $this->_getSmarty();
        $smarty->assign('moDHLPreferredLocation', $type === Wunschpaket::WUNSCHORT ? $location : '');
    }

    /**
     * @param \Mediaopt\DHL\Application\Model\Order $order
     * @param string $remark
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function moDHLAddSurcharge($order, $remark)
    {
        list($label, $surcharge) = $this->moDHLDetermineSurcharge($remark);
        if ($label !== '') {
            $label .= $order->isNettoMode() || \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('blShowVATForDelivery') ? '_NET' : '_GROSS';
        }
        /** @var \Smarty $smarty */
        $smarty = $this->_getSmarty();
        $smarty->assign('moDHLSurchargeLabel', $label);
        $smarty->assign('moDHLSurcharge', $order->moDHLCalculcateSurcharge($surcharge));
    }

    /**
     * @param string $remark
     * @return mixed[] the first element is a label (as language key) and the second is the actual surcharge (as double)
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function moDHLDetermineSurcharge($remark)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        if ($wunschpaket->hasWunschtag($remark) && $wunschpaket->hasWunschzeit($remark)) {
            return ['MO_DHL__COMBINATION_SURCHARGE', $wunschpaket->getCombinedWunschtagAndWunschzeitSurcharge()];
        }
        if ($wunschpaket->hasWunschtag($remark)) {
            return ['MO_DHL__WUNSCHTAG_COSTS', $wunschpaket->getWunschtagSurcharge()];
        }
        if ($wunschpaket->hasWunschzeit($remark)) {
            return ['MO_DHL__WUNSCHZEIT_COSTS', $wunschpaket->getWunschzeitSurcharge()];
        }
        return ['', 0];
    }
}
