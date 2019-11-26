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
     * @param string $orderId
     */
    public function loadOrderLabels($orderId)
    {
        $labelObject = $this->getBaseObject();
        $labelTable = $labelObject->getCoreTableName();
        $fields = $labelObject->getSelectFields();
        $shopId = $this->getConfig()->getShopId();

        $sql = "SELECT $fields  FROM `$labelTable` WHERE `orderid` = ? AND `oxshopid` = ?";
        $this->selectString($sql, [$orderId, $shopId]);
    }
}
