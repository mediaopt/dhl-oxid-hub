<?php

namespace Mediaopt\DHL\Controller\Admin;

use GuzzleHttp\Exception\ClientException;
use Mediaopt\DHL\Adapter\DHLAdapter;
use Mediaopt\DHL\Adapter\GKVCreateShipmentOrderRequestBuilder;
use Mediaopt\DHL\Adapter\GKVCustomShipmentBuilder;
use Mediaopt\DHL\Adapter\InternetmarkeRefundRetoureVouchersRequestBuilder;
use Mediaopt\DHL\Adapter\InternetmarkeShoppingCartPDFRequestBuilder;
use Mediaopt\DHL\Api\GKV\Request\CreateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\Request\DeleteShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\Response\CreateShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\Response\DeleteShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\Response\StatusCode;
use Mediaopt\DHL\Api\Internetmarke\ShoppingCartResponseType;
use Mediaopt\DHL\Api\Warenpost;
use Mediaopt\DHL\Api\Wunschpaket;
use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Model\MoDHLInternetmarkeRefund;
use Mediaopt\DHL\Model\MoDHLLabel;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;
use Mediaopt\DHL\Shipment\RetoureRequest;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\UtilsView;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\TableViewNameGenerator;

/**
 * @author Mediaopt GmbH
 */
class OrderDHLController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{

    use ErrorDisplayTrait;

    /**
     * @var \OxidEsales\Eshop\Application\Model\Order|null
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
        $this->addTplParam('warenpostRegions', Warenpost::getWarenpostRegions());
        $this->addTplParam('warenpostRegionValue', $this->getWarenpostRegion());
        $this->addTplParam('warenpostTrackingTypes', Warenpost::getWarenpostTrackingTypes());
        $this->addTplParam('warenpostTrackingTypeValue', $this->getWarenpostTrackingType());
        $this->addTplParam('warenpostPackageTypes', Warenpost::getWarenpostPackageTypes());
        $this->addTplParam('warenpostPackageTypeValue', $this->getWarenpostPackageType());

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
            } elseif ($this->usesWarenpostInternational()) {
                $this->createWarenpostLabel();
            } else {
                $this->handleCreationResponse($this->callCreation());
            }
        } catch (\Exception $e) {
            $this->displayErrors($e);
        }

    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order|null $order
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
                $e->getMessage()
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
            $response = Registry::get(DHLAdapter::class)->buildGKV()->createShipmentOrder($request);
            $this->handleCreationResponse($response);
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
            } elseif($this->usesWarenpostInternational()) {
                $label->delete();
            } else {
                $this->handleDeletionResponse($label, $this->callDeleteShipment($label->getFieldData('shipmentNumber')));
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
    public function callDeleteShipment(string $shipmentNumber): DeleteShipmentOrderResponse
    {
        $gkvClient = Registry::get(DHLAdapter::class)->buildGKV();
        return $gkvClient->deleteShipmentOrder(new DeleteShipmentOrderRequest($gkvClient->buildVersion(), $shipmentNumber));
    }

    /**
     */
    public function createWarenpostLabel()
    {
        try {
            $warenpostService = Registry::get(DHLAdapter::class)->buildWarenpost();
            $response = $warenpostService->createWarenpost($this->getOrder());
            $warenpostService->handleResponse($this->getOrder(), $response);
        } catch (\Exception $e) {
            $this->displayErrors($e);
        }
    }

    /**
     * @return CreateShipmentOrderResponse
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function callCreation()
    {
        return Registry::get(DHLAdapter::class)->buildGKV()->createShipmentOrder($this->buildShipmentOrderRequest());
    }

    /**
     * @return string
     */
    protected function getEkp()
    {
        return (string)Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('ekp') ?: (string)$this->getOrder()->oxorder__mo_dhl_ekp->rawValue ?: (string)Registry::getConfig()->getConfigParam('mo_dhl__merchant_ekp');
    }

    /**
     * @return \OxidEsales\Eshop\Application\Model\Order
     */
    protected function getOrder()
    {
        if ($this->order !== null) {
            return $this->order;
        }

        $this->order = \oxNew(\OxidEsales\Eshop\Application\Model\Order::class);
        $this->order->load($this->getEditObjectId());
        return $this->order;
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order
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
        return (string)Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('participationNumber') ?: (string)$this->getOrder()->oxorder__mo_dhl_participation->rawValue;
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
     * @return string|null
     */
    protected function getWarenpostRegion()
    {
        if ($value = $this->getOrder()->oxorder__mo_dhl_warenpost_product_region->rawValue) {
            return $value;
        }
        return null;
    }

    /**
     * @return string|null
     */
    protected function getWarenpostTrackingType()
    {
        if ($value = $this->getOrder()->oxorder__mo_dhl_warenpost_product_tracking_type->rawValue) {
            return $value;
        }
        return null;
    }

    /**
     * @return string|null
     */
    protected function getWarenpostPackageType()
    {
        if ($value = $this->getOrder()->oxorder__mo_dhl_warenpost_product_package_type->rawValue) {
            return $value;
        }
        return null;
    }

    /**
     */
    public function save()
    {
        try {
            $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
            $information = [
                'MO_DHL_EKP'                    => $this->validateEkp(),
                'MO_DHL_PROCESS'                => $this->validateProcessIdentifier(),
                'MO_DHL_PARTICIPATION'          => $this->validateParticipationNumber(),
                'MO_DHL_OPERATOR'               => Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('operator'),
                'MO_DHL_RETOURE_REQUEST_STATUS' => Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('retoureRequest'),
                'MO_DHL_WARENPOST_PRODUCT_REGION' => Registry::get(Request::class)->getRequestParameter('warenpostRegion'),
                'MO_DHL_WARENPOST_PRODUCT_TRACKING_TYPE' => Registry::get(Request::class)->getRequestParameter('warenpostTrackingType'),
                'MO_DHL_WARENPOST_PRODUCT_PACKAGE_TYPE' => Registry::get(Request::class)->getRequestParameter('warenpostPackageType'),
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
            $viewNameGenerator = \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\TableViewNameGenerator::class);
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
        list($type, $locationPart1, $locationPart2) = $this->getWunschpaket()->extractLocation($remark);
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
    protected function handleCreationResponse(CreateShipmentOrderResponse $response)
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
    }

    protected function handleInternetmarkeCreationResponse(ShoppingCartResponseType $response)
    {
        $this->getOrder()->storeCreationStatus('ok');
        $label = MoDHLLabel::fromOrderAndInternetmarkeResponse($this->getOrder(), $response);
        $label->save();
    }

    /**
     * @param MoDHLLabel                  $label
     * @param DeleteShipmentOrderResponse $response
     */
    protected function handleDeletionResponse(MoDHLLabel $label, DeleteShipmentOrderResponse $response)
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
    protected function usesWarenpostInternational(): bool
    {
        return $this->getProcess() && $this->getProcess()->usesWarenpostInternational();
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
}
