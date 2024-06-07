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
class Category extends Category_parent
{

    /**
     * @param string $service
     * @return bool
     */
    public function moDHLUsesService(string $service) : bool
    {
        $db = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);
        $query = "SELECT MAX($service) from oxcategories where OXSHOPID = ? AND OXROOTID = ? AND  OXLEFT <= ? AND ? <= OXRIGHT";
        $result = $db->getOne($query, [$this->oxcategories__oxshopid->value, $this->oxcategories__oxrootid->value, $this->oxcategories__oxleft->value, $this->oxcategories__oxright->value]);
        return (bool) $result;
    }
}
