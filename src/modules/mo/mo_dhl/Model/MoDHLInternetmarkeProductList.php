<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Model;


/**
 * @author Mediaopt GmbH
 */
class MoDHLInternetmarkeProductList extends \OxidEsales\Eshop\Core\Model\ListModel
{
    /**
     * @var string
     */
    protected $_sObjectsInListName = MoDHLInternetmarkeProduct::class;

    /**
     * @param string[] $associatedProducts
     */
    public function loadAssociatedProducts($associatedProducts)
    {
        $labelObject = $this->getBaseObject();
        $labelTable = $labelObject->getCoreTableName();
        $fields = $labelObject->getSelectFields();
        $shopId = $this->getConfig()->getShopId();
        $statement = "('" . implode("','" , $associatedProducts) . "')";
        $sql = "SELECT $fields  FROM `$labelTable` WHERE `oxid` IN " . $statement. " AND `oxshopid` = ?";

        $this->selectString($sql, [$shopId]);
    }
}
