<?php

namespace Mediaopt\DHL\Adapter;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 derksen mediaopt GmbH
 */

use Mediaopt\Empfaengerservices\Address\Address;
use Mediaopt\Empfaengerservices\Address\Receiver;
use Mediaopt\Empfaengerservices\Address\Sender;
use Mediaopt\Empfaengerservices\Merchant\Ekp;
use Mediaopt\Empfaengerservices\Shipment\Contact;
use Mediaopt\Empfaengerservices\Shipment\Participation;
use Mediaopt\Empfaengerservices\Shipment\Process;
use Mediaopt\Empfaengerservices\Shipment\Shipment;

/**
 * This class transforms an \oxOrder object into a Shipment object.
 *
 * @author derksen mediaopt GmbH
 */
class EmpfaengerservicesShipmentBuilder
{
    /**
     * @var string
     */
    protected $ekp;

    /**
     * @var string[]
     */
    protected $deliverySetToProcessIdentifier = [];

    /**
     * @var string[]
     */
    protected $deliverySetToParticipationNumber = [];

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function __construct()
    {
        $this->ekp = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__merchant_ekp');
        $query = ' SELECT OXID, MO_DHL_PROCESS, MO_DHL_PARTICIPATION' . ' FROM ' . getViewName('oxdeliveryset');
        foreach ((array) \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC)->getAll($query) as $row) {
            $this->deliverySetToProcessIdentifier[$row['OXID']] = $row['MO_DHL_PROCESS'];
            $this->deliverySetToParticipationNumber[$row['OXID']] = $row['MO_DHL_PARTICIPATION'];
        }
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order $oxOrder
     * @return Shipment
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function build(\OxidEsales\Eshop\Application\Model\Order $oxOrder)
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
        $wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\EmpfaengerservicesWunschpaket::class);
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
        return new Sender(new Address($config->getShopConfVar('mo_dhl__export_street'), $config->getShopConfVar('mo_dhl__export_street_number'), $config->getShopConfVar('mo_dhl__export_zip'), $config->getShopConfVar('mo_dhl__export_city'), '', $config->getShopConfVar('mo_dhl__export_country')), $config->getShopConfVar('mo_dhl__export_line1'), $config->getShopConfVar('mo_dhl__export_line2'), $config->getShopConfVar('mo_dhl__export_line3'));
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order $order
     * @return float
     */
    protected function calculateWeight(\OxidEsales\Eshop\Application\Model\Order $order)
    {
        $weight = 0;
        foreach ($order->getOrderArticles() as $orderArticle) {
            /** @var \OxidEsales\Eshop\Application\Model\OrderArticle $orderArticle */
            $weight += (float) $orderArticle->getArticle()->getWeight();
        }
        return $weight;
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order $order
     * @return Ekp|null
     */
    protected function getEkp(\OxidEsales\Eshop\Application\Model\Order $order)
    {
        try {
            return Ekp::build($order->oxorder__mo_dhl_ekp->rawValue ?: $this->ekp);
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order $order
     * @return Process|null
     */
    protected function getProcess(\OxidEsales\Eshop\Application\Model\Order $order)
    {
        try {
            $identifier = $order->oxorder__mo_dhl_process->rawValue ?: $this->deliverySetToProcessIdentifier[$order->oxorder__oxdeltype->rawValue];
            return Process::build($identifier);
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }

    /**
     * @param \OxidEsales\Eshop\Application\Model\Order $order
     * @return Participation|null
     */
    protected function getParticipation(\OxidEsales\Eshop\Application\Model\Order $order)
    {
        try {
            $number = $order->oxorder__mo_dhl_participation->rawValue ?: $this->deliverySetToParticipationNumber[$order->oxorder__oxdeltype->rawValue];
            return Participation::build($number);
        } catch (\InvalidArgumentException $exception) {
            return null;
        }
    }
}
