<?php

namespace Mediaopt\DHL\Controller\Admin;

use Mediaopt\DHL\Adapter\DHLAdapter;
use Mediaopt\DHL\Adapter\GKVCreateShipmentOrderRequestBuilder;
use Mediaopt\DHL\Adapter\GKVShipmentBuilder;
use Mediaopt\DHL\Api\GKV\CountryType;
use Mediaopt\DHL\Api\GKV\Request\CreateShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\Request\DeleteShipmentOrderRequest;
use Mediaopt\DHL\Api\GKV\Response\DeleteShipmentOrderResponse;
use Mediaopt\DHL\Api\GKV\Serviceconfiguration;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationDetailsOptional;
use Mediaopt\DHL\Api\GKV\ShipmentOrderType;
use Mediaopt\DHL\Api\Wunschpaket;
use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Model\MoDHLLabel;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;
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
        $this->addTplParam('process', $this->getProcess());
        $this->addTplParam('remarks', $this->getRemarks());
        $this->addTplParam('labels', $this->getOrder()->moDHLGetLabels());
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

        $this->useCustomGeneralData($shipmentOrder, $data['general']);
        $this->useCustomShipper($shipmentOrder, $data['shipper']);
        $this->useCustomReturnReceiver($shipmentOrder, $data['returnReceiver']);
        $this->useCustomReceiver($shipmentOrder, $data['receiver']);
        $this->useCustomServices($shipmentOrder, $data['services']);

        $this->addTplParam('shipmentOrder', $this->toCustomizableParametersArray($shipmentOrder));
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

        $this->addTplParam('shipmentOrder', $this->toCustomizableParametersArray($shipmentOrder));
        $this->setTemplateName('mo_dhl__order_dhl_custom_label.tpl');
    }

    /**
     */
    public function deleteShipment()
    {
        $label = \oxNew(MoDHLLabel::class);
        $label->load(Registry::getConfig()->getRequestParameter('labelId'));
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
     * @return Process
     */
    protected function getProcess()
    {
        return Process::build($this->getOrder()->oxorder__mo_dhl_process->rawValue);
    }

    /**
     */
    public function save()
    {
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $information = ['MO_DHL_EKP' => $this->validateEkp(), 'MO_DHL_PROCESS' => $this->validateProcessIdentifier(), 'MO_DHL_PARTICIPATION' => $this->validateParticipationNumber()];
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

    /**
     * @param ShipmentOrderType $shipmentOrder
     * @return array
     */
    protected function toCustomizableParametersArray(ShipmentOrderType $shipmentOrder): array
    {
        $shipper = $shipmentOrder->getShipment()->getShipper();
        $receiver = $shipmentOrder->getShipment()->getReceiver();
        $returnReceiver = $shipmentOrder->getShipment()->getReturnReceiver();
        return [
            'general'        => [
                'weight' => $shipmentOrder->getShipment()->getShipmentDetails()->getShipmentItem()->getWeightInKG(),
            ],
            'shipper'        => [
                'name'    => $shipper->getName()->getName1() . $shipper->getName()->getName2() . $shipper->getName()->getName3(),
                'address' => $shipper->getAddress(),
            ],
            'receiver'       => [
                'name'    => $receiver->getName1(),
                'type'    => $receiver->getAddress() !== null ? 'address' : ($receiver->getPackstation() !== null ? 'packstation' : 'poftfiliale'),
                'address' => $receiver->getAddress() ?: $receiver->getPackstation() ?: $receiver->getPostfiliale(),
            ],
            'returnReceiver' => [
                'name'    => $returnReceiver->getName()->getName1() . $returnReceiver->getName()->getName2() . $returnReceiver->getName()->getName3(),
                'address' => $returnReceiver->getAddress(),
            ],
            'services'       => [
                'parcelOutletRouting' => $shipmentOrder->getShipment()->getShipmentDetails()->getService()->getParcelOutletRouting(),
                'printOnlyIfCodeable' => $shipmentOrder->getPrintOnlyIfCodeable(),
                'beilegerretoure'     => $shipmentOrder->getShipment()->getShipmentDetails()->getReturnShipmentAccountNumber(),
                'go_green'            => $shipmentOrder->getShipment()->getShipmentDetails()->getService()->getGoGreen(),
            ],
        ];
    }

    /**
     * @param ShipmentOrderType $shipmentOrder
     * @param array             $generalData
     */
    protected function useCustomGeneralData(ShipmentOrderType $shipmentOrder, $generalData)
    {
        $shipmentOrder->getShipment()->getShipmentDetails()->getShipmentItem()->setWeightInKG($generalData['weight']);
    }

    /**
     * @param ShipmentOrderType $shipmentOrder
     * @param array             $shipperData
     */
    protected function useCustomShipper(ShipmentOrderType $shipmentOrder, $shipperData)
    {
        $shipper = $shipmentOrder->getShipment()->getShipper();
        $shipper->getName()->setName1($shipperData['name']);
        $shipperData['Origin'] = new CountryType($shipperData['country']);
        $shipper->getAddress()->assign($shipperData);
    }

    /**
     * @param ShipmentOrderType $shipmentOrder
     * @param array             $returnReceiverData
     */
    protected function useCustomReturnReceiver(ShipmentOrderType $shipmentOrder, $returnReceiverData)
    {
        $returnReceiver = $shipmentOrder->getShipment()->getReturnReceiver();
        $returnReceiver->getName()->setName1($returnReceiverData['name']);
        $returnReceiverData['Origin'] = new CountryType($returnReceiverData['country']);
        $returnReceiver->getAddress()->assign($returnReceiverData);
    }

    /**
     * @param ShipmentOrderType $shipmentOrder
     * @param array             $receiverData
     */
    protected function useCustomReceiver(ShipmentOrderType $shipmentOrder, $receiverData)
    {
        $receiver = $shipmentOrder->getShipment()->getReceiver();
        $receiver->setName1($receiverData['name']);
        if ($receiverData['country']) {
            $receiverData['Origin'] = new CountryType($receiverData['country']);
        }
        $receiverAddress = $receiver->getAddress() ?: $receiver->getPackstation() ?: $receiver->getPostfiliale();
        $receiverAddress->assign($receiverData);
    }

    /**
     * @param ShipmentOrderType $shipmentOrder
     * @param array             $servicesData
     */
    protected function useCustomServices(ShipmentOrderType $shipmentOrder, $servicesData)
    {
        $process = $this->getProcess();
        $services = $shipmentOrder->getShipment()->getShipmentDetails()->getService();
        if ($process->supportsParcelOutletRouting()) {
            $isActive = filter_var($servicesData['parcelOutletRouting']['active'], FILTER_VALIDATE_BOOLEAN);
            $details = $servicesData['parcelOutletRouting']['details'] ?: null;
            $services->setParcelOutletRouting(new ServiceconfigurationDetailsOptional($isActive, $details));
        }

        if ($process->supportsDHLRetoure()) {
            if (filter_var($servicesData['beilegerretoure']['active'], FILTER_VALIDATE_BOOLEAN)) {
                $accountNumber = Registry::get(GKVShipmentBuilder::class)->buildReturnAccountNumber($this->getOrder());
                $shipmentOrder->getShipment()->getShipmentDetails()->setReturnShipmentAccountNumber($accountNumber);
            }
        }

        if ($process->supportsGoGreen()) {
            $isActive = filter_var($servicesData['go_green']['active'], FILTER_VALIDATE_BOOLEAN);
            $services->setGoGreen(new Serviceconfiguration($isActive));
        }

        $isActive = filter_var($servicesData['printOnlyIfCodeable']['active'], FILTER_VALIDATE_BOOLEAN);
        $shipmentOrder->setPrintOnlyIfCodeable(new Serviceconfiguration($isActive));
    }
}
