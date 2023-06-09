<?php


namespace Mediaopt\DHL\Application\Controller;


use GuzzleHttp\Exception\ClientException;
use Mediaopt\DHL\Adapter\DHLAdapter;
use Mediaopt\DHL\Model\MoDHLLabel;
use Mediaopt\DHL\Shipment\RetoureRequest;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\ViewConfig;

class AccountOrderController extends AccountOrderController_parent
{

    /**
     * @var string
     */
    const MO_DHL__RETOURE_ALLOW_FRONTEND_CREATION_ALWAYS = 'ALWAYS';

    /**
     * @var string
     */
    const MO_DHL__RETOURE_ALLOW_FRONTEND_CREATION_ONLY_DHL = 'ONLY_DHL';

    /**
     * @var string
     */
    const MO_DHL__RETOURE_ALLOW_FRONTEND_CREATION_NEVER = 'NEVER';

    /**
     * @var string
     */
    const MO_DHL__DEFAULT_RETOURE_ERROR_MESSAGE = 'MO_DHL__DEFAULT_RETOURE_ERROR_MESSAGE';

    /**
     * @return string
     */
    public function moDHLCreateRetoure()
    {
        if (!$order = $this->moDHLGetOrderForRetoureCreation()) {
            return;
        }
        try {
            $retoureService = Registry::get(DHLAdapter::class)->buildRetoure();
            $response = $retoureService->createRetoure($order);
            $retoureService->handleResponse($order, $response);
        } catch (\Exception $e) {
            $this->moDHLHandleError($e->getMessage(), [
                'orderId' => $order->getId(),
                'userId' => $order->getUser()->getId(),
            ]);
        }
    }

    /**
     * @param string $error
     * @param array  $data
     */
    protected function moDHLHandleError($error, $data = [])
    {
        \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class)->getLogger()->error($error, $data);
        \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay(self::MO_DHL__DEFAULT_RETOURE_ERROR_MESSAGE);
    }

    /**
     * @return string
     */
    public function moDHLShowRetoure()
    {
        if (!$retoureId = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestEscapedParameter('retoureId')) {
            $this->moDHLHandleError('retoureId is missing');
            return 'account_order';
        }
        $data = ['retoureId' => $retoureId];
        $label = oxNew(MoDHLLabel::class);
        if (!$label->load($retoureId)) {
            $this->moDHLHandleError('could not load retoure label', $data);
            return 'account_order';
        }
        $data['orderId'] = $label->getFieldData('orderId');
        $order = oxNew(Order::class);
        if (!$order->load($data['orderId'])) {
            $this->moDHLHandleError('could not load order', $data);
            return 'account_order';
        }
        $data['userId'] = $order->getUser()->getId();
        if ($order->getUser()->getId() !== $this->getUser()->getId()) {
            $this->moDHLHandleError('invalid order for user', $data);
            return 'account_order';
        }
        if (!$label->isRetoure()) {
            $this->moDHLHandleError('label is not a retoure', $data);
            return 'account_order';
        }
        $this->moDHLDisplayRetoure($label, $data);
        return 'account_order';
    }

    /**
     * @param MoDHLLabel $label
     * @param array $data
     */
    public function moDHLDisplayRetoure($label, $data)
    {
        try {
            $format = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestEscapedParameter('format');
            $labelUrl = $format === 'qr' ? $label->getFieldData('qrLabelUrl') : $label->getFieldData('labelUrl');
            $labelFile = str_replace(Registry::get(ViewConfig::class)->getModuleUrl('mo_dhl'), Registry::get(ViewConfig::class)->getModulePath('mo_dhl'), $labelUrl);
            if (!file_exists($labelFile)) {
                $this->moDHLHandleError('label can not be loaded', $data);
                return 'account_order';
            }
            $fileType = $format === 'qr' ? 'image/jpeg' : 'application/pdf';
            $utils = \OxidEsales\Eshop\Core\Registry::getUtils();
            $utils->setHeader("Content-Type: $fileType;");
            $utils->showMessageAndExit(file_get_contents($labelFile));
        } catch (\Exception $e) {
            $this->moDHLHandleError($e->getMessage(), $data);
        }
    }

    /**
     * @param  Order $order
     * @return bool
     */
    public function moDHLCanUserCreateRetoure(Order $order)
    {
        $showActions = Registry::getConfig()->getShopConfVar('mo_dhl__retoure_allow_frontend_creation');

        $retoureDeadline = strtotime(
            '+' . Registry::getConfig()->getShopConfVar('mo_dhl__retoure_days_limit') . ' days',
            strtotime($order->oxorder__oxsenddate->value)
        );

        return ($showActions === self::MO_DHL__RETOURE_ALLOW_FRONTEND_CREATION_ALWAYS ||
            ($showActions === self::MO_DHL__RETOURE_ALLOW_FRONTEND_CREATION_ONLY_DHL && $order->oxorder__mo_dhl_process->rawValue)) &&
            time() < $retoureDeadline;
    }

    /**
     * @return bool
     */
    public function moDHLShouldUserAskForRetoure()
    {
        return Registry::getConfig()->getShopConfVar('mo_dhl__retoure_admin_approve');
    }

    /**
     * @return void
     */
    public function moDHLRetoureRequest()
    {
        if (!$orderId = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestEscapedParameter('orderId')) {
            $this->moDHLHandleError('orderId is missing');
            return;
        }

        $order = oxNew(Order::class);
        $order->load($orderId);
        if ($order->getFieldData('mo_dhl_retoure_request_status') === RetoureRequest::REQUESTED) {
            $order->setRetoureStatus(null);
        } else {
            $order->setRetoureStatus(RetoureRequest::REQUESTED);
        }
    }

    /**
     * @return Order|void
     */
    protected function moDHLGetOrderForRetoureCreation()
    {
        if (!$orderId = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestEscapedParameter('orderId')) {
            $this->moDHLHandleError('orderId is missing');
            return;
        }
        $data = ['orderId' => $orderId];
        $order = oxNew(Order::class);
        if (!$order->load($orderId)) {
            $this->moDHLHandleError('could not load order', $data);
            return;
        }
        $data['userId'] = $order->getUser()->getId();
        if ($order->getUser()->getId() !== $this->getUser()->getId()) {
            $this->moDHLHandleError('invalid order for user', $data);
            return;
        }
        if ($order->moDHLHasRetoure()) {
            $data['retoureId'] = $order->moDHLGetRetoure()->getId();
            $this->moDHLHandleError('order has a retoure already', $data);
            return;
        }
        return $order;
    }
}
