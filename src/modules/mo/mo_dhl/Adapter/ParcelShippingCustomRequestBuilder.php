<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2020 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Adapter;


use Mediaopt\DHL\Api\ParcelShipping\Model\BankAccount;
use Mediaopt\DHL\Api\ParcelShipping\Model\Commodity;
use Mediaopt\DHL\Api\ParcelShipping\Model\ContactAddress;
use Mediaopt\DHL\Api\ParcelShipping\Model\Shipment;
use Mediaopt\DHL\Api\ParcelShipping\Model\Shipper;
use Mediaopt\DHL\Api\ParcelShipping\Model\Value;
use Mediaopt\DHL\Api\ParcelShipping\Model\VAS;
use Mediaopt\DHL\Api\ParcelShipping\Model\VASCashOnDelivery;
use Mediaopt\DHL\Api\ParcelShipping\Model\VASDhlRetoure;
use Mediaopt\DHL\Api\ParcelShipping\Model\VASIdentCheck;
use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Model\MoDHLService;
use Mediaopt\DHL\Shipment\Process;
use OxidEsales\Eshop\Core\Registry;

/**
 * @author Mediaopt GmbH
 */
class ParcelShippingCustomRequestBuilder
{

    /**
     * @param array    $query
     * @param Shipment $shipment
     * @return array
     */
    public function toCustomizableParametersArray($query, Shipment $shipment): array
    {
        $shipper = $shipment->getShipper();
        $services = $shipment->getServices();
        $returnReceiver = $services->isInitialized('dhlRetoure') ? $services->getDhlRetoure()->getReturnAddress() : null;
        return [
            'weight'   => array_merge([
                'total' => ['weight' => $shipment->getDetails()->getWeight()->getValue(), 'title' => Registry::getLang()->translateString('GENERAL_ATALL')],
            ], $this->getExportItemWeights($shipment)),
            'shipper'  => [
                'name1'         => $shipper->getName1(),
                'name2'         => $shipper->isInitialized('name2') ? $shipper->getName2() : '',
                'name3'         => $shipper->isInitialized('name3') ? $shipper->getName3() : '',
                'addressStreet' => $shipper->getAddressStreet(),
                'addressHouse'  => $shipper->getAddressHouse(),
                'postalCode'    => $shipper->getPostalCode(),
                'city'          => $shipper->getCity(),
                'country'       => $shipper->getCountry(),
            ],
            'receiver' => $shipment->getConsignee(),
            'services' => [
                'parcelOutletRouting'  => $services->isInitialized('parcelOutletRouting') ? $services->getParcelOutletRouting() : null,
                'printOnlyIfCodeable'  => $query['mustEncode'],
                'dhlRetoure'           => $services->isInitialized('dhlRetoure') ? [
                    'active'  => (bool)$services->getDhlRetoure()->getBillingNumber(),
                    'address' => [
                        'name1'         => $returnReceiver->getName1(),
                        'name2'         => $returnReceiver->isInitialized('name2') ? $returnReceiver->getName2() : '',
                        'name3'         => $returnReceiver->isInitialized('name3') ? $returnReceiver->getName3() : '',
                        'addressStreet' => $returnReceiver->getAddressStreet(),
                        'addressHouse'  => $returnReceiver->getAddressHouse(),
                        'postalCode'    => $returnReceiver->getPostalCode(),
                        'city'          => $returnReceiver->getCity(),
                        'country'       => $returnReceiver->getCountry(),
                    ]
                ] : null,
                'bulkyGoods'           => $services->isInitialized('bulkyGoods') && $services->getBulkyGoods(),
                'additionalInsurance'  => $services->isInitialized('additionalInsurance') ? $services->getAdditionalInsurance()->getValue() : null,
                'identCheck'           => $services->isInitialized('identCheck') ? $services->getIdentCheck() : null,
                'cashOnDelivery'       => $services->isInitialized('cashOnDelivery') ? $services->getCashOnDelivery()->getAmount()->getValue() : null,
                'visualAgeCheck'       => $services->isInitialized('visualCheckOfAge') ? $services->getVisualCheckOfAge() : null,
                'pddp'                 => $services->isInitialized('postalDeliveryDutyPaid') && $services->getPostalDeliveryDutyPaid(),
                'cdp'                  => $services->isInitialized('closestDropPoint') && $services->getClosestDropPoint(),
                'premium'              => $services->isInitialized('premium') && $services->getPremium(),
                'endorsement'          => $services->isInitialized('endorsement') ? $services->getEndorsement() : null,
                'noNeighbourDelivery'  => $services->isInitialized('noNeighbourDelivery') && $services->getNoNeighbourDelivery(),
                'namedPersonOnly'      => $services->isInitialized('namedPersonOnly') && $services->getNamedPersonOnly(),
                'signedForByRecipient' => $services->isInitialized('signedForByRecipient') && $services->getSignedForByRecipient(),
            ],
        ];
    }

