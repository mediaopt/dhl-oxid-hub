<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Model;


use Mediaopt\DHL\Api\GKV\CreationState;
use Mediaopt\DHL\Api\Retoure\RetoureResponse;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\ViewConfig;

/**
 * @author Mediaopt GmbH
 */
class MoDHLLabel extends BaseModel
{

    /**
     * @var string
     */
    const TYPE_DELIVERY = 'delivery';

    /**
     * @var string
     */
    const TYPE_RETOURE = 'retoure';

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
     */
    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

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
            'type'                 => self::TYPE_DELIVERY,
            'shipmentNumber'       => $creationState->getShipmentNumber(),
            'returnShipmentNumber' => $creationState->getReturnShipmentNumber(),
            'labelUrl'             => $creationState->getLabelData()->getLabelUrl(),
            'returnLabelUrl'       => $creationState->getLabelData()->getReturnLabelUrl(),
            'exportLabelUrl'       => $creationState->getLabelData()->getExportLabelUrl(),
        ]);
        return $label;
    }

    /**
     * @param Order           $order
     * @param RetoureResponse $retoureResponse
     * @return MoDHLLabel
     */
    public static function fromOrderAndRetoure(Order $order, RetoureResponse $retoureResponse)
    {
        $label = new self();
        $label->storeData($retoureResponse->getShipmentNumber() . '.jpeg', $retoureResponse->getQrLabelData());
        $label->storeData($retoureResponse->getShipmentNumber() . '.pdf', $retoureResponse->getLabelData());
        $label->assign([
            'oxshopid'             => $order->getShopId(),
            'orderId'              => $order->getId(),
            'type'                 => self::TYPE_RETOURE,
            'shipmentNumber'       => $retoureResponse->getShipmentNumber(),
            'labelUrl'             => Registry::get(ViewConfig::class)->getModuleUrl('mo_dhl', 'documents' . DIRECTORY_SEPARATOR . $retoureResponse->getShipmentNumber() . '.pdf'),
            'qrLabelUrl'             => Registry::get(ViewConfig::class)->getModuleUrl('mo_dhl', 'documents' . DIRECTORY_SEPARATOR . $retoureResponse->getShipmentNumber() . '.jpeg'),
        ]);
        return $label;
    }

    protected function storeData($fileName, $data)
    {
        $path = Registry::get(ViewConfig::class)->getModulePath('mo_dhl', 'documents');
        file_put_contents($path . DIRECTORY_SEPARATOR . $fileName, base64_decode($data));
    }

    protected function deleteData($fileName)
    {
        $path = Registry::get(ViewConfig::class)->getModulePath('mo_dhl', 'documents');
        unlink($path . DIRECTORY_SEPARATOR . $fileName);
    }

    /**
     * @param  null|string $oxid
     * @return bool
     */
    public function delete($oxid = null)
    {
        if ($oxid) {
            $this->load($oxid);
        }
        if ($this->isRetoure()) {
            $this->deleteData($this->getFieldData('shipmentNumber') . '.jpeg');
            $this->deleteData($this->getFieldData('shipmentNumber') . '.pdf');
        }
        return parent::delete();
    }

    /**
     * @return bool
     */
    public function isRetoure()
    {
        return $this->getFieldData('type') === self::TYPE_RETOURE;
    }

    /**
     * @return bool
     */
    public function isDelivery()
    {
        return $this->getFieldData('type') === self::TYPE_DELIVERY;
    }
}
