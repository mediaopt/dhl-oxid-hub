<?php

namespace Mediaopt\DHL\Controller\Admin;

use GuzzleHttp\Exception\ClientException;
use Mediaopt\DHL\Adapter\DHLAdapter;
use Mediaopt\DHL\Adapter\GKVCreateShipmentOrderRequestBuilder;
use Mediaopt\DHL\Adapter\GKVCustomShipmentBuilder;
use Mediaopt\DHL\Adapter\InternetmarkeRefundRetoureVouchersRequestBuilder;
use Mediaopt\DHL\Adapter\InternetmarkeShoppingCartPDFRequestBuilder;
use Mediaopt\DHL\Adapter\ParcelShippingConverter;
use Mediaopt\DHL\Api\GKV\CreateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\CreateShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\DeleteShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\DeleteShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\StatusCode;
use Mediaopt\DHL\Api\Internetmarke\ShoppingCartResponseType;
use Mediaopt\DHL\Api\ParcelShipping\Client;
use Mediaopt\DHL\Api\Wunschpaket;
use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Model\MoDHLInternetmarkeRefund;
use Mediaopt\DHL\Model\MoDHLLabel;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;
use Mediaopt\DHL\Shipment\RetoureRequest;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Mediaopt GmbH
 */
class OrderDHLController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{

    use ErrorDisplayTrait;

    /**
     * @var Order|null
     */
    protected $order;

    /**
     * @var \Mediaopt\DHL\Wunschpaket
     */
    protected $wunschpaket;


    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = 'mo_dhl__order_dhl.tpl';

    /**
     * @extend
     * @return string
     */
    public function render()
    {
        $templateName = parent::render();
        $this->addTplParam('processes', Process::getAvailableProcesses());
        $this->addTplParam('ekp', $this->getEkp());
        $this->addTplParam('participationNumber', $this->getParticipationNumber());
        $this->addTplParam('operator', $this->getOperator());
        $this->addTplParam('process', $this->getProcess());
        $this->addTplParam('remarks', $this->getRemarks());
        $this->addTplParam('labels', $this->getOrder()->moDHLGetLabels());
        if (Registry::getConfig()->getShopConfVar('mo_dhl__retoure_admin_approve')) {
            $this->addTplParam('RetoureRequestStatuses', RetoureRequest::getRetoureRequestStatuses());
            $this->addTplParam('RetoureRequestStatus', $this->getRetoureRequestStatus());
        }

        return $templateName;
    }

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function createLabel()
    {
        try {
            if ($this->usesInternetmarke()) {
                $this->createInternetmarkeLabel();
                return;
            }
            $shipmentOrderRequest = $this->buildShipmentOrderRequest();
            if ($this->usesParcelShippingAPI()) {
                $this->createShipmentOrderWithParcelShipping($shipmentOrderRequest);
            } else {
                $this->createShipmentOrderWithGKV($shipmentOrderRequest);
            }
        } catch (\Exception $e) {
            $this->displayErrors($e);
        }

    }

    /**
     * @param Order|null $order
     */
    public function createRetoure($order = null)
    {
        try {
            if (!isset($order)) {
                $order = $this->getOrder();
            }

            $retoureService = Registry::get(DHLAdapter::class)->buildRetoure();
            $response = $retoureService->createRetoure($order);
            $retoureService->handleResponse($order, $response);

            if (isset($order->oxorder__mo_dhl_retoure_request_status->rawValue)) {
                $order->setRetoureStatus(RetoureRequest::CREATED);
            }
        } catch (\Exception $e) {
            $errors = [
                $e->getMessage(),
            ];
            if (!($previous = $e->getPrevious()) || !$previous instanceof ClientException) {
                $this->displayErrors($errors);
                return;
            }
            $response = $previous->getResponse();
            if (!$response->getBody()) {
                $this->displayErrors($errors);
                return;
            }
            $data = json_decode($response->getBody()->getContents());
            if ($data->detail) {
                $errors[] = $data->detail;
            }
            $this->displayErrors($errors);
        }
    }

