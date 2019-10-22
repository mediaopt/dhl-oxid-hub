<?php

namespace Mediaopt\DHL\Application\Controller\Admin;

use Mediaopt\Empfaengerservices\Api\Wunschpaket;
/**
 * @author derksen mediaopt GmbH
 */
class OrderOverview extends OrderOverview_parent
{
    /**
     * @return string
     */
    public function render()
    {
        $template = parent::render();
        if (!array_key_exists('edit', $this->_aViewData)) {
            return $template;
        }

        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        /** @var \OxidEsales\Eshop\Application\Model\Order $order */
        $order = $this->_aViewData['edit'];
        $remark = $order->oxorder__oxremark->value;
        $remarks = array_filter([$this->moEmpfaengerservicesGetPreferredDay($remark), $this->moEmpfaengerservicesGetPreferredTime($remark), $this->moEmpfaengerservicesGetPreferredLocation($remark), $this->moEmpfaengerservicesGetPreferredNeighbour($remark), $wunschpaket->removeWunschpaketTags($remark)]);
        $order->oxorder__oxremark->value = implode('<br/>', $remarks);
        return $template;
    }

    /**
     * @param string $remark
     * @return string
     */
    protected function moEmpfaengerservicesGetPreferredDay($remark)
    {
        $language = \OxidEsales\Eshop\Core\Registry::getLang();
        $preferredDay = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->extractWunschtag($remark);
        return $preferredDay !== '' ? "{$language->translateString('MO_EMPFAENGERSERVICES__WUNSCHTAG')}: {$preferredDay}" : '';
    }

    /**
     * @param string $remark
     * @return string
     */
    protected function moEmpfaengerservicesGetPreferredTime($remark)
    {
        $label = \OxidEsales\Eshop\Core\Registry::getLang()->translateString('MO_EMPFAENGERSERVICES__WUNSCHZEIT');
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        $preferredTime = $wunschpaket->extractTime($remark);
        return $preferredTime !== '' ? "{$label}: " . Wunschpaket::formatPreferredTime($preferredTime) : '';
    }

    /**
     * @param string $remark
     * @return string
     */
    protected function moEmpfaengerservicesGetPreferredLocation($remark)
    {
        list($type, $location) = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class)->extractLocation($remark);
        if ($type !== Wunschpaket::WUNSCHORT) {
            return '';
        }
        $lang = \OxidEsales\Eshop\Core\Registry::getLang();
        return "{$lang->translateString('MO_EMPFAENGERSERVICES__WUNSCHORT')}: {$location}";
    }

    /**
     * @param string $remark
     * @return string
     */
    protected function moEmpfaengerservicesGetPreferredNeighbour($remark)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
        list($type, $neighbourAddress, $neighbourName) = $wunschpaket->extractLocation($remark);
        if ($type !== Wunschpaket::WUNSCHNACHBAR) {
            return '';
        }
        $lang = \OxidEsales\Eshop\Core\Registry::getLang();
        return "{$lang->translateString('MO_EMPFAENGERSERVICES__WUNSCHNACHBAR')}: {$neighbourName}, {$neighbourAddress}";
    }
}