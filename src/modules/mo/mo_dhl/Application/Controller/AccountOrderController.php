<?php


namespace Mediaopt\DHL\Application\Controller;


use GuzzleHttp\Exception\ClientException;
use Mediaopt\DHL\Adapter\DHLAdapter;
use Mediaopt\DHL\Model\MoDHLLabel;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\ViewConfig;

class AccountOrderController extends AccountOrderController_parent
{

    const MO_DHL__RETOURE_ALLOW_FRONTEND_CREATION_ALWAYS = 'ALWAYS';
    const MO_DHL__RETOURE_ALLOW_FRONTEND_CREATION_ONLY_DHL = 'ONLY_DHL';
    const MO_DHL__RETOURE_ALLOW_FRONTEND_CREATION_NEVER = 'NEVER';

    const MO_DHL__DEFAULT_RETOURE_ERROR_MESSAGE = 'MO_DHL__DEFAULT_RETOURE_ERROR_MESSAGE';

    public function moDHLCreateRetoure()
    {
        if (!$orderId = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestEscapedParameter('orderId')) {
            $this->handleError('orderId is missing');
            return 'account_order';
        }
        $data = ['orderId' => $orderId];
        $order = oxNew(Order::class);
        if (!$order->load($orderId)) {
            $this->handleError('could not load order', $data);
            return 'account_order';
        }
        $data['userId'] = $order->getUser()->getId();
        if ($order->getUser()->getId() !== $this->getUser()->getId()) {
            $this->handleError('invalid order for user', $data);
            return 'account_order';
        }
        if ($order->moDHLHasRetoure()) {
            $data['retoureId'] = $order->moDHLGetRetoure()->getId();
            $this->handleError('order has a retoure already', $data);
            return 'account_order';
        }
        $this->createRetoure($order, $data);
        return 'account_order';
    }

    protected function handleError($error, $data = [])
    {
        \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class)->getLogger()->error($error, $data);
        \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay(self::MO_DHL__DEFAULT_RETOURE_ERROR_MESSAGE);
    }

    public function createRetoure($order, $data)
    {
        try {
            $retoureService = Registry::get(DHLAdapter::class)->buildRetoure();
            $response = $retoureService->createRetoure($order);
            $retoureService->handleResponse($order, $response);
        } catch (\Exception $e) {
            $this->handleError($e->getMessage(), $data);
            return;
        }
    }

    public function moDHLShowRetoure()
    {
        if (!$retoureId = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestEscapedParameter('retoureId')) {
            $this->handleError('retoureId is missing');
            return 'account_order';
        }
        $data = ['retoureId' => $retoureId];
        $label = oxNew(MoDHLLabel::class);
        if (!$label->load($retoureId)) {
            $this->handleError('could not load retoure label', $data);
            return 'account_order';
        }
        $data['orderId'] = $label->getFieldData('orderId');
        $order = oxNew(Order::class);
        if (!$order->load($data['orderId'])) {
            $this->handleError('could not load order', $data);
            return 'account_order';
        }
        $data['userId'] = $order->getUser()->getId();
        if ($order->getUser()->getId() !== $this->getUser()->getId()) {
            $this->handleError('invalid order for user', $data);
            return 'account_order';
        }
        if (!$label->isRetoure()) {
            $this->handleError('label is not a retoure', $data);
            return 'account_order';
        }
        $this->displayRetoure($label, $data);
        return 'account_order';
    }

    /**
     * @param MoDHLLabel $label
     * @param array $data
     */
    public function displayRetoure($label, $data)
    {
        try {
            $format = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestEscapedParameter('format');
            $labelUrl = $format === 'qr' ? $label->getFieldData('qrLabelUrl') : $label->getFieldData('labelUrl');
            $labelFile = str_replace(Registry::get(ViewConfig::class)->getModuleUrl('mo_dhl'), Registry::get(ViewConfig::class)->getModulePath('mo_dhl'), $labelUrl);
            if (!file_exists($labelFile)) {
                $this->handleError('label can not be loaded', $data);
                return 'account_order';
            }
            $fileType = $format === 'qr' ? 'image/jpeg' : 'application/pdf';
            \OxidEsales\Eshop\Core\Registry::getUtils()->setHeader("Content-Type: $fileType;");
            echo file_get_contents($labelFile);die;
        } catch (\Exception $e) {
            $this->handleError($e->getMessage(), $data);
            return;
        }
    }

    public function moDHLShowRetoureActions($order)
    {
        $showActions = Registry::getConfig()->getShopConfVar('mo_dhl__retoure_allow_frontend_creation');
        return $showActions === self::MO_DHL__RETOURE_ALLOW_FRONTEND_CREATION_ALWAYS ||
            ($showActions === self::MO_DHL__RETOURE_ALLOW_FRONTEND_CREATION_ONLY_DHL && $order->oxorder__mo_dhl_process->rawValue);
    }
}
