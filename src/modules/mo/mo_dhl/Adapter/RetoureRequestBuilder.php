<?php


namespace Mediaopt\DHL\Adapter;


use Mediaopt\DHL\Api\Retoure\Country;
use Mediaopt\DHL\Api\Retoure\ReturnOrder;
use Mediaopt\DHL\Api\Retoure\SimpleAddress;
use Mediaopt\DHL\Application\Model\Order;
use OxidEsales\Eshop\Core\Registry;

class RetoureRequestBuilder
{

    /**
     * @param Order $order
     * @return ReturnOrder
     */
    public function build(Order $order)
    {
        $returnOrder = new ReturnOrder();
        $returnOrder
            ->setCustomerReference($order->getFieldData('oxordernr'))
            ->setShipmentReference(Registry::getConfig()->getShopConfVar('mo_dhl__retoure_reference_prefix') . $order->getFieldData('oxordernr'))
            ->setReceiverId($this->buildReceiverId($order->getFieldData('oxbillcountryid')))
            ->setSenderAddress($this->buildSenderAddress($order))
            ->setEmail($order->getFieldData('oxbillemail'))
            ->setTelephoneNumber($order->moDHLGetAddressData('fon'));
        return $returnOrder;
    }

    /**
     * @param string $countryId
     *
     * @return string
     */
    protected function buildReceiverId(string $countryId)
    {
        $country = \oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
        $country->load($countryId);
        if (!$receiverId = $country->getFieldData('mo_dhl_retoure_receiver_id')) {
            throw new \InvalidArgumentException(sprintf(Registry::getLang()->translateString('MO_DHL__NO_RECEIVER_ID'), $country->getFieldData('title')));
        }
        return $receiverId;
    }

    /**
     * @param  Order $order
     * @return SimpleAddress
     */
    protected function buildSenderAddress(Order $order)
    {
        $address = new SimpleAddress();
        $config = Registry::getConfig();
        $address->setName1($order->getFieldData('oxbillfname') . ' ' . $order->getFieldData('oxbilllname'))
            ->setName2($order->getFieldData('oxbillcompany') ?: '')
            ->setName3($order->getFieldData('oxbilladdinfo') ?: '')
            ->setStreetName($order->getFieldData('oxbillstreet'))
            ->setHouseNumber($order->getFieldData('oxbillstreetnr'))
            ->setPostCode($order->getFieldData('oxbillzip'))
            ->setCity($order->getFieldData('oxbillcity'))
            ->setCountry($this->buildCountry($order->getFieldData('oxbillcountryid')));
        return $address;
    }

    /**
     * @param string $countryId
     * @return Country
     */
    protected function buildCountry(string $countryId)
    {
        $country = \oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
        $country->load($countryId);
        return (new Country())
            ->setCountryISOCode($country->getFieldData('oxisoalpha3'))
            ->setCountry($country->getFieldData('oxtitle'));
    }
}