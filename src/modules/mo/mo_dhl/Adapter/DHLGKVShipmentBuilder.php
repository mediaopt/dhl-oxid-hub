<?php

namespace Mediaopt\DHL\Adapter;

use Mediaopt\DHL\Api\GKV\CommunicationType;
use Mediaopt\DHL\Api\GKV\CountryType;
use Mediaopt\DHL\Api\GKV\NameType;
use Mediaopt\DHL\Api\GKV\NativeAddressType;
use Mediaopt\DHL\Api\GKV\PackStationType;
use Mediaopt\DHL\Api\GKV\PostfilialeType;
use Mediaopt\DHL\Api\GKV\ReceiverNativeAddressType;
use Mediaopt\DHL\Api\GKV\ReceiverType;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationDeliveryTimeframe;
use Mediaopt\DHL\Api\GKV\ServiceconfigurationDetails;
use Mediaopt\DHL\Api\GKV\Shipment;
use Mediaopt\DHL\Api\GKV\ShipmentDetailsType;
use Mediaopt\DHL\Api\GKV\ShipmentItemType;
use Mediaopt\DHL\Api\GKV\ShipmentNotificationType;
use Mediaopt\DHL\Api\GKV\ShipmentService;
use Mediaopt\DHL\Api\GKV\ShipperType;
use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\ServiceProvider\Branch;
use Mediaopt\DHL\Shipment\BillingNumber;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;
use OxidEsales\Eshop\Application\Model\Address as Address;
use OxidEsales\Eshop\Application\Model\Basket;
use OxidEsales\Eshop\Application\Model\User;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

/**
 * This class transforms an \oxBasket object into a Shipment object.
 *
 * @author Mediaopt GmbH
 */
class DHLGKVShipmentBuilder extends DHLBaseShipmentBuilder
{

    /**
     * @param Basket       $oxBasket
     * @param Address|User $deliveryAddress
     * @return Shipment
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    public function build(Basket $oxBasket, $deliveryAddress)
    {
        $shipment = new Shipment($this->buildShipmentDetails($oxBasket), $this->buildShipper(), $this->buildReceiver($deliveryAddress));
        $shipment->setReturnReceiver($this->buildReturnReceiver());
        return $shipment;
    }

    /**
     * @param Basket       $oxBasket
     * @param Address|User $deliveryAddress
     * @return string
     */
    public function buildHash(Basket $oxBasket, $deliveryAddress)
    {
        return 'mo_dhl__' . $this->calculateWeight($oxBasket) . '_' . $deliveryAddress->getEncodedDeliveryAddress();
    }


    /**
     * @param Basket $oxBasket
     * @return ShipmentDetailsType
     */
    protected function buildShipmentDetails(Basket $oxBasket): ShipmentDetailsType
    {
        $details = new ShipmentDetailsType($this->getProcess($oxBasket)->getServiceIdentifier(), $this->buildAccountNumber($oxBasket), $this->buildShipmentDate(), $this->buildShipmentItem($oxBasket));
        if ($returnBookingNumber = $this->buildReturnAccountNumber($oxBasket)) {
            $details->setReturnShipmentAccountNumber($returnBookingNumber);
        }
        $details->setNotification(new ShipmentNotificationType($oxBasket->getUser()->getFieldData('oxusername')));
        $details->setService($this->buildService());
        return $details;
    }

    /**
     * @param Address|User $deliveryAddress
     * @return ReceiverType
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildReceiver($deliveryAddress): ReceiverType
    {
        $receiver = new ReceiverType($deliveryAddress->getFieldData('oxfname') . ' ' . $deliveryAddress->getFieldData('oxlname'));
        if (Branch::isPackstation($deliveryAddress->getFieldData('oxstreet'))) {
            $receiver->setPackstation($this->buildPackstation($deliveryAddress));
        } else if (Branch::isFiliale($deliveryAddress->getFieldData('oxstreet'))) {
            $receiver->setPostfiliale($this->buildPostfiliale($deliveryAddress));
        } else {
            $receiver->setAddress($this->buildAddress($deliveryAddress));
            $receiver->setCommunication($this->buildCommunication($deliveryAddress));
        }
        return $receiver;
    }

    /**
     * @param Address|User $deliveryAddress
     * @return CommunicationType
     */
    protected function buildCommunication($deliveryAddress)
    {
        $communication = new CommunicationType();
        $communication->setContactPerson($deliveryAddress->getFieldData('oxfname') . ' ' . $deliveryAddress->getFieldData('oxlname'))
            ->setEmail($deliveryAddress->getFieldData('oxusername'))
            ->setPhone($deliveryAddress->getFieldData('oxfon'));
        return $communication;
    }

    /**
     * @param string $countryId
     * @return CountryType
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildCountry($countryId)
    {
        $country = \oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
        $country->load($countryId);
        return new CountryType($country->getFieldData('oxisoalpha2'));
    }

    /**
     * @param Basket $basket
     * @return float
     */
    protected function calculateWeight(Basket $basket): float
    {
        $weight = 0;
        foreach ($basket->getContents() as $basketArticle) {
            /** @var \OxidEsales\Eshop\Application\Model\BasketItem $basketArticle */
            $weight += (float)$basketArticle->getArticle()->getWeight() * $basketArticle->getAmount();
        }
        return $weight;
    }

