<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Model;


use Mediaopt\DHL\Api\GKV\CreationState;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Model\BaseModel;

/**
 * @author Mediaopt GmbH
 */
class MoDHLLabel extends BaseModel
{

    /**
     * Object core table name
     *
     * @var string
     */
    public $_sCoreTable = 'mo_dhl_labels';

    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = self::class;

    /**
     * @param Order         $order
     * @param CreationState $creationState
     * @return MoDHLLabel
     */
    public static function fromOrderAndCreationState(Order $order, CreationState $creationState)
    {
        $label = new self();
        $label->assign([
            'oxshopid'             => $order->getShopId(),
            'orderId'              => $order->getId(),
            'shipmentNumber'       => $creationState->getShipmentNumber(),
            'returnShipmentNumber' => $creationState->getReturnShipmentNumber(),
            'labelUrl'             => $creationState->getLabelData()->getLabelUrl(),
            'returnLabelUrl'       => $creationState->getLabelData()->getReturnLabelUrl(),
            'exportLabelUrl'       => $creationState->getLabelData()->getExportLabelUrl(),
        ]);
        return $label;
    }
}
