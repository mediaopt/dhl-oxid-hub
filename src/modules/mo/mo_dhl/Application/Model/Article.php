<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2020 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Application\Model;


use OxidEsales\Eshop\Core\DatabaseProvider;

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
        if (!$this->getCategoryIds()) {
            return false;
        }
        $db = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);
        $ids = implode(', ', $db->quoteArray($this->getCategoryIds()));
        $query = "SELECT MAX(parent.$service) FROM oxcategories AS parent"
            . " LEFT JOIN oxcategories as child"
            . " ON parent.OXSHOPID = child.OXSHOPID"
            .    " AND parent.OXROOTID = child.OXROOTID"
            .    " AND parent.OXLEFT <= child.OXLEFT"
            .    " AND child.OXRIGHT <= parent.OXRIGHT"
            . " WHERE child.OXID IN ($ids)";
        return (bool) $db->getOne($query);
    }

}
