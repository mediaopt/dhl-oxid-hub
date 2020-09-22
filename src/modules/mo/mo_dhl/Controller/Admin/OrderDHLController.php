<?php

namespace Mediaopt\DHL\Controller\Admin;

use GuzzleHttp\Exception\ClientException;
use Mediaopt\DHL\Adapter\DHLAdapter;
use Mediaopt\DHL\Adapter\GKVCreateShipmentOrderRequestBuilder;
use Mediaopt\DHL\Adapter\GKVCustomShipmentBuilder;
use Mediaopt\DHL\Adapter\GKVShipmentBuilder;
use Mediaopt\DHL\Api\GKV\CountryType;
use Mediaopt\DHL\Api\GKV\Request\CreateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\Request\DeleteShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\Response\DeleteShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\Serviceconfiguration;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationAdditionalInsurance;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationCashOnDelivery;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationDetailsOptional;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationIC;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationVisualAgeCheck;
use Mediaopt\DHL\Api\GKV\ShipmentOrderType;
use Mediaopt\DHL\Api\Wunschpaket;
use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Model\MoDHLLabel;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;
use Mediaopt\DHL\Shipment\RetoureRequest;
use OxidEsales\Eshop\Core\Registry;

/**
 * @author Mediaopt GmbH
 */
class OrderDHLController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{
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
        return $templateName;
    }

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function createLabel()
    {
        $this->handleCreationResponse($this->callCreation());
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
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($e->getMessage());
            if (!($previous = $e->getPrevious()) || !$previous instanceof ClientException) {
                return;
            }
            $response = $previous->getResponse();
            if (!$response->getBody()) {
                return;
            }
            $data = json_decode($response->getBody()->getContents());
            if ($data->detail) {
                \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($data->detail);
            }
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
        $request = $this->buildShipmentOrderRequest();
        $shipmentOrder = $request->getShipmentOrder()[0];
        $data = Registry::getConfig()->getRequestParameter('data');

        $customShipmentBuilder = new GKVCustomShipmentBuilder();
        $customShipmentBuilder->applyCustomDataToShipmentOrder($shipmentOrder, $data, $this->getOrder());

        $this->addTplParam('shipmentOrder', $customShipmentBuilder->toCustomizableParametersArray($shipmentOrder));
        $this->setTemplateName('mo_dhl__order_dhl_custom_label.tpl');
        $response = Registry::get(DHLAdapter::class)->buildGKV()->createShipmentOrder($request);
        $this->handleCreationResponse($response);
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
        $this->handleDeletionResponse($label, $this->callDeleteShipment($label->getFieldData('shipmentNumber')));
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
     * @return \Mediaopt\DHL\Api\GKV\Response\CreateShipmentOrderResponse
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
     */
    public function save()
    {
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $information = [
            'MO_DHL_EKP' => $this->validateEkp(),
            'MO_DHL_PROCESS' => $this->validateProcessIdentifier(),
            'MO_DHL_PARTICIPATION' => $this->validateParticipationNumber(),
            'MO_DHL_OPERATOR' => Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('operator'),
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

        $query = ' UPDATE ' . \getViewName('oxorder') . ' SET ' . implode(', ', $tuples) . " WHERE OXID = {$db->quote($this->getEditObjectId())}";
        $db->execute($query);
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
            Participation::build($participationNumber);
            return $participationNumber;
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
     * @param \Mediaopt\DHL\Api\GKV\Response\CreateShipmentOrderResponse $response
     * @throws \Exception
     */
    protected function handleCreationResponse(\Mediaopt\DHL\Api\GKV\Response\CreateShipmentOrderResponse $response)
    {
        $creationState = $response->getCreationState()[0];
        $statusInformation = $creationState->getLabelData()->getStatus();
        $this->getOrder()->storeCreationStatus($statusInformation->getStatusText());
        if ($errors = $statusInformation->getErrors()) {
            $this->displayErrors($errors);
            return;
        }
        $label = MoDHLLabel::fromOrderAndCreationState($this->getOrder(), $creationState);
        $label->save();
    }

    /**
     * @param MoDHLLabel                  $label
     * @param DeleteShipmentOrderResponse $response
     */
    protected function handleDeletionResponse(MoDHLLabel $label, DeleteShipmentOrderResponse $response)
    {
        $deletionState = $response->getDeletionState()[0];
        $statusInformation = $deletionState->getStatus();
        if ($errors = $statusInformation->getErrors()) {
            if ($statusInformation->getStatusText() === 'Unknown shipment number.') {
                $label->delete();
            }
            $this->displayErrors($errors);
            return;
        }
        $label->delete();
    }

    /**
     * @param string[] $errors
     */
    protected function displayErrors(array $errors)
    {
        $utilsView = Registry::get(\OxidEsales\Eshop\Core\UtilsView::class);
        foreach ($errors as $error) {
            $utilsView->addErrorToDisplay($error);
        }
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

}
