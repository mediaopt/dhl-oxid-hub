<?php

namespace Mediaopt\DHL\Application\Controller\Admin;

use Mediaopt\DHL\Api\Wunschpaket;
/**
 * @author Mediaopt GmbH
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

        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        /** @var \OxidEsales\Eshop\Application\Model\Order $order */
        $order = $this->_aViewData['edit'];
        $remark = $order->oxorder__oxremark->value;
        $remarks = array_filter([
            $this->moDHLGetPreferredDay($remark),
            $this->moDHLGetPreferredLocation($remark),
            $this->moDHLGetPreferredNeighbour($remark),
            $wunschpaket->removeWunschpaketTags($remark),
        ]);
        $order->oxorder__oxremark->value = implode('<br/>', $remarks);
        return $template;
    }

    /**
     * @param string $remark
     * @return string
     */
    protected function moDHLGetPreferredDay($remark)
    {
        $language = \OxidEsales\Eshop\Core\Registry::getLang();
        $preferredDay = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->extractWunschtag($remark);
        return $preferredDay !== '' ? "{$language->translateString('MO_DHL__WUNSCHTAG')}: {$preferredDay}" : '';
    }

    /**
     * @param string $remark
     * @return string
     */
    protected function moDHLGetPreferredLocation($remark)
    {
        list($type, $location) = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class)->extractLocation($remark);
        if ($type !== Wunschpaket::WUNSCHORT) {
            return '';
        }
        $lang = \OxidEsales\Eshop\Core\Registry::getLang();
        return "{$lang->translateString('MO_DHL__WUNSCHORT')}: {$location}";
    }

    /**
     * @param string $remark
     * @return string
     */
    protected function moDHLGetPreferredNeighbour($remark)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        list($type, $neighbourAddress, $neighbourName) = $wunschpaket->extractLocation($remark);
        if ($type !== Wunschpaket::WUNSCHNACHBAR) {
            return '';
        }
        $lang = \OxidEsales\Eshop\Core\Registry::getLang();
        return "{$lang->translateString('MO_DHL__WUNSCHNACHBAR')}: {$neighbourName}, {$neighbourAddress}";
    }
}
