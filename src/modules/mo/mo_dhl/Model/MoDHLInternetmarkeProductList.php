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

    /**
     * @param string $searchText
     */
    public function searchForProduct($searchText)
    {
        $baseModel = $this->getBaseObject();
        $productTable = $baseModel->getCoreTableName();
        $fields = $baseModel->getSelectFields();
        $shopId = $this->getConfig()->getShopId();
        $sql = "SELECT $fields  FROM `$productTable` WHERE `name` like ? AND `oxshopid` = ? and type = ?";
        $this->selectString($sql, ["%$searchText%", $shopId, MoDHLInternetmarkeProduct::INTERNETMARKE_PRODUCT_TYPE_SALES]);
    }
}