    /**
     * @return Ekp|null
     */
    protected function getEkp()
    {
        try {
            return Ekp::build($this->ekp);
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }

    /**
     * @param Basket $basket
     * @return Process|null
     */
    protected function getProcess(Basket $basket)
    {
        try {
            $identifier = $this->deliverySetToProcessIdentifier[$basket->getShippingId()];
            return Process::build($identifier);
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }

    /**
     * @param Basket $basket
     * @return Process|null
     */
    protected function getReturnProcess(Basket $basket)
    {
        try {
            $identifier = $this->deliverySetToProcessIdentifier[$basket->getShippingId()];
            return Process::buildForRetoure($identifier);
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }

    /**
     * @param Basket $basket
     * @return Participation|null
     */
    protected function getParticipation(Basket $basket)
    {
        try {
            $number = $this->deliverySetToParticipationNumber[$basket->getShippingId()];
            return Participation::build($number);
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }

    /**
     * @param Basket $oxBasket
     * @return BillingNumber
     */
    protected function buildAccountNumber(Basket $oxBasket): BillingNumber
    {
        return new BillingNumber($this->getEkp(), $this->getProcess($oxBasket), $this->getParticipation($oxBasket));
    }

    /**
     * @param Basket $oxBasket
     * @return BillingNumber|null
     */
    protected function buildReturnAccountNumber(Basket $oxBasket)
    {
        if (!$this->getReturnProcess($oxBasket)) {
            return null;
        }
        return new BillingNumber($this->getEkp(), $this->getReturnProcess($oxBasket), $this->getParticipation($oxBasket));
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function buildShipmentDate(): string
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        return $wunschpaket->getWunschpaket()->getTransferDay()->format('Y-m-d');
    }

    /**
     * @param Basket $oxBasket
     * @return ShipmentItemType
     */
    protected function buildShipmentItem(Basket $oxBasket): ShipmentItemType
    {
        return new ShipmentItemType($this->calculateWeight($oxBasket));
    }

    /**
     * @return ShipmentService
     */
    private function buildService(): ShipmentService
    {
        $service = new ShipmentService();
        $remark = \OxidEsales\Eshop\Core\Registry::getSession()->getVariable('ordrem');
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        if ($wunschpaket->hasWunschzeit($remark)) {
            $service->setPreferredTime(new ServiceconfigurationDeliveryTimeframe(1, $wunschpaket->extractTime($remark)));
        }
        if ($wunschpaket->hasWunschtag($remark)) {
            $service->setPreferredDay(new ServiceconfigurationDetails(1, $wunschpaket->extractWunschtag($remark)));
        }
        list($type, $locationPart1, $locationPart2) = $wunschpaket->extractLocation($remark);
        if ($wunschpaket->hasWunschnachbar($remark)) {
            $service->setPreferredNeighbour(new ServiceconfigurationDetails(1, "$locationPart2, $locationPart1"));
        }
        if ($wunschpaket->hasWunschort($remark)) {
            $service->setPreferredNeighbour(new ServiceconfigurationDetails(1, $locationPart1));
        }
        return $service;
    }

    /**
     * @return ShipperType
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    protected function buildReturnReceiver(): ShipperType
    {
        return $this->buildShipper();
    }

    /**
     * @return ShipperType
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     */
    protected function buildShipper(): ShipperType
    {
        $config = \OxidEsales\Eshop\Core\Registry::getConfig();

        $name = new NameType($config->getShopConfVar('mo_dhl__export_line1'), $config->getShopConfVar('mo_dhl__export_line2'), $config->getShopConfVar('mo_dhl__export_line3'));
        $iso2 = \oxDb::getDb()->getOne('SELECT OXISOALPHA2 from oxcountry where OXISOALPHA3 = ? ', [$config->getShopConfVar('mo_dhl__export_country')]);
        $country = new CountryType($iso2);
        $address = new NativeAddressType($config->getShopConfVar('mo_dhl__export_street'), $config->getShopConfVar('mo_dhl__export_street_number'), $config->getShopConfVar('mo_dhl__export_zip'), $config->getShopConfVar('mo_dhl__export_city'), null, $country);
        return new ShipperType($name, $address);
    }

    /**
     * @param Address $deliveryAddress
     * @return PostfilialeType
     */
    private function buildPostfiliale(Address $deliveryAddress): PostfilialeType
    {
        return new PostfilialeType($deliveryAddress->getFieldData('oxstreetnr'), $deliveryAddress->getFieldData('oxaddinfo'), $deliveryAddress->getFieldData('oxzip'), $deliveryAddress->getFieldData('oxcity'));
    }

    /**
     * @param Address $deliveryAddress
     * @return PackStationType
     */
    protected function buildPackstation(Address $deliveryAddress): PackStationType
    {
        return new PackStationType($deliveryAddress->getFieldData('oxstreetnr'), $deliveryAddress->getFieldData('oxaddinfo'), $deliveryAddress->getFieldData('oxzip'), $deliveryAddress->getFieldData('oxcity'), null, $this->buildCountry($deliveryAddress->getFieldData('oxcountryid')));
    }

    /**
     * @param Address|User $deliveryAddress
     * @return ReceiverNativeAddressType
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildAddress($deliveryAddress): ReceiverNativeAddressType
    {
        $address = new ReceiverNativeAddressType($deliveryAddress->getFieldData('oxcompany') ?: null, null, $deliveryAddress->getFieldData('oxstreet'), $deliveryAddress->getFieldData('oxstreetnr'), $deliveryAddress->getFieldData('oxzip'), $deliveryAddress->getFieldData('oxcity'), null, $this->buildCountry($deliveryAddress->getFieldData('oxcountryid')));
        if ($addInfo = $deliveryAddress->getFieldData('oxaddinfo')) {
            $address->setAddressAddition([$addInfo]);
        }
        return $address;
    }
}
