<?php

namespace Mediaopt\DHL\Adapter;

use Mediaopt\DHL\Api\Retoure\Country;
use OxidEsales\Eshop\Application\Model\Order;
use Mediaopt\DHL\Api\Warenpost\ItemData;
use Mediaopt\DHL\Api\Warenpost\Paperwork;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Config;
use function oxNew;

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
     * @param Order $order
     * @return WarenpostShipmentOrderRequestBuilder
     */
    public function build(Order $order): WarenpostShipmentOrderRequestBuilder
    {
        $config = Registry::getConfig();
        $sender = $this->buildSender($config);

        $this->order = [
            "orderStatus" => "FINALIZE",
            "paperwork" => $this->buildPaperwork($sender),
            "items" => $this->buildItems($order, $config, $sender)
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
     * @param Config $config
     * @return string
     */
    protected function buildSender(Config $config): string
    {
        return $config->getShopConfVar('mo_dhl__sender_line1')
            . ' ' . $config->getShopConfVar('mo_dhl__sender_line2')
            . ' ' . $config->getShopConfVar('mo_dhl__sender_line3');
    }

    /**
     * @param string $contactName
     * @return array
     */
    protected function buildPaperwork(string $contactName): array
    {
        $paperwork = new Paperwork($contactName, 1);

        $paperwork->validate();

        return $paperwork->toArray();
    }

    /**
     * @param Order $order
     * @param Config $config
     * @param string $contactName
     * @return array
     * @throws DatabaseConnectionException
     */
    protected function buildItems(Order $order, Config $config, string $contactName): array
    {
        $itemData = $this->buildItemData($order);

        $itemData->setServiceLevel('REGISTERED');

        $itemData->setPostalCode($order->getFieldData('oxbillzip'));

        $senderCity = $config->getShopConfVar('mo_dhl__sender_city');
        $senderIso2 = $this->getIsoalpha2FromIsoalpha3($config->getShopConfVar('mo_dhl__retoure_receiver_country'));
        $senderAddressLine1 = $config->getShopConfVar('mo_dhl__sender_street')
            . ' ' . $config->getShopConfVar('mo_dhl__sender_street_number');
        $senderZip = $config->getShopConfVar('mo_dhl__sender_zip');

        $itemData->setSenderCity($senderCity);
        $itemData->setSenderCountry($senderIso2);
        $itemData->setSenderAddressLine1($senderAddressLine1);
        $itemData->setSenderName($contactName);
        $itemData->setSenderPostalCode($senderZip);

        $itemData->validate();
        return [$itemData->toArray()];
    }

    /**
     * @param Order $order
     * @return ItemData
     */
    protected function buildItemData(Order $order): ItemData
    {
        $requiredFields = [
            'countryid',
            'city',
            'zip',
            'street',
            'streetnr',
            'fname',
            'lname'
        ];
        $customerDataDelivery = [];
        $customerDataBill = [];
        foreach ($requiredFields as $field) {
            $customerDataBill[$field] = $order->getFieldData('oxbill' . $field);
            if (!empty($order->getFieldData('oxdel' . $field))) {
                $customerDataDelivery[$field] = $order->getFieldData('oxdel' . $field);
            }
        }

        if (count($customerDataDelivery) < count($requiredFields)) {
            $customerData = $customerDataBill;
        } else {
            $customerData = $customerDataDelivery;
        }

        $country = $this->buildCountry($customerData['countryid']);
        $itemData = new ItemData(
            self::DHL_WARENPOST_PRODUCT_ID,
            $customerData['fname'] . ' ' . $customerData['lname'],
            $customerData['street'] . ' ' . $customerData['streetnr'],
            $customerData['city'],
            $country->getCountryISOCode(),
            2000 //todo weight
        );
        $itemData->setPostalCode($customerData['zip']);
        return $itemData;
    }

    /**
     * @param string $countryId
     * @return Country
     */
    protected function buildCountry(string $countryId): Country
    {
        $country = oxNew(\OxidEsales\Eshop\Application\Model\Country::class);
        $country->load($countryId);
        return (new Country())
            ->setCountryISOCode($country->getFieldData('oxisoalpha2'))
            ->setCountry($country->getFieldData('oxtitle'));
    }

    /**
     * @param string $isoalpha3
     * @return false|string
     * @throws DatabaseConnectionException
     */
    protected function getIsoalpha2FromIsoalpha3(string $isoalpha3)
    {
        return DatabaseProvider::getDb()
            ->getOne('SELECT OXISOALPHA2 from oxcountry where OXISOALPHA3 = ? ', [$isoalpha3]);
    }
}
