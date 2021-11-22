<?php


namespace Mediaopt\DHL\Controller\Admin;


use Mediaopt\DHL\Api\ProdWS\ExceptionDetailType;
use Mediaopt\DHL\Api\ProdWS\GetProductListRequestType;
use Mediaopt\DHL\Model\MoDHLInternetmarkeProduct;
use Mediaopt\DHL\Model\MoDHLInternetmarkeProductList;

class InternetmarkeProductsDetailsController extends AbstractAdminDHLController
{

    use ErrorDisplayTrait;

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

        if ($exception = $response->getException()) {
            $this->displayErrors(array_map([$this, 'parseExceptionDetails'], $exception->getExceptionDetail()));
            return;
        }

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
     * @param ExceptionDetailType $exception
     * @return string
     */
    public function parseExceptionDetails(ExceptionDetailType $exception) : string
    {
        return ($exception->getErrorMessage() . ': ' . $exception->getErrorDetail());
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