    /**
     * template method: create label from custom input
     *
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function createCustomLabel()
    {
        try {
            $request = $this->buildShipmentOrderRequest();
            $shipmentOrder = $request->getShipmentOrder()[0];
            $data = Registry::getConfig()->getRequestParameter('data');

            $customShipmentBuilder = new GKVCustomShipmentBuilder();
            $customShipmentBuilder->applyCustomDataToShipmentOrder($shipmentOrder, $data, $this->getOrder());

            $this->addTplParam('shipmentOrder', $customShipmentBuilder->toCustomizableParametersArray($shipmentOrder));
            $this->setTemplateName('mo_dhl__order_dhl_custom_label.tpl');

            if ($this->usesParcelShippingAPI()) {
                $this->createShipmentOrderWithParcelShipping($request);
            } else {
                $this->createShipmentOrderWithGKV($request);
            }

        } catch (\Exception $e) {
            $this->displayErrors($e);
        }

    }

    /**
     * template method: prepare data for customization
     *
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function prepareCustomLabel()
    {
        $shipmentOrder = $this->buildShipmentOrderRequest()->getShipmentOrder()[0];
        $customShipmentBuilder = new GKVCustomShipmentBuilder();
        $this->addTplParam('shipmentOrder', $customShipmentBuilder->toCustomizableParametersArray($shipmentOrder));
        $this->setTemplateName('mo_dhl__order_dhl_custom_label.tpl');
    }

    /**
     */
    public function deleteShipment()
    {
        try {
            $label = \oxNew(MoDHLLabel::class);
            $label->load(Registry::getConfig()->getRequestParameter('labelId'));
            if ($label->isRetoure()) {
                $label->delete();

                $order = $this->getOrder();
                if ($order->oxorder__mo_dhl_retoure_request_status->rawValue === RetoureRequest::CREATED) {
                    $order->setRetoureStatus(RetoureRequest::REQUESTED);
                }

                return;
            }
            if ($this->usesInternetmarke()) {
                $this->refundInternetmarkeLabel($label);
            } elseif ($this->usesParcelShippingAPI()) {
                $this->deleteShipmentWithParcelShipping($label);
            } else {
                $this->deleteShipmentWithGKV($label);
            }
        } catch (\Exception $e) {
            $this->displayErrors($e);
        }
    }

    /**
     * @param MoDHLLabel $label
     */
    protected function refundInternetmarkeLabel($label)
    {
        try {
            $shipmentNumber = $label->getFieldData('shipmentNumber');
            $internetMarkeRefund = Registry::get(DHLAdapter::class)->buildInternetmarkeRefund();
            $response = $internetMarkeRefund->retoureVouchers((new InternetmarkeRefundRetoureVouchersRequestBuilder())->build($shipmentNumber));
            $refund = MoDHLInternetmarkeRefund::fromRetoureVouchersResponse($response);
            $refund->save();
            $label->delete();
            $message = sprintf(Registry::getLang()->translateString('MO_DHL__INTERNETMARKE_REFUND_REQUESTED_MESSAGE'), $response->getRetoureTransactionId());
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($message);
        } catch (\Exception $e) {
            $errors = $this->parseInternetmarkeException($e);
            $this->displayErrors($errors);
        }
    }

    /**
     * @param string $shipmentNumber
     * @return DeleteShipmentOrderResponse
     */
    public function callGKVDeleteShipment(string $shipmentNumber): DeleteShipmentOrderResponse
    {
        $gkvClient = Registry::get(DHLAdapter::class)->buildGKV();
        return $gkvClient->deleteShipmentOrder(new DeleteShipmentOrderRequest($gkvClient->buildVersion(), $shipmentNumber));
    }

    /**
     * @return string
     */
    protected function getEkp()
    {
        return (string)Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('ekp')
            ?: (string)$this->getOrder()->oxorder__mo_dhl_ekp->rawValue
                ?: (string)Registry::getConfig()->getConfigParam('mo_dhl__merchant_ekp');
    }

