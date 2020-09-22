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
class MoDHLLabelList extends \OxidEsales\Eshop\Core\Model\ListModel
{
    /**
     * List Object class name
     *
     * @var string
     */
    protected $_sObjectsInListName = MoDHLLabel::class;

    /**
     * @param string|array $orderIds
     */
    public function loadOrderLabels($orderIds)
    {
        $labelObject = $this->getBaseObject();
        $labelTable = $labelObject->getCoreTableName();
        $fields = $labelObject->getSelectFields();
        $shopId = $this->getConfig()->getShopId();

        if (is_array($orderIds)) {
            $statement = "('" . implode("','" , $orderIds) . "')";
            $sql = "SELECT $fields  FROM `$labelTable` WHERE `orderId` IN " . $statement. " AND `oxshopid` = ?";

            $this->selectString($sql, [$shopId]);
        } else {
            $sql = "SELECT $fields  FROM `$labelTable` WHERE `orderid` = ? AND `oxshopid` = ?";
            $this->selectString($sql, [$orderIds, $shopId]);
        }
    }
}
