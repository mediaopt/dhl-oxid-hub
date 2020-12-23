<?php

namespace Mediaopt\DHL\Adapter;

use Mediaopt\DHL\Api\Retoure\Country;
use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Warenpost\ItemData;
use Mediaopt\DHL\Warenpost\Paperwork;

class WarenpostShipmentOrderRequestBuilder
{
    /**
     * @var string
     */
    const DHL_WARENPOST_PRODUCT_ID = '10292';

    /**
     * @var array
     */
    protected $order;

    /**
     * @param string $orderId
     * @return WarenpostShipmentOrderRequestBuilder
     */
    public function build(string $orderId): WarenpostShipmentOrderRequestBuilder
    {
        $order = \oxNew(Order::class);
        $order->load($orderId);

        //todo get store contact person
        $paperwork = new Paperwork(
            'Store contact person',
            1
        );

        $country = $this->buildCountry($order->getFieldData('oxbillcountryid'));

        $itemData = new ItemData(
            self::DHL_WARENPOST_PRODUCT_ID,
            $order->getFieldData('oxbillfname') . ' ' . $order->getFieldData('oxbilllname'),
            $order->getFieldData('oxbillstreet') . ' ' . $order->getFieldData('oxbillstreetnr'),
            $order->getFieldData('oxbillcity'),
            $country->getCountryISOCode(),
            '500' //todo weight
        );

        $itemData->setPostalCode($order->getFieldData('oxbillzip'));

        //todo sender info
        $itemData->setSenderCity('Berlin');
        $itemData->setSenderCountry('DE');
        $itemData->setSenderAddressLine1('Address');
        $itemData->setSenderName('Store contact person');
        $itemData->setSenderPostalCode('14557');
        $items[] = $itemData->toArray();

        $this->order = [
            "orderStatus"=>"FINALIZE",
            "paperwork" => $paperwork->toArray(),
            "items" => $items
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function getOrder(): array
    {
        return $this->order;
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
            ->setCountryISOCode($country->getFieldData('oxisoalpha2'))
            ->setCountry($country->getFieldData('oxtitle'));
    }
}
