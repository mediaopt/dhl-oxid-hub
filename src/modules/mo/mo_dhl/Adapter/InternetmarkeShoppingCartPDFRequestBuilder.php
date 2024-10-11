<?php

namespace Mediaopt\DHL\Adapter;

use Mediaopt\DHL\Api\Internetmarke\CreateShopOrderIdRequest;
use Mediaopt\DHL\Api\Internetmarke\ShoppingCartPDFPosition;
use Mediaopt\DHL\Api\Internetmarke\ShoppingCartPDFRequestType;
use Mediaopt\DHL\Application\Model\Order;
use Mediaopt\DHL\Model\MoDHLInternetmarkeProduct;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2020 Mediaopt GmbH
 */

class InternetmarkeShoppingCartPDFRequestBuilder
{

    /**
     * @var int[]|null
     */
    protected $priceList = null;

    /**
     * @param string[] $orderIds
     * @return ShoppingCartPDFRequestType
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    public function build(array $orderIds): ShoppingCartPDFRequestType
    {
        $positions = array_map([$this, 'buildShoppingCartPdfPosition'], $orderIds);
        $total = array_sum(array_map([$this, 'getPrice'], $positions));
        $request =  new ShoppingCartPDFRequestType(Registry::getConfig()->getConfigParam('mo_dhl__internetmarke_layout'), $positions, $total);
        $request->setShopOrderId($this->buildShopOrderId());
        return $request;
    }

    /**
     * @param string $orderId
     * @return ShoppingCartPDFPosition
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     */
    protected function buildShoppingCartPdfPosition(string $orderId): ShoppingCartPDFPosition
    {
        $order = \oxNew(Order::class);
        $order->load($orderId);
        return Registry::get(InternetmarkeShoppingCartPDFPositionBuilder::class)->build($order);
    }

    /**
     * @return int[]
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    protected function getPriceList()
    {
        if ($this->priceList === null) {
            $db = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);
            $prices = $db->getAll('SELECT oxid, price from mo_dhl_internetmarke_products WHERE type = ?', [MoDHLInternetmarkeProduct::INTERNETMARKE_PRODUCT_TYPE_SALES]);
            $this->priceList = array_combine(array_column($prices, 'oxid'), array_column($prices, 'price'));
        }
        return $this->priceList;
    }

    /**
     * @param ShoppingCartPDFPosition $position
     * @return float
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    protected function getPrice(ShoppingCartPDFPosition $position)
    {
        $prices = $this->getPriceList();
        return 100.0 * $prices[$position->getProductCode()];
    }

    /**
     * @return string|null
     */
    protected function buildShopOrderId()
    {
        $internetMarke = Registry::get(DHLAdapter::class)->buildInternetmarke();
        return $internetMarke->createShopOrderId(new CreateShopOrderIdRequest())->getShopOrderId();
    }
}