<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2020 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Model;


use Mediaopt\DHL\Api\ProdWS\AccountProdReferenceType;
use Mediaopt\DHL\Api\ProdWS\AdditionalProductType;
use Mediaopt\DHL\Api\ProdWS\BasicProductType;
use Mediaopt\DHL\Api\ProdWS\SalesProductType;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\Registry;

/**
 * @author Mediaopt GmbH
 */
class MoDHLInternetmarkeProduct extends BaseModel
{

    /**
     * @var int
     */
    const INTERNETMARKE_PRODUCT_TYPE_SALES = 0;

    /**
     * @var int
     */
    const INTERNETMARKE_PRODUCT_TYPE_BASIC = 1;

    /**
     * @var int
     */
    const INTERNETMARKE_PRODUCT_TYPE_ADDITIONAL = 2;

    /**
     * @var string
     */
    protected $_sCoreTable = 'mo_dhl_internetmarke_products';

    /**
     * @var string
     */
    protected $_sClassName = self::class;

    /**
     */
    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    /**
     * @param SalesProductType|BasicProductType|AdditionalProductType $productType
     * @return MoDHLInternetmarkeProduct
     */
    public static function fromProductType($productType)
    {
        $product = new self();

        $data = [
            'shopId' => Registry::getConfig()->getShopId(),
            'oxid' => $productType instanceof SalesProductType ? self::extractExternalIdentifier($productType) : $productType->getExtendedIdentifier()->getProdWSID(),
            'name'   => $productType->getExtendedIdentifier()->getName(),
            'isNational' => $productType->getExtendedIdentifier()->getDestination() === 'national',
            'annotation' => trim($productType->getExtendedIdentifier()->getAnnotation() . ' ' . $productType->getExtendedIdentifier()->getDescription()),
        ];
        if ($productType instanceof SalesProductType) {
            $data['type'] = self::INTERNETMARKE_PRODUCT_TYPE_SALES;
            $data['price'] = $productType->getPriceDefinition()->getPrice()->getCalculatedGrossPrice()->getValue();
            $dimensionInfo = $productType->getDimensionList();
            $data['dimension'] = "{$dimensionInfo->getWidth()->getMinValue()}-{$dimensionInfo->getWidth()->getMaxValue()}x{$dimensionInfo->getLength()->getMinValue()}-{$dimensionInfo->getLength()->getMaxValue()}x{$dimensionInfo->getHeight()->getMinValue()}-{$dimensionInfo->getHeight()->getMaxValue()} {$dimensionInfo->getWidth()->getUnit()}";
            $data['weight'] = !$productType->getWeight() ? null : "{$productType->getWeight()->getMinValue()}-{$productType->getWeight()->getMaxValue()} {$productType->getWeight()->getUnit()}";
            foreach ($productType->getAccountProductReferenceList()->getAccountProductReference() as $productReference) {
                $data['products'][] = $productReference->getProdWSID();
            }
            $data['products'] = implode(',', $data['products']);
        } elseif ($productType instanceof BasicProductType) {
            $data['type'] = self::INTERNETMARKE_PRODUCT_TYPE_BASIC;
            $data['price'] = $productType->getPriceDefinition()->getGrossPrice()->getValue();
            $dimensionInfo = $productType->getDimensionList();
            $data['weight'] = !$productType->getWeight() ? null : "{$productType->getWeight()->getMinValue()}-{$productType->getWeight()->getMaxValue()} {$productType->getWeight()->getUnit()}";
            $data['dimension'] = "{$dimensionInfo->getWidth()->getMinValue()}-{$dimensionInfo->getWidth()->getMaxValue()}x{$dimensionInfo->getLength()->getMinValue()}-{$dimensionInfo->getLength()->getMaxValue()}x{$dimensionInfo->getHeight()->getMinValue()}-{$dimensionInfo->getHeight()->getMaxValue()} {$dimensionInfo->getWidth()->getUnit()}";
        } else {
            $data['type'] = self::INTERNETMARKE_PRODUCT_TYPE_ADDITIONAL;
            $data['price'] = $productType->getPriceDefinition()->getGrossPrice()->getValue();
        }
        $product->assign($data);
        return $product;
    }

    /**
     * @param SalesProductType|BasicProductType|AdditionalProductType $productType
     * @return string
     */
    protected static function extractExternalIdentifier($productType) {
        $identifiers = $productType->getExtendedIdentifier()->getExternIdentifier();
        foreach ($identifiers as $identifier) {
            if ($identifier->getSource() === 'PPL') {
                return $identifier->getId();
            }
        }
        throw new \Exception('Could not extract external identifier');
    }

    /**
     * @return bool
     */
    public function isSalesProduct()
    {
        return $this->getFieldData('type') === self::INTERNETMARKE_PRODUCT_TYPE_SALES;
    }

    /**
     * @return bool
     */
    public function isBasicProduct()
    {
        return $this->getFieldData('type') === self::INTERNETMARKE_PRODUCT_TYPE_BASIC;
    }

    /**
     * @return bool
     */
    public function isAdditionalProduct()
    {
        return $this->getFieldData('type') === self::INTERNETMARKE_PRODUCT_TYPE_ADDITIONAL;
    }
}
