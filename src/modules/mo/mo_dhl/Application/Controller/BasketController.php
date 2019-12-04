<?php

namespace Mediaopt\DHL\Application\Controller;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

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
    public function moDHLGetSurchargeTranslation($textVarName)
    {
        $wunschpaket = Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        $langId = $this->moDHLGetCurrentLanguage();
        switch ($textVarName) {
            case 'mo_dhl__wunschtag_surcharge_text':
                return $wunschpaket->getWunschtagText($langId);
            case 'mo_dhl__wunschzeit_surcharge_text':
                return $wunschpaket->getWunschzeitText($langId);
            default:
                return $wunschpaket->getWunschtagWunschzeitText($langId);
        }
    }

}
