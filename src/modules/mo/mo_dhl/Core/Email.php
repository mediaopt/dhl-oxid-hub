<?php

namespace Mediaopt\DHL\Core;

use Mediaopt\DHL\Api\Wunschpaket;
/**
 * @author Mediaopt GmbH
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
        if ($wunschpaket->hasWunschtag($remark)) {
            return ['MO_DHL__WUNSCHTAG_COSTS', $wunschpaket->getWunschtagSurcharge()];
        }
        return ['', 0];
    }

    /**
     * Sets mailer additional settings and sends retoure label mail to customer.
     * Returns true on success.
     *
     * @param \OxidEsales\Eshop\Application\Model\Order $order   Order object
     *
     * @return bool
     */
    public function moDHLSendRetoureLabelToCustomer($order)
    {
        $myConfig = $this->getConfig();

        $orderLang = (int) (isset($order->oxorder__oxlang->value) ? $order->oxorder__oxlang->value : 0);

        $shop = $this->_getShop($orderLang);
        $this->_setMailParams($shop);

        $lang = \OxidEsales\Eshop\Core\Registry::getLang();
        $smarty = $this->_getSmarty();
        $this->setViewData("order", $order);
        $this->setViewData("labels", $order->moDHLGetLabels());

        $this->_processViewArray();

        $store['INCLUDE_ANY'] = $smarty->security_settings['INCLUDE_ANY'];

        $oldTplLang = $lang->getTplLanguage();
        $oldBaseLang = $lang->getBaseLanguage();
        $lang->setTplLanguage($orderLang);
        $lang->setBaseLanguage($orderLang);

        $smarty->security_settings['INCLUDE_ANY'] = true;
        $oldIsAdmin = $myConfig->isAdmin();
        $myConfig->setAdminMode(false);

        $this->setBody($smarty->fetch('mo_dhl__email_retoure_html.tpl'));
        $this->setAltBody($smarty->fetch('mo_dhl__email_retoure_plain.tpl'));
        $myConfig->setAdminMode($oldIsAdmin);
        $lang->setTplLanguage($oldTplLang);
        $lang->setBaseLanguage($oldBaseLang);

        $smarty->security_settings['INCLUDE_ANY'] = $store['INCLUDE_ANY'];

        $this->setSubject($lang->translateString('MO_DHL__RETOURE_LABELS_EMAIL_SUBJECT'));

        $fullName = $order->oxorder__oxbillfname->getRawValue() . " " . $order->oxorder__oxbilllname->getRawValue();

        $this->setRecipient($order->oxorder__oxbillemail->value, $fullName);
        $this->setReplyTo($shop->oxshops__oxorderemail->value, $shop->oxshops__oxname->getRawValue());

        return $this->send();
    }
}