    /**
     * @param Shipment $shipmentOrder
     * @param array    $data
     * @param Order    $order
     */
    public function applyCustomDataToShipmentOrder(&$shipment, $data, Order $order)
    {
        $this->useCustomWeightData($shipment, $data['weight']);
        $this->useCustomShipper($shipment, $data['shipper']);
        $this->useCustomReceiver($shipment, $data['receiver']);
        $this->useCustomServices($shipment, $data['services'], $order);
    }

    public function applyCustomDataToQuery(&$query, $data)
    {
        $query['mustEncode'] = filter_var($data['services']['printOnlyIfCodeable']['active'], FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @param Shipment $shipment
     * @param array    $weightData
     */
    protected function useCustomWeightData(Shipment $shipment, $weightData)
    {
        foreach ($weightData as $key => $value) {
            if (strpos($value, ',') !== false) {
                $value = \OxidEsales\EshopCommunity\Core\Registry::getUtils()->string2Float($value);
            }
            if ($key === 'total') {
                $shipment->getDetails()->getWeight()->setValue($value);
            } else {
                $shipment->getCustoms()->getItems()[$key]->getItemWeight()->setValue($value);
            }
        }
    }


    /**
     * @param Shipment $shipment
     * @param array    $shipperData
     */
    protected function useCustomShipper(Shipment $shipment, array $shipperData)
    {
        $shipper = new Shipper();
        foreach (array_filter($shipperData) as $key => $value) {
            $shipper->{"set" . ucfirst($key)}($value);
        }
        $shipment->setShipper($shipper);
    }


    /**
     * @param Shipment $shipment
     * @param array    $receiverData
     */
    protected function useCustomReceiver(Shipment $shipment, $receiverData)
    {
        $shipment->setConsignee($receiverData);
    }

    /**
     * @param Shipment $shipment
     * @param array    $servicesData
     * @param Order    $order
     */
    protected function useCustomServices(Shipment $shipment, $servicesData, Order $order)
    {
        $process = $this->getProcess($order);
        $services = new VAS();
        if ($process->supportsParcelOutletRouting() && filter_var($servicesData['parcelOutletRouting']['active'], FILTER_VALIDATE_BOOLEAN)) {
            $details = $servicesData['parcelOutletRouting']['details'] ?: '';
            $services->setParcelOutletRouting($details);
        }

        if ($process->supportsDHLRetoure() && filter_var($servicesData['dhlRetoure']['active'], FILTER_VALIDATE_BOOLEAN)) {
            $accountNumber = Registry::get(ParcelShippingRequestBuilder::class)->buildReturnAccountNumber($order);
            $retoure = new VASDhlRetoure();
            $retoure->setBillingNumber($accountNumber);
            $address = new ContactAddress();
            foreach (array_filter($servicesData['dhlRetoure']['address']) as $key => $value) {
                $address->{"set" . ucfirst($key)}($value);
            }
            $retoure->setReturnAddress($address);
        }
        if ($process->supportsBulkyGood() && filter_var($servicesData['bulkyGoods']['active'], FILTER_VALIDATE_BOOLEAN)) {
            $services->setBulkyGoods(true);
        }
        if ($process->supportsAdditionalInsurance() && filter_var($servicesData['additionalInsurance']['active'], FILTER_VALIDATE_BOOLEAN)) {
            $details = $servicesData['additionalInsurance']['insuranceAmount'] ?? null;
            $services->setAdditionalInsurance($this->createValue($details));
        }
        if ($process->supportsCashOnDelivery() && filter_var($servicesData['cashOnDelivery']['active'], FILTER_VALIDATE_BOOLEAN)) {
            $details = $servicesData['cashOnDelivery']['codAmount'] ?? null;
            $customerReference = Registry::getLang()->translateString('GENERAL_ORDERNUM') . ' ' . $order->getFieldData('oxordernr');
            $bankAccount = new BankAccount();
            $bankAccount->setAccountHolder(Registry::getConfig()->getShopConfVar('mo_dhl__cod_accountOwner'));
            $bankAccount->setBankName(Registry::getConfig()->getShopConfVar('mo_dhl__cod_bankName'));
            $bankAccount->setIban(Registry::getConfig()->getShopConfVar('mo_dhl__cod_iban'));
            $cashOnDelivery = new VASCashOnDelivery();
            $cashOnDelivery->setAmount($this->createValue($details));
            $cashOnDelivery->setBankAccount($bankAccount);
            $cashOnDelivery->setTransferNote1($customerReference);
            $services->setCashOnDelivery($cashOnDelivery);
        }
        if ($process->supportsIdentCheck() && filter_var($servicesData['identCheck']['active'], FILTER_VALIDATE_BOOLEAN)) {
            $services->setIdentCheck($this->extractIdent($servicesData['identCheck']));
        }
        elseif ($process->supportsVisualAgeCheck() && $ageCheck = $servicesData['visualAgeCheck'] ?? null) {
                $services->setVisualCheckOfAge('A' . $ageCheck);
        }
        if ($process->supportsPDDP() && filter_var($servicesData['pddp']['active'], FILTER_VALIDATE_BOOLEAN)) {
            $services->setPostalDeliveryDutyPaid(true);
        }
        if ($process->supportsCDP() && filter_var($servicesData['cdp']['active'], FILTER_VALIDATE_BOOLEAN)) {
            $services->setClosestDropPoint(true);
        }
        if ($process->supportsPremium() && filter_var($servicesData['premium']['active'], FILTER_VALIDATE_BOOLEAN)) {
            $services->setPremium(true);
        }
        if ($process->supportsEndorsement()) {
            $endorsement = $servicesData['endorsement'] ?? MoDHLService::MO_DHL__ENDORSEMENT_RETURN;
            $services->setEndorsement($endorsement);
        }
        if ($process->supportsNoNeighbourDelivery() && filter_var($servicesData['noNeighbourDelivery']['active'], FILTER_VALIDATE_BOOLEAN)) {
            $services->setNoNeighbourDelivery(true);
        }
        if ($process->supportsNamedPersonOnly() && filter_var($servicesData['namedPersonOnly']['active'], FILTER_VALIDATE_BOOLEAN)) {
            $services->setNamedPersonOnly(true);
        }
        if ($process->supportsSignedForByRecipient() && filter_var($servicesData['signedForByRecipient']['active'], FILTER_VALIDATE_BOOLEAN)) {
            $services->setSignedForByRecipient(true);
        }
        $shipment->setServices($services);
    }

    /**
     * @param array $identCheckData
     * @return VASIdentCheck
     * @throws \Exception
     */
    protected function extractIdent($identCheckData): VASIdentCheck
    {
        var_dump($identCheckData);
        $identCheck = (new VASIdentCheck())
            ->setFirstName($identCheckData['firstName'])
            ->setLastName($identCheckData['lastName']);
        if ($identCheckData['dateOfBirth']) {
            $identCheck->setDateOfBirth((new \DateTime($identCheckData['dateOfBirth'])));
        }
        if ($identCheckData['minimumAge']) {
            $identCheck->setMinimumAge('A' . $identCheckData['minimumAge']);
        }
        return $identCheck;
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
     * @param Shipment $shipment
     * @return array[]
     */
    protected function getExportItemWeights(Shipment $shipment): array
    {
        if (!$shipment->isInitialized('customs')) {
            return [];
        }
        $exportDocument = $shipment->getCustoms();
        return array_map(
            [$this, 'parseCommodity'],
            $exportDocument->getItems()
        );

    }

    protected function parseCommodity(Commodity $commodity): array
    {
        return ['weight' => $commodity->getItemWeight()->getValue(), 'title' => $commodity->getItemDescription()];
    }

    /**
     * This method will return a value with EUR as currency since the currency this class receives is EUR at the moment.
     *
     * @param float       $amount
     * @param string|null $currency
     * @return Value
     */
    protected function createValue(float $amount, ?string $currency = null): Value
    {
        $value = new Value();
        $value->setValue($amount);
        $value->setCurrency($currency ?: 'EUR');
        return $value;
    }
}
