<?php

namespace Mediaopt\DHL\Adapter;

use Mediaopt\DHL\Api\GKV\CountryType;
use Mediaopt\DHL\Api\GKV\NameType;
use Mediaopt\DHL\Api\GKV\NativeAddressType;
use Mediaopt\DHL\Api\GKV\ReceiverType;
use Mediaopt\DHL\Api\GKV\ShipperType;
use Mediaopt\DHL\Api\Internetmarke\Address;
use Mediaopt\DHL\Api\Internetmarke\AddressBinding;
use Mediaopt\DHL\Api\Internetmarke\CompanyName;
use Mediaopt\DHL\Api\Internetmarke\Name;
use Mediaopt\DHL\Api\Internetmarke\NamedAddress;
use Mediaopt\DHL\Api\Internetmarke\PersonName;
use Mediaopt\DHL\Api\Internetmarke\ShoppingCartPDFPosition;
use Mediaopt\DHL\Api\Internetmarke\VoucherLayout;
use Mediaopt\DHL\Api\Internetmarke\VoucherPosition;
use Mediaopt\DHL\ServiceProvider\Branch;
use Mediaopt\DHL\Application\Model\Order;
use OxidEsales\Eshop\Core\Registry;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2020 Mediaopt GmbH
 */

class InternetmarkeShoppingCartPDFPositionBuilder
{
    /**
     * @param Order $order
     * @return ShoppingCartPDFPosition
     */
    public function build(Order $order)
    {
        $position = new ShoppingCartPDFPosition($order->getFieldData('MO_DHL_PARTICIPATION'), VoucherLayout::AddressZone, new VoucherPosition(1, 1, 1));
        $position->setAddress($this->buildAddress($order));
        return $position;
    }

    /**
     * @param Order $order
     * @return AddressBinding
     */
    protected function buildAddress(Order $order)
    {
        return new AddressBinding($this->buildSender($order), $this->buildReceiver($order));
    }

    /**
     * @param Order $order
     * @return NamedAddress
     */
    protected function buildSender(Order $order)
    {
        $config = Registry::getConfig();

        $name = new Name(null, new CompanyName($config->getShopConfVar('mo_dhl__sender_line1')));
        $address = new Address(
            $config->getShopConfVar('mo_dhl__sender_street'),
            $config->getShopConfVar('mo_dhl__sender_street_number'),
            $config->getShopConfVar('mo_dhl__sender_zip'),
            $config->getShopConfVar('mo_dhl__sender_city'),
            $config->getShopConfVar('mo_dhl__sender_country')
        );
        $address->setAdditional(trim($config->getShopConfVar('mo_dhl__sender_line2') . ' '. $config->getShopConfVar('mo_dhl__sender_line3')));
        return new NamedAddress($name, $address);
    }

    /**
     * @param Order $order
     * @return NamedAddress
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildReceiver(Order $order)
    {
        $personName = new PersonName($order->moDHLGetAddressData('fname'), $order->moDHLGetAddressData('lname'));
        if ($order->moDHLGetAddressData('company')) {
            $company = new CompanyName($order->moDHLGetAddressData('company'));
            $company->setPersonName($personName);
            $name = new Name(null, $company);
        } else {
            $name = new Name($personName, null);
        }
        $address = new Address(
            $order->moDHLGetAddressData('street'),
            $order->moDHLGetAddressData('streetnr'),
            $order->moDHLGetAddressData('zip'),
            $order->moDHLGetAddressData('city'),
            $this->buildCountry($order->moDHLGetAddressData('countryid'))
        );
        $address->setAdditional($order->moDHLGetAddressData('addinfo'));
        return new NamedAddress($name, $address);
    }

    /**
     * @param string $countryId
     * @return string
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildCountry($countryId)
    {
        $country = \oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
        $country->load($countryId);
        return $country->getFieldData('oxisoalpha3');
    }
}