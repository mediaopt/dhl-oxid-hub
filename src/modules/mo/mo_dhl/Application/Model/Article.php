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
class Article extends Article_parent
{

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
        $query = "SELECT MAX(ancestor.$service) FROM oxcategories AS ancestor"
            . " LEFT JOIN oxcategories as descendant"
            . " ON ancestor.OXSHOPID = descendant.OXSHOPID"
            .    " AND ancestor.OXROOTID = descendant.OXROOTID"
            .    " AND ancestor.OXLEFT <= descendant.OXLEFT"
            .    " AND descendant.OXRIGHT <= ancestor.OXRIGHT"
            . " WHERE descendant.OXID IN ($ids)";
        return (bool) $db->getOne($query);
    }

}