    /**
     * @return Order
     */
    protected function getOrder()
    {
        if ($this->order !== null) {
            return $this->order;
        }

        $this->order = \oxNew(Order::class);
        $this->order->load($this->getEditObjectId());
        return $this->order;
    }

    /**
     * @param Order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return string
     */
    protected function getParticipationNumber()
    {
        return (string)Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('participationNumber')
            ?: (string)$this->getOrder()->oxorder__mo_dhl_participation->rawValue;
    }

    /**
     * @return Process|null
     */
    protected function getProcess()
    {
        if ($processNr = $this->getOrder()->oxorder__mo_dhl_process->rawValue) {
            return Process::build($processNr);
        }
        return null;
    }

    /**
     * @return string
     */
    protected function getOperator()
    {
        return (string)$this->getOrder()->oxorder__mo_dhl_operator->rawValue;
    }

    /**
     * @return string|null
     */
    protected function getRetoureRequestStatus()
    {
        if ($RetoureRequestStatus = $this->getOrder()->oxorder__mo_dhl_retoure_request_status->rawValue) {
            return RetoureRequest::build($RetoureRequestStatus);
        }
        return null;
    }

    /**
     */
    public function save()
    {
        try {
            $db = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);
            $information = [
                'MO_DHL_EKP'                    => $this->validateEkp(),
                'MO_DHL_PROCESS'                => $this->validateProcessIdentifier(),
                'MO_DHL_PARTICIPATION'          => $this->validateParticipationNumber(),
                'MO_DHL_OPERATOR'               => Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('operator'),
                'MO_DHL_RETOURE_REQUEST_STATUS' => Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('retoureRequest'),
            ];
            $tuples = [];
            foreach ($information as $column => $value) {
                if (empty($value)) {
                    continue;
                }
                $tuples[] = "{$column} = {$db->quote($value)}";
            }
            if ($tuples === []) {
                return;
            }
            $viewNameGenerator = Registry::get(\OxidEsales\Eshop\Core\TableViewNameGenerator::class);
            $viewName = $viewNameGenerator->getViewName('oxorder');
            $query = ' UPDATE ' . $viewName . ' SET ' . implode(', ', $tuples) . " WHERE OXID = {$db->quote($this->getEditObjectId())}";
            $db->execute($query);
        } catch (\Exception $e) {
            $this->displayErrors($e);
        }

    }

    /**
     * @return string
     */
    protected function validateEkp()
    {
        try {
            $ekp = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('ekp');
            Ekp::build($ekp);
            return $ekp;
        } catch (\InvalidArgumentException $exception) {
            /** @noinspection PhpParamsInspection */
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__EKP_ERROR');
            return '';
        }
    }

    /**
     * @return string
     */
    protected function validateProcessIdentifier()
    {
        try {
            $processIdentifier = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('processIdentifier');
            Process::build($processIdentifier);
            return $processIdentifier;
        } catch (\InvalidArgumentException $exception) {
            /** @noinspection PhpParamsInspection */
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__PROCESS_IDENTIFIER_ERROR');
            return '';
        }
    }

    /**
     * @return string
     */
    protected function validateParticipationNumber()
    {
        try {
            $participationNumber = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('participationNumber');
            if (Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('processIdentifier') === Process::INTERNETMARKE) {
                $productExists = DatabaseProvider::getDb()->getOne('SELECT 1 from mo_dhl_internetmarke_products where OXID = ?', [$participationNumber]);
                if (!$productExists) {
                    Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__INTERNETMARKE_PRODUCT_ERROR');
                    return '';
                }
                return $participationNumber;
            } else {
                Participation::build($participationNumber);
                return $participationNumber;
            }
        } catch (\InvalidArgumentException $exception) {
            /** @noinspection PhpParamsInspection */
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__PARTICIPATION_NUMBER_ERROR');
            return '';
        }
    }

    /**
     * @return string[]
     */
    protected function getRemarks()
    {
        $remark = $this->getOrder()->oxorder__oxremark->value;
        return array_merge($this->moDHLGetPreferredDay($remark), $this->moDHLGetPreferredLocation($remark));
    }

    /**
     * @param string $remark
     * @return string[]
     */
    protected function moDHLGetPreferredDay($remark)
    {
        $preferredDay = $this->getWunschpaket()->extractWunschtag($remark);
        return $preferredDay !== '' ? [$this->translateString('MO_DHL__WUNSCHTAG') => $preferredDay] : [];
    }

    /**
     * @param string $remark
     * @return string[]
     */
    protected function moDHLGetPreferredLocation($remark)
    {
        [$type, $locationPart1, $locationPart2] = $this->getWunschpaket()->extractLocation($remark);
        switch ($type) {
            case Wunschpaket::WUNSCHNACHBAR:
                return [$this->translateString('MO_DHL__WUNSCHNACHBAR') => "{$locationPart2}, {$locationPart1}"];
            case Wunschpaket::WUNSCHORT:
                return [$this->translateString('MO_DHL__WUNSCHORT') => $locationPart1];
            default:
                return [];
        }
    }

    /**
     * @return \Mediaopt\DHL\Wunschpaket
     */
    protected function getWunschpaket()
    {
        if (!$this->wunschpaket) {
            $this->wunschpaket = Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        }
        return $this->wunschpaket;
    }

    /**
     * @param string $text
     * @return string
     */
    protected function translateString(string $text)
    {
        $lang = Registry::getLang();
        return $lang->translateString($text);
    }

    /**
     * @param CreateShipmentOrderResponse $response
     * @throws \Exception
     */
    protected function handleGKVCreationResponse(CreateShipmentOrderResponse $response)
    {
        $creationState = $response->getCreationState()[0];
        $statusInformation = $creationState ? $creationState->getLabelData()->getStatus() : $response->getStatus();
        $this->getOrder()->storeCreationStatus($statusInformation->getStatusText());
        if ($errors = $statusInformation->getErrors()) {
            $this->displayErrors($errors);
            return;
        }
        $label = MoDHLLabel::fromOrderAndCreationState($this->getOrder(), $creationState);
        $label->save();
        if ($statusInformation->getStatusCode() === StatusCode::GKV_STATUS_OK && $statusInformation->getStatusText() === 'Weak validation error occured.') {
            $errors = $statusInformation->getStatusMessage() ?: [];
            array_unshift($errors, $statusInformation->getStatusText());
            array_unshift($errors, 'MO_DHL__LABEL_CREATED_WITH_WEAK_VALIDATION_ERROR');
            $errors = array_unique($errors);
            $this->displayErrors($errors);
        }
    }

    protected function handleInternetmarkeCreationResponse(ShoppingCartResponseType $response)
    {
        $this->getOrder()->storeCreationStatus('ok');
        $label = MoDHLLabel::fromOrderAndInternetmarkeResponse($this->getOrder(), $response);
        $label->save();
    }

    /**
     * @param ResponseInterface $response
     * @throws \Exception
     */
    protected function handleParcelShippingPostResponse(ResponseInterface $response): void
    {
        $payload = \json_decode($response->getBody(), true);
        $errors = Registry::get(ParcelShippingConverter::class)->extractErrorsFromResponsePayload($payload);
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            $this->getOrder()->storeCreationStatus($payload['status']['title']);
            $label = MoDHLLabel::fromOrderAndParcelShippingResponseItem($this->getOrder(), $payload['items'][0]);
            $label->save();
            if ($errors !== []) {
                array_unshift($errors, 'MO_DHL__LABEL_CREATED_WITH_WEAK_VALIDATION_ERROR');
            }
        }
        if ($errors !== []) {
            $this->displayErrors($errors);
        }
    }

    /**
     * @param MoDHLLabel                  $label
     * @param DeleteShipmentOrderResponse $response
     */
    protected function handleGKVDeletionResponse(MoDHLLabel $label, DeleteShipmentOrderResponse $response)
    {
        $statusInformation = $response->getDeletionState() ? $response->getDeletionState()[0]->getStatus() : $response->getStatus();
        if ($errors = $statusInformation->getErrors()) {
            if ($statusInformation->getStatusCode() === StatusCode::GKV_STATUS_UNKNOWN_SHIPMENT) {
                $label->delete();
            }
            $this->displayErrors($errors);
            return;
        }
        $label->delete();
    }


    /**
     * @return CreateShipmentOrderRequest
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildShipmentOrderRequest(): CreateShipmentOrderRequest
    {
        return Registry::get(GKVCreateShipmentOrderRequestBuilder::class)->build([$this->getOrder()->getId()]);
    }

    /**
     * @return bool
     */
    public function usesInternetmarke()
    {
        return $this->getProcess() && $this->getProcess()->usesInternetMarke();
    }

    /**
     * @return bool
     */
    public function usesParcelShippingAPI()
    {
        return (bool)Registry::getConfig()->getConfigParam('mo_dhl__account_rest_api');
    }

    /**
     */
    public function createInternetmarkeLabel()
    {
        try {
            $request = Registry::get(InternetmarkeShoppingCartPDFRequestBuilder::class)->build([$this->getOrder()->getId()]);
            $internetMarke = Registry::get(DHLAdapter::class)->buildInternetmarke();
            $response = $internetMarke->checkoutShoppingCartPDF($request);
            $this->handleInternetmarkeCreationResponse($response);
        } catch (\Exception $e) {
            $errors = $this->parseInternetmarkeException($e);
            $this->displayErrors($errors);
        }
    }

    /**
     * @param \Exception $e
     * @return string[]
     */
    protected function parseInternetmarkeException(\Exception $e): array
    {
        $errors = [$e->getMessage()];
        if ($e->getPrevious() instanceof \SoapFault) {
            /** @var \SoapFault $fault */
            $fault = $e->getPrevious();
            $errors[] = $fault->getMessage();
            if ($fault->detail->ShoppingCartValidationException->errors->message) {
                $errors[] = $fault->detail->ShoppingCartValidationException->errors->message;
            }
            if ($fault->detail->RetoureVoucherException->errors->message) {
                $errors[] = $fault->detail->RetoureVoucherException->errors->message;
            }
        }
        return $errors;
    }

    /**
     * @param CreateShipmentOrderRequest $request
     * @return void
     * @throws \Exception
     */
    protected function createShipmentOrderWithGKV(CreateShipmentOrderRequest $request): void
    {
        $response = Registry::get(DHLAdapter::class)->buildGKV()->createShipmentOrder($request);
        $this->handleGKVCreationResponse($response);
    }

    /**
     * @param CreateShipmentOrderRequest $shipmentOrderRequest
     * @return void
     * @throws \Exception
     */
    protected function createShipmentOrderWithParcelShipping(CreateShipmentOrderRequest $shipmentOrderRequest): void
    {
        [$query, $shipmentOrderRequest] = Registry::get(ParcelShippingConverter::class)->convertCreateShipmentOrderRequest($shipmentOrderRequest);
        $response = Registry::get(DHLAdapter::class)
            ->buildParcelShipping()
            ->ordersPost($shipmentOrderRequest, $query, [], Client::FETCH_RESPONSE);
        $this->handleParcelShippingPostResponse($response);
    }

    /**
     * @param MoDHLLabel $label
     */
    protected function deleteShipmentWithParcelShipping(MoDHLLabel $label)
    {
        $label->getFieldData('shipmentNumber');
        $response = Registry::get(DHLAdapter::class)
            ->buildParcelShipping()
            ->ordersAccountDelete(['shipment' => $label->getFieldData('shipmentNumber')], [], Client::FETCH_RESPONSE);
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            $label->delete();
            return;
        }
        $payload = \json_decode($response->getBody(), true);
        $firstItem = $payload['items'][0];
        if ($firstItem['sstatus']['title'] === 'UnknownShipmentNumber') {
            $label->delete();
            return;
        }
        $this->displayErrors([$firstItem['sstatus']['detail']]);
    }

    /**
     * @param MoDHLLabel $label
     */
    protected function deleteShipmentWithGKV(MoDHLLabel $label)
    {
        $this->handleGKVDeletionResponse($label, $this->callGKVDeleteShipment($label->getFieldData('shipmentNumber')));
    }
}
