<?php

namespace Mediaopt\DHL\Adapter;

use Mediaopt\DHL\Api\Retoure\Country;
use Mediaopt\DHL\Api\Warenpost\Content;
use Mediaopt\DHL\Api\Warenpost\Product;
use Mediaopt\DHL\Api\Warenpost\ShipmentNatureType;
use OxidEsales\Eshop\Application\Model\Order;
use Mediaopt\DHL\Api\Warenpost\ItemData;
use Mediaopt\DHL\Api\Warenpost\Paperwork;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Config;
use function oxNew;

class WarenpostShipmentOrderRequestBuilder extends BaseShipmentBuilder
{
    /**
     * @var array
     */
    protected $warenpostOrder;

    /**
     * @param Order $order
     * @return WarenpostShipmentOrderRequestBuilder
     */
    public function build(Order $order): WarenpostShipmentOrderRequestBuilder
    {
        $config = Registry::getConfig();
        $sender = $this->buildSender($config);

        $this->warenpostOrder = [
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
        return $this->warenpostOrder;
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
        $paperwork = new Paperwork($contactName);

        $paperwork->validate();

        return $paperwork->toArray();
    }

    /**
     * @param Order $order
     * @param Config $config
     * @param string $senderName
     * @return array
     * @throws DatabaseConnectionException
     */
    protected function buildItems(Order $order, Config $config, string $senderName): array
    {
        $customerData = $this->buildCustomerData($order);

        $recipient = $customerData['fname'] . ' ' . $customerData['lname'];
        $addressLine1 = $customerData['street'] . ' ' . $customerData['streetnr'];
        $country = $this->buildCountry($customerData['countryid']);
        $senderAddressLine1 = $config->getShopConfVar('mo_dhl__sender_street')
            . ' ' . $config->getShopConfVar('mo_dhl__sender_street_number');
        $senderCountry = $this->getIsoalpha2FromIsoalpha3(
            $config->getShopConfVar('mo_dhl__sender_country')
        );

        $itemData = new ItemData(
            $this->getProductId($order),
            $recipient,
            $addressLine1,
            $customerData['zip'],
            $customerData['city'],
            $country->getCountryISOCode(),
            $senderName,
            $senderAddressLine1,
            $config->getShopConfVar('mo_dhl__sender_zip'),
            $config->getShopConfVar('mo_dhl__sender_city'),
            $senderCountry,
            ShipmentNatureType::SALE_GOODS,
            $this->calculateWeight($order) * 1000
        );

        $itemData->setShipmentCurrency($order->getFieldData('oxcurrency'));
        $itemData->setContents($this->buildContetns($order));

        $itemData->validate();

        return [$itemData->toArray()];
    }

    /**
     * Return customer delivery data if set or bill data if not
     *
     * @param Order $order
     * @return array
     */
    protected function buildCustomerData(Order $order): array
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

        return $customerData;
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

    /**
     * @param Order $order
     * @return string
     */
    protected function getProductId(Order $order): string
    {
        $product = new Product(
            $order->getFieldData('MO_DHL_WARENPOST_PRODUCT_REGION'),
            $order->getFieldData('MO_DHL_WARENPOST_PRODUCT_TRACKING_TYPE'),
            $order->getFieldData('MO_DHL_WARENPOST_PRODUCT_PACKAGE_TYPE')
        );
        $product->validate();
        return $product->getProduct();
    }

    /**
     * @param Order $order
     * @return array
     */
    protected function buildContetns(Order $order): array
    {
        $config = Registry::getConfig();

        $contents = [];
        /**
         * @var OrderArticle $orderArticle
         */
        foreach ($order->getOrderArticles() as $orderArticle) {
            $price = sprintf('%.2f', $orderArticle->getPrice()->getPrice());
            $weightInGrams = $this->getArticleWeight($orderArticle, $config, true) * 1000;
            $amount = $orderArticle->getFieldData('oxamount');

            $content = new Content(
                $price,
                $weightInGrams,
                $amount
            );
            $contentPieceDescription = $orderArticle->getArticle()->getFieldData('oxtitle');
            if (strlen($contentPieceDescription) > 33) {
                $contentPieceDescription = substr($contentPieceDescription, 30) . '...';
            }
            $content->setContentPieceDescription($contentPieceDescription);
            $content->setContentPieceOrigin($this->getIsoalpha2FromIsoalpha3(
                $config->getShopConfVar('mo_dhl__sender_country')
            ));
            $content->validate();

            $contents[] = $content->toArray();
        }

        return $contents;
    }
}
