<?php

namespace Mediaopt\DHL\Core;

use Mediaopt\DHL\Api\Wunschpaket;
use Mediaopt\DHL\Application\Controller\AccountOrderController;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateRendererBridgeInterface;

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

        $this->setViewData("order", $order);
        $this->setViewData("labels", $order->moDHLGetLabels());
        $this->_processViewArray();

        $lang = \OxidEsales\Eshop\Core\Registry::getLang();
        $oldTplLang = $lang->getTplLanguage();
        $oldBaseLang = $lang->getBaseLanguage();
        $lang->setTplLanguage($orderLang);
        $lang->setBaseLanguage($orderLang);

        $oldIsAdmin = $myConfig->isAdmin();
        $myConfig->setAdminMode(false);

        $this->setBody($this->moDHLRenderTemplate('mo_dhl__email_retoure_html.tpl'));
        $this->setAltBody($this->moDHLRenderTemplate('mo_dhl__email_retoure_plain.tpl'));
        $this->setSubject($lang->translateString('MO_DHL__RETOURE_LABELS_EMAIL_SUBJECT'));

        $myConfig->setAdminMode($oldIsAdmin);
        $lang->setTplLanguage($oldTplLang);
        $lang->setBaseLanguage($oldBaseLang);

        $fullName = $order->oxorder__oxbillfname->getRawValue() . " " . $order->oxorder__oxbilllname->getRawValue();

        $this->setRecipient($order->oxorder__oxbillemail->value, $fullName);
        $this->setReplyTo($shop->oxshops__oxorderemail->value, $shop->oxshops__oxname->getRawValue());

        return $this->send();
    }

    /**
     * @param  string $template
     * @return string
     */
    protected function moDHLRenderTemplate(string $template)
    {
        if (interface_exists('OxidEsales\EshopCommunity\Internal\Framework\Templating\TemplateRendererBridgeInterface')) {
            $renderer = $this->getContainer()->get(TemplateRendererBridgeInterface::class)->getTemplateRenderer();
            return $renderer->renderTemplate($template, $this->getViewData());
        }
        $smarty = $this->_getSmarty();
        return $smarty->fetch($template);
    }

    /**
     * Sets mailer additional settings and sends "SendedNowMail" mail to user.
     * Returns true on success.
     *
     * @param \OxidEsales\Eshop\Application\Model\Order $order   order object
     * @param string                                    $subject user defined subject [optional]
     *
     * @return bool
     */
    public function sendSendedNowMail($order, $subject = null)
    {
        $showActions = Registry::getConfig()->getShopConfVar('mo_dhl__retoure_allow_frontend_creation');
        $creationAllowance = $showActions === AccountOrderController::MO_DHL__RETOURE_ALLOW_FRONTEND_CREATION_ALWAYS ||
            ($showActions === AccountOrderController::MO_DHL__RETOURE_ALLOW_FRONTEND_CREATION_ONLY_DHL && $order->oxorder__mo_dhl_process->rawValue);

        $user = $order->getOrderUser();

        // Only guest users have no password
        if (empty($user->oxuser__oxpassword->rawValue) && $creationAllowance) {
            $uid = md5($order->getId() . $order->getShopId() . $order->getOrderUser()->getId());
            if (Registry::getConfig()->getShopConfVar('mo_dhl__retoure_admin_approve')) {
                $this->setViewData("RetoureRequestUID", $uid);
            } else {
                $this->setViewData("RetoureCreateUID", $uid);
            }
        }

        $this->setViewData("CreationAllowance", $creationAllowance);

        return parent::sendSendedNowMail($order, $subject);
    }
}
