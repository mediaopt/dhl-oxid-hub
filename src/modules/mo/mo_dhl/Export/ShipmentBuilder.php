<?php

namespace Mediaopt\DHL\Export;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Mediaopt\DHL\Adapter\BaseShipmentBuilder;
use Mediaopt\DHL\Address\Address;
use Mediaopt\DHL\Address\Receiver;
use Mediaopt\DHL\Address\Sender;
use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Shipment\Contact;
use Mediaopt\DHL\Shipment\Shipment;

/**
 * This class transforms an \oxOrder object into a Shipment object.
 *
 * @author Mediaopt GmbH
 */
class ShipmentBuilder extends BaseShipmentBuilder
{

    /**
     * @param Order $oxOrder
     * @return Shipment
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function build(Order $oxOrder)
    {
        $order = new Shipment($this->determineReference($oxOrder), $this->buildReceiver($oxOrder), $this->buildSender(), $this->calculateWeight($oxOrder), $oxOrder->oxorder__oxsenddate->rawValue !== '-' ? $oxOrder->oxorder__oxsenddate->rawValue : '');
        $ekp = $this->getEkp($oxOrder);
        if ($ekp !== null) {
            $order->setEkp($ekp);
        }

        $process = $this->getProcess($oxOrder);
        if ($process !== null) {
            $order->setProcess($process);
        }

        $participation = $this->getParticipation($oxOrder);
        if ($participation !== null) {
            $order->setParticipation($participation);
        }

        return $order;
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order $order
     * @return string
     */
    protected function determineReference(\OxidEsales\Eshop\Application\Model\Order $order)
    {
        return 'OXID-' . $order->oxorder__oxordernr->rawValue;
    }

    /**
     * Uses the delivery address in the order to build the receiver.
     *
     * @param \OxidEsales\Eshop\Application\Model\Order $order
     * @return Receiver
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildReceiver(\OxidEsales\Eshop\Application\Model\Order $order)
    {
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        list($locationType, $location) = $wunschpaket->extractLocation($order->oxorder__oxremark->value);
        return new Receiver($this->buildContact($order), $order->oxorder__oxdeladdinfo->rawValue, $this->buildAddress($order), $locationType, $location, $wunschpaket->extractTime($order->oxorder__oxremark->value), $wunschpaket->extractWunschtag($order->oxorder__oxremark->value));
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order $order
     * @return Contact
     */
    public function buildContact(\OxidEsales\Eshop\Application\Model\Order $order)
    {
        $prefix = 'oxorder__';
        foreach (['oxdelfname', 'oxdellname'] as $field) {
            if (empty($order->{$prefix . $field}->rawValue)) {
                return $this->buildContactFromBillingAddress($order);
            }
        }
        return $this->buildContactFromDeliveryAddress($order);
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order $order
     * @return Contact
     */
    protected function buildContactFromBillingAddress(\OxidEsales\Eshop\Application\Model\Order $order)
    {
        return new Contact($order->oxorder__oxbillfname->rawValue . ' ' . $order->oxorder__oxbilllname->rawValue, $order->oxorder__oxbillemail->rawValue, $order->oxorder__oxbillfon->rawValue, $order->oxorder__oxbillcompany->rawValue);
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order $order
     * @return Contact
     */
    protected function buildContactFromDeliveryAddress(\OxidEsales\Eshop\Application\Model\Order $order)
    {
        return new Contact($order->oxorder__oxdelfname->rawValue . ' ' . $order->oxorder__oxdellname->rawValue, $order->oxorder__oxbillemail->rawValue, $order->oxorder__oxdelfon->rawValue, $order->oxorder__oxdelcompany->rawValue);
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order $order
     * @return Address
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildAddress(\OxidEsales\Eshop\Application\Model\Order $order)
    {
        $prefix = 'oxorder__';
        $requiredFields = ['oxdelstreet', 'oxdelstreetnr', 'oxdelzip', 'oxdelcity', 'oxdelcountryid'];
        foreach ($requiredFields as $field) {
            if (empty($order->{$prefix . $field}->rawValue)) {
                return $this->buildAddressFromBillingAddress($order);
            }
        }
        return $this->buildAddressFromDeliveryAddress($order);
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order $order
     * @return Address
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildAddressFromBillingAddress(\OxidEsales\Eshop\Application\Model\Order $order)
    {
        return new Address($order->oxorder__oxbillstreet->rawValue, $order->oxorder__oxbillstreetnr->rawValue, $order->oxorder__oxbillzip->rawValue, $order->oxorder__oxbillcity->rawValue, '', $this->loadCountrysIso3Code($order->oxorder__oxbillcountryid->rawValue));
    }

    /**
     * @param string $countryId
     * @return string
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function loadCountrysIso3Code($countryId)
    {
        $country = \oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
        $country->load($countryId);
        return $country->oxcountry__oxisoalpha3->rawValue;
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order $order
     * @return Address
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildAddressFromDeliveryAddress(\OxidEsales\Eshop\Application\Model\Order $order)
    {
        return new Address($order->oxorder__oxdelstreet->rawValue, $order->oxorder__oxdelstreetnr->rawValue, $order->oxorder__oxdelzip->rawValue, $order->oxorder__oxdelcity->rawValue, '', $this->loadCountrysIso3Code($order->oxorder__oxdelcountryid->rawValue));
    }

    /**
     * Uses the module configuration to build the sender.
     *
     * @return Sender
     */
    protected function buildSender()
    {
        $config = \OxidEsales\Eshop\Core\Registry::getConfig();
        return new Sender(new Address($config->getShopConfVar('mo_dhl__sender_street'), $config->getShopConfVar('mo_dhl__sender_street_number'), $config->getShopConfVar('mo_dhl__sender_zip'), $config->getShopConfVar('mo_dhl__sender_city'), '', $config->getShopConfVar('mo_dhl__sender_country')), $config->getShopConfVar('mo_dhl__sender_line1'), $config->getShopConfVar('mo_dhl__sender_line2'), $config->getShopConfVar('mo_dhl__sender_line3'));
    }

}
