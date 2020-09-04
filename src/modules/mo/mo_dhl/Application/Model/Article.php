<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2020 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Application\Model;


/**
 * @author Mediaopt GmbH
 */
class Article extends \OxidEsales\Eshop\Application\Model\Article
{

    /**
     * @var string
     */
    const MO_DHL__VISUAL_AGE_CHECK16 = 'mo_dhl_visual_age_check16';

    /**
     * @var string
     */
    const MO_DHL__VISUAL_AGE_CHECK18 = 'mo_dhl_visual_age_check18';

    /**
     * @var string
     */
    const MO_DHL__BULKY_GOOD = 'mo_dhl_bulky_good';

    /**
     * @var string
     */
    const MO_DHL__IDENT_CHECK = 'mo_dhl_ident_check';

    /**
     * @var string
     */
    const MO_DHL__CASH_ON_DELIVERY = 'mo_dhl_cash_on_delivery';

    /**
     * @var string
     */
    const MO_DHL__ADDITIONAL_INSURANCE = 'mo_dhl_additional_insurance';

    /**
     * @param string $service
     * @return bool
     */
    public function moDHLUsesService(string $service) : bool
    {
        if ($this->getFieldData($service)) {
            return true;
        }
        foreach ($this->getCategoryIds() as $categoryId) {
            $category = oxNew(Category::class);
            $category->load($categoryId);
            if ($category->moDHLUsesService($service)) {
                return true;
            }
        }
        return false;
    }

}
