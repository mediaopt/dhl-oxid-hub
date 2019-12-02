<?php

namespace Mediaopt\DHL\Application\Controller;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Mediaopt\DHL\Api\Wunschpaket;
use OxidEsales\Eshop\Core\Registry;

/** @noinspection LongInheritanceChainInspection */

/**
 * This class extends the basket class with Wunschpaket features.
 *
 * @author Mediaopt GmbH
 */
class BasketController extends BasketController_parent
{

    /**
     * @return string
     */
    public function moDHLGetCurrentLanguage()
    {
        return Registry::getLang()->getTplLanguage();
    }

    /**
     * @param string $textVarName
     * @return string
     */
    public function moDHLGetPlaceholder($textVarName)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        $langId = $this->moDHLGetCurrentLanguage();
        switch ($textVarName) {
            case 'mo_dhl__wunschtag_surcharge_text':
                $snippet = 'MO_DHL__WUNSCHTAG_COSTS';
                $translation = $wunschpaket->getWunschtagText($langId);
                break;
            case 'mo_dhl__wunschzeit_surcharge_text':
                $snippet = 'MO_DHL__WUNSCHZEIT_COSTS';
                $translation = $wunschpaket->getWunschzeitText($langId);
                break;
            default:
                $snippet = 'MO_DHL__COMBINATION_SURCHARGE';
                $translation = $wunschpaket->getWunschtagWunschzeitText($langId);
        }

        $snippet .= Registry::getConfig()->getConfigParam('blShowVATForDelivery') ? '_NET' : '_GROSS';
        $snippetTranslation = Registry::getLang()->translateString($snippet, $langId, false);
        return $translation === '' ? $snippetTranslation : $translation;
    }

}
