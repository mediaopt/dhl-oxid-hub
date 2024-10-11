<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Model;


use Mediaopt\DHL\Api\Internetmarke\ShoppingCartResponseType;
use Mediaopt\DHL\Api\Retoure\RetoureResponse;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Field;
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
     * @param Order $order
     * @param array $item
     * @return MoDHLLabel
     */
    public static function fromOrderAndParcelShippingResponseItem(Order $order, array $item)
    {
        $label = new self();
        $label->assign(array_filter([
            'oxshopid'             => $order->getShopId(),
            'orderId'              => $order->getId(),
            'type'                 => self::TYPE_DELIVERY,
            'shipmentNumber'       => $item['shipmentNo'],
            'returnShipmentNumber' => $item['returnShipmentNo'] ?: $item['shipmentNo'],
            'labelUrl'             => $item['label']['url'],
            'returnLabelUrl'       => $item['returnLabel']['url'] ?? null,
            'exportLabelUrl'       => $item['customsDoc']['url'],
        ]));
        return $label;
    }

    /**
     * @param Order                    $order
     * @param ShoppingCartResponseType $creationState
     * @return MoDHLLabel
     */
    public static function fromOrderAndInternetmarkeResponse(Order $order, ShoppingCartResponseType $internetmarkeResponse)
    {
        $label = new self();
        $label->assign([
            'oxshopid'       => $order->getShopId(),
            'orderId'        => $order->getId(),
            'type'           => self::TYPE_DELIVERY,
            'shipmentNumber' => $internetmarkeResponse->getShoppingCart()->getShopOrderId(),
            'labelUrl'       => $internetmarkeResponse->getLink(),
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
        $label->storeData(
            $retoureResponse->getShipmentNumber() . '.pdf',
            base64_decode($retoureResponse->getLabelData())
        );
        $fileName = 'documents' . DIRECTORY_SEPARATOR . $retoureResponse->getShipmentNumber();
        $label->assign([
            'oxshopid'       => $order->getShopId(),
            'orderId'        => $order->getId(),
            'type'           => self::TYPE_RETOURE,
            'shipmentNumber' => $retoureResponse->getShipmentNumber(),
            'labelUrl'       => Registry::get(ViewConfig::class)->getModuleUrl('mo_dhl', $fileName . '.pdf'),
        ]);

        if (!empty($retoureResponse->getQrLabelData())) {
            $label->storeData(
                $retoureResponse->getShipmentNumber() . '.jpeg',
                base64_decode($retoureResponse->getQrLabelData())
            );
            $label->assign([
                'qrLabelUrl' => Registry::get(ViewConfig::class)->getModuleUrl('mo_dhl', $fileName . '.jpeg'),
            ]);
        }

        return $label;
    }

    /**
     * @param string $fileName
     * @param array  $data
     * @throws \OxidEsales\EshopCommunity\Core\Exception\FileException
     */
    protected function storeData($fileName, $data)
    {
        $path = Registry::get(ViewConfig::class)->getModulePath('mo_dhl', 'documents');
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
     * @param null|string $oxid
     * @return bool
     */
    public function delete($oxid = null)
    {
        if ($oxid) {
            $this->load($oxid);
        }
        $this->deleteData($this->getFieldData('shipmentNumber') . '.pdf');
        if ($this->isRetoure()) {
            $this->deleteData($this->getFieldData('shipmentNumber') . '.jpeg');
        }
        if ($this->isDelivery()) {
            $order = oxNew(Order::class);
            $order->load($this->getFieldData('orderId'));
            if ($this->getFieldData('shipmentNumber') === $order->getFieldData('oxtrackcode')) {
                $order->oxorder__oxtrackcode = oxNew(Field::class, '');
                $order->save();
            }
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
     * @param string $orderId
     * @param string $shipmentNumber
     *
     * @return bool
     */
    public function loadByOrderAndTrackingNumber($orderId, $shipmentNumber)
    {
        $this->_addField('oxid', 0);
        $query = $this->buildSelectString([
            $this->getViewName() . '.orderId'        => $orderId,
            $this->getViewName() . '.shipmentNumber' => $shipmentNumber,
        ]);
        $this->_isLoaded = $this->assignRecord($query);

        return $this->_isLoaded;
    }
}
