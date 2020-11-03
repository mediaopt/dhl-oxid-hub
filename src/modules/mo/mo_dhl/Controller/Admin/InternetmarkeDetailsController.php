<?php


namespace Mediaopt\DHL\Controller\Admin;


use Mediaopt\DHL\Api\ProdWS\AccountProdReferenceType;
use Mediaopt\DHL\Api\ProdWS\GetProductListRequestType;
use Mediaopt\DHL\Api\ProdWS\SalesProductType;
use Mediaopt\DHL\Model\MoDHLInternetmarkeProduct;
use Mediaopt\DHL\Model\MoDHLInternetmarkeProductList;
use OxidEsales\Eshop\Core\DatabaseProvider;

class InternetmarkeDetailsController extends AbstractAdminDHLController
{

    /**
     * @return string
     */
    protected function moDHLGetTemplateName() : string
    {
        return 'mo_dhl__internetmarke_details.tpl';
    }

    /**
     * @return string
     */
    protected function moDHLGetBaseClassName() : string
    {
        return MoDHLInternetmarkeProduct::class;
    }

    /**
     * @throws \Exception
     */
    public function updateProductList()
    {
        $adapter = new \Mediaopt\DHL\Adapter\DHLAdapter();
        $prodWS = $adapter->buildProdWS();
        $response = $prodWS->getProductList(new GetProductListRequestType(true, 0, false, null, null));

        foreach ($response->getResponse()->getSalesProductList()->getSalesProduct() as $listItem) {
            $product = MoDHLInternetmarkeProduct::fromProductType($listItem);
            $product->save();
        }
        foreach ($response->getResponse()->getBasicProductList()->getBasicProduct() as $listItem) {
            $product = MoDHLInternetmarkeProduct::fromProductType($listItem);
            $product->save();
        }
        foreach ($response->getResponse()->getAdditionalProductList()->getAdditionalProduct() as $listItem) {
            $product = MoDHLInternetmarkeProduct::fromProductType($listItem);
            $product->save();
        }
        return;
    }

    /**
     * @return MoDHLInternetmarkeProduct[]
     */
    public function getAdditionalProducts()
    {
        $list = \oxNew(MoDHLInternetmarkeProductList::class);
        $list->loadAssociatedProducts(explode(',', $this->getEditObject()->getFieldData('products')));
        return array_filter($list->getArray(), function ($product) {
            return $product->getFieldData('type') == MoDHLInternetmarkeProduct::INTERNETMARKE_PRODUCT_TYPE_ADDITIONAL;
        });
    }

    /**
     * @return MoDHLInternetmarkeProduct[]
     */
    public function getBasicProducts()
    {
        $list = \oxNew(MoDHLInternetmarkeProductList::class);
        $list->loadAssociatedProducts(explode(',', $this->getEditObject()->getFieldData('products')));
        return array_filter($list->getArray(), function ($product) {
            return $product->getFieldData('type') == MoDHLInternetmarkeProduct::INTERNETMARKE_PRODUCT_TYPE_BASIC;
        });
    }
}
