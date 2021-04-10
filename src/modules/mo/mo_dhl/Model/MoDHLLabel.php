<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Model;


use Mediaopt\DHL\Api\GKV\CreationState;
use Mediaopt\DHL\Api\Internetmarke\ShoppingCartResponseType;
use Mediaopt\DHL\Api\Retoure\RetoureResponse;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\ViewConfig;
use Mediaopt\DHL\Api\Warenpost\WarenpostResponse;

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
     * @var string
     */
    const TYPE_WARENPOST = 'warenpost';

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
     * @param Order         $order
     * @param ShoppingCartResponseType $creationState
     * @return MoDHLLabel
     */
    public static function fromOrderAndInternetmarkeResponse(Order $order, ShoppingCartResponseType $internetmarkeResponse)
    {
        $label = new self();
        $label->assign([
            'oxshopid'             => $order->getShopId(),
            'orderId'              => $order->getId(),
            'type'                 => self::TYPE_DELIVERY,
            'shipmentNumber'       => $internetmarkeResponse->getShoppingCart()->getShopOrderId(),
            'labelUrl'             => $internetmarkeResponse->getLink(),
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
        $label->storeData($retoureResponse->getShipmentNumber() . '.pdf', $retoureResponse->getLabelData());
        $fileName = 'documents' . DIRECTORY_SEPARATOR . $retoureResponse->getShipmentNumber();
        $label->assign([
            'oxshopid'       => $order->getShopId(),
            'orderId'        => $order->getId(),
            'type'           => self::TYPE_RETOURE,
            'shipmentNumber' => $retoureResponse->getShipmentNumber(),
            'labelUrl'       => Registry::get(ViewConfig::class)->getModuleUrl('mo_dhl', $fileName . '.pdf'),
        ]);

        if (!empty($retoureResponse->getQrLabelData())) {
            $label->storeData($retoureResponse->getShipmentNumber() . '.jpeg', $retoureResponse->getQrLabelData());
            $label->assign([
                'qrLabelUrl' => Registry::get(ViewConfig::class)->getModuleUrl('mo_dhl', $fileName . '.jpeg'),
            ]);
        }

        return $label;
    }

    /**
     * @param Order           $order
     * @param WarenpostResponse $warenpostResponse
     * @return MoDHLLabel
     */
    public static function fromOrderAndWarenpost(Order $order, WarenpostResponse $warenpostResponse): MoDHLLabel
    {
        $label = new self();
        $label->storeData(
            $warenpostResponse->getShipmentNumber() . '.pdf',
            $warenpostResponse->getLabelData(),
            false
        );
        $fileName = 'documents' . DIRECTORY_SEPARATOR . $warenpostResponse->getShipmentNumber();
        $label->assign([
            'oxshopid'       => $order->getShopId(),
            'orderId'        => $order->getId(),
            'type'           => self::TYPE_WARENPOST,
            'shipmentNumber' => $warenpostResponse->getShipmentNumber(),
            'labelUrl'       => Registry::get(ViewConfig::class)->getModuleUrl('mo_dhl', $fileName . '.pdf'),
        ]);

        return $label;
    }

    /**
     * @param string $fileName
     * @param array  $data
     * @param bool $decode
     * @throws \OxidEsales\EshopCommunity\Core\Exception\FileException
     */
    protected function storeData($fileName, $data, $decode = true)
    {
        $path = Registry::get(ViewConfig::class)->getModulePath('mo_dhl', 'documents');
        if ($decode) {
            $data = base64_decode($data);
        }
        file_put_contents($path . DIRECTORY_SEPARATOR . $fileName, $data);
    }

    /**
     * @param string $fileName
     * @throws \OxidEsales\EshopCommunity\Core\Exception\FileException
     */
    protected function deleteData($fileName)
    {
        $path = Registry::get(ViewConfig::class)->getModulePath('mo_dhl', 'documents');
        if (is_file($path . DIRECTORY_SEPARATOR . $fileName)) {
            unlink($path . DIRECTORY_SEPARATOR . $fileName);
        }
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
        if ($this->isDelivery()) {
            $order = oxNew(Order::class);
            $order->load($this->getFieldData('orderId'));
            if ($this->getFieldData('shipmentNumber') === $order->getFieldData('oxtrackcode')) {
                $order->oxorder__oxtrackcode = oxNew(Field::class, '');
                $order->save();
            }
        }
        if ($this->isWarenpost()){
            $this->deleteData($this->getFieldData('shipmentNumber') . '.pdf');
        }
        return parent::delete();
    }

    /**
     * @inheritDoc
     */
    public function save()
    {
        if ($this->isDelivery()) {
            $order = oxNew(Order::class);
            $order->load($this->getFieldData('orderId'));
            $order->oxorder__oxtrackcode = oxNew(Field::class, $this->getFieldData('shipmentNumber'));
            $order->save();
        }
        return parent::save();
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

    /**
     * @return bool
     */
    public function isWarenpost(): bool
    {
        return $this->getFieldData('type') === self::TYPE_WARENPOST;
    }

    /**
     * @param string $orderId
     * @param string $shipmentNumber
     *
     * @return bool
     */
    public function loadByOrderAndTrackingNumber($orderId, $shipmentNumber)
    {
        $this->_addField('oxid', 0);
        $query = $this->buildSelectString([
            $this->getViewName() . '.orderId' => $orderId,
            $this->getViewName() . '.shipmentNumber' => $shipmentNumber,
            ]);
        $this->_isLoaded = $this->assignRecord($query);

        return $this->_isLoaded;
    }
}
