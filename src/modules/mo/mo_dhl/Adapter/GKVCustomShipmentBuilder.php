<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2020 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Adapter;


use Mediaopt\DHL\Api\GKV\CountryType;
use Mediaopt\DHL\Api\GKV\ExportDocPosition;
use Mediaopt\DHL\Api\GKV\Serviceconfiguration;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationAdditionalInsurance;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationCashOnDelivery;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationDetailsOptional;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationEndorsement;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationIC;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationVisualAgeCheck;
use Mediaopt\DHL\Api\GKV\ShipmentOrderType;
use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Model\MoDHLService;
use Mediaopt\DHL\Shipment\Process;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Registry;

/**
 * @author Mediaopt GmbH
 */
class GKVCustomShipmentBuilder
{

    /**
     * @param ShipmentOrderType $shipmentOrder
     * @return array
     */
    public function toCustomizableParametersArray(ShipmentOrderType $shipmentOrder): array
    {
        $shipper = $shipmentOrder->getShipment()->getShipper();
        $receiver = $shipmentOrder->getShipment()->getReceiver();
        $returnReceiver = $shipmentOrder->getShipment()->getReturnReceiver();
        return [
            'weight'        => array_merge([
                'total' => ['weight' => $shipmentOrder->getShipment()->getShipmentDetails()->getShipmentItem()->getWeightInKG(), 'title' => Registry::getLang()->translateString('GENERAL_ATALL')],
            ], $this->getExportDocPositionWeights($shipmentOrder)),
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
                'bulkyGoods'          => $shipmentOrder->getShipment()->getShipmentDetails()->getService()->getBulkyGoods(),
                'additionalInsurance' => $shipmentOrder->getShipment()->getShipmentDetails()->getService()->getAdditionalInsurance(),
                'identCheck'          => $shipmentOrder->getShipment()->getShipmentDetails()->getService()->getIdentCheck(),
                'cashOnDelivery'      => $shipmentOrder->getShipment()->getShipmentDetails()->getService()->getCashOnDelivery(),
                'visualAgeCheck'      => $shipmentOrder->getShipment()->getShipmentDetails()->getService()->getVisualCheckOfAge(),
                'premium'             => $shipmentOrder->getShipment()->getShipmentDetails()->getService()->getPremium(),
                'endorsement'         => $shipmentOrder->getShipment()->getShipmentDetails()->getService()->getEndorsement(),
            ],
        ];
    }

    /**
     * @param ShipmentOrderType $shipmentOrder
     * @param array             $data
     * @param Order             $order
     */
    public function applyCustomDataToShipmentOrder(&$shipmentOrder, $data, Order $order)
    {
        $this->useCustomWeightData($shipmentOrder, $data['weight']);
        $this->useCustomShipper($shipmentOrder, $data['shipper']);
        $this->useCustomReturnReceiver($shipmentOrder, $data['returnReceiver']);
        $this->useCustomReceiver($shipmentOrder, $data['receiver']);
        $this->useCustomServices($shipmentOrder, $data['services'], $order);
    }

    /**
     * @param ShipmentOrderType $shipmentOrder
     * @param array             $weightData
     */
    protected function useCustomWeightData(ShipmentOrderType $shipmentOrder, $weightData)
    {
        foreach ($weightData as $key => $value) {
            if (strpos($value, ',') !== false) {
                $value = \OxidEsales\EshopCommunity\Core\Registry::getUtils()->string2Float($value);
            }
            if ($key === 'total') {
                $shipmentOrder->getShipment()->getShipmentDetails()->getShipmentItem()->setWeightInKG($value);
            } else {
                $shipmentOrder->getShipment()->getExportDocument()->getExportDocPosition()[$key]->setNetWeightInKG($value);
            }
        }
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
     * @param Order             $order
     */
    protected function useCustomServices(ShipmentOrderType $shipmentOrder, $servicesData, Order $order)
    {
        $process = $this->getProcess($order);
        $services = $shipmentOrder->getShipment()->getShipmentDetails()->getService();
        if ($process->supportsParcelOutletRouting()) {
            $isActive = filter_var($servicesData['parcelOutletRouting']['active'], FILTER_VALIDATE_BOOLEAN);
            $details = $servicesData['parcelOutletRouting']['details'] ?? null;
            $services->setParcelOutletRouting(new ServiceconfigurationDetailsOptional($isActive, $details));
        }

        if ($process->supportsDHLRetoure() && filter_var($servicesData['beilegerretoure']['active'], FILTER_VALIDATE_BOOLEAN)) {
            $accountNumber = Registry::get(GKVShipmentBuilder::class)->buildReturnAccountNumber($order);
            $shipmentOrder->getShipment()->getShipmentDetails()->setReturnShipmentAccountNumber($accountNumber);
        } else {
            $shipmentOrder->getShipment()->getShipmentDetails()->setReturnShipmentAccountNumber(null);
        }
        if ($process->supportsBulkyGood()) {
            $isActive = filter_var($servicesData['bulkyGoods']['active'], FILTER_VALIDATE_BOOLEAN);
            $services->setBulkyGoods(new Serviceconfiguration($isActive));
        }
        if ($process->supportsAdditionalInsurance()) {
            $isActive = filter_var($servicesData['additionalInsurance']['active'], FILTER_VALIDATE_BOOLEAN);
            $details = $servicesData['additionalInsurance']['insuranceAmount'] ?? null;
            $services->setAdditionalInsurance(new ServiceconfigurationAdditionalInsurance($isActive, $details));
        }
        if ($process->supportsCashOnDelivery()) {
            $isActive = filter_var($servicesData['cashOnDelivery']['active'], FILTER_VALIDATE_BOOLEAN);
            $details = $servicesData['cashOnDelivery']['codAmount'] ?? null;
            $services->setCashOnDelivery(new ServiceconfigurationCashOnDelivery($isActive, 0, $details));
        }
        if ($process->supportsIdentCheck()) {
            $isActive = filter_var($servicesData['identCheck']['active'], FILTER_VALIDATE_BOOLEAN);
            if ($isActive) {
                $ident = $this->extractIdent($servicesData['identCheck']);
                $services->setIdentCheck(new ServiceconfigurationIC($ident, true));
            } else {
                $services->setIdentCheck(null);
            }
        }
        if ($process->supportsVisualAgeCheck()) {
            $identCheckUsed = $process->supportsIdentCheck() && filter_var($servicesData['identCheck']['active'], FILTER_VALIDATE_BOOLEAN);
            if (!$identCheckUsed && $ageCheck = $servicesData['visualAgeCheck'] ?? null) {
                $services->setVisualCheckOfAge(new ServiceconfigurationVisualAgeCheck(true, 'A' . $ageCheck));
            } else {
                $services->setVisualCheckOfAge(null);
            }

        }
        if ($process->supportsPremium()) {
            $isActive = filter_var($servicesData['premium']['active'], FILTER_VALIDATE_BOOLEAN);
            $services->setPremium(new Serviceconfiguration($isActive));
        }
        if ($process->supportsEndorsement()) {
            $endorsement = $servicesData['endorsement'] ?? MoDHLService::MO_DHL__ENDORSEMENT_IMMEDIATE;
            $services->setEndorsement(new ServiceconfigurationEndorsement(true, $endorsement));
        }

        $isActive = filter_var($servicesData['printOnlyIfCodeable']['active'], FILTER_VALIDATE_BOOLEAN);
        $shipmentOrder->setPrintOnlyIfCodeable(new Serviceconfiguration($isActive));
    }

    /**
     * @param array $identCheck
     * @return \stdClass
     * @throws \Exception
     */
    protected function extractIdent($identCheck) : \stdClass
    {
        $ident = new \stdClass();
        $ident->surname = $identCheck['surname'];
        $ident->givenName = $identCheck['givenName'];
        $ident->dateOfBirth = $identCheck['dateOfBirth'] ? (new \DateTime($identCheck['dateOfBirth']))->format('Y-m-d') : null;
        $ident->minimumAge = $identCheck['minimumAge']
            ? 'A' . $identCheck['minimumAge']
            : null;
        return $ident;
    }

    /**
     * @param Order
     * @return Process|null
     */
    protected function getProcess(Order $order)
    {
        if ($processNr = $order->oxorder__mo_dhl_process->rawValue) {
            return Process::build($processNr);
        }
        return null;
    }

    /**
     * @param ShipmentOrderType $shipmentOrder
     * @return array[]
     */
    protected function getExportDocPositionWeights(ShipmentOrderType $shipmentOrder): array
    {
        if (!$exportDocument = $shipmentOrder->getShipment()->getExportDocument())
        {
            return [];
        }
        return array_map(
            [$this, 'parseExportDocPostition'],
            $exportDocument->getExportDocPosition()
        );

    }

    protected function parseExportDocPostition(ExportDocPosition $exportDocPosition): array
    {
        return ['weight' => $exportDocPosition->getNetWeightInKG(), 'title' => $exportDocPosition->getDescription()];
    }
}
