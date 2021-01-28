<?php


namespace Mediaopt\DHL\Api\ProdWS;

class SearchParameterType
{

    /**
     * @var ProductID $productID
     */
    protected $productID = null;

    /**
     * @var ProductName $productName
     */
    protected $productName = null;

    /**
     * @var ProductPrice $productPrice
     */
    protected $productPrice = null;

    /**
     * @var ProductValidity $productValidity
     */
    protected $productValidity = null;

    /**
     * @var ProductDimensionList $productDimensionList
     */
    protected $productDimensionList = null;

    /**
     * @var ProductWeight $productWeight
     */
    protected $productWeight = null;

    /**
     * @var ProductPropertyList $productPropertyList
     */
    protected $productPropertyList = null;

    /**
     * @var ProductUsage $productUsage
     */
    protected $productUsage = null;

    /**
     * @var ProductCategory $productCategory
     */
    protected $productCategory = null;

    /**
     * @var ProductStampType $productStampType
     */
    protected $productStampType = null;

    /**
     * @var ProductGroup $productGroup
     */
    protected $productGroup = null;

    /**
     * @var Branch $branch
     */
    protected $branch = null;

    /**
     * @var destination $destination
     */
    protected $destination = null;

    /**
     * @var CountryGroupList $countryGroupList
     */
    protected $countryGroupList = null;

    /**
     * @var ChargeZoneList $chargeZoneList
     */
    protected $chargeZoneList = null;

    /**
     * @var CountryList $countryList
     */
    protected $countryList = null;

    /**
     * @var AdditionalProductList $additionalProductList
     */
    protected $additionalProductList = null;


    public function __construct()
    {

    }

    /**
     * @return ProductID
     */
    public function getProductID()
    {
      return $this->productID;
    }

    /**
     * @param ProductID $productID
     * @return SearchParameterType
     */
    public function setProductID($productID)
    {
      $this->productID = $productID;
      return $this;
    }

    /**
     * @return ProductName
     */
    public function getProductName()
    {
      return $this->productName;
    }

    /**
     * @param ProductName $productName
     * @return SearchParameterType
     */
    public function setProductName($productName)
    {
      $this->productName = $productName;
      return $this;
    }

    /**
     * @return ProductPrice
     */
    public function getProductPrice()
    {
      return $this->productPrice;
    }

    /**
     * @param ProductPrice $productPrice
     * @return SearchParameterType
     */
    public function setProductPrice($productPrice)
    {
      $this->productPrice = $productPrice;
      return $this;
    }

    /**
     * @return ProductValidity
     */
    public function getProductValidity()
    {
      return $this->productValidity;
    }

    /**
     * @param ProductValidity $productValidity
     * @return SearchParameterType
     */
    public function setProductValidity($productValidity)
    {
      $this->productValidity = $productValidity;
      return $this;
    }

    /**
     * @return ProductDimensionList
     */
    public function getProductDimensionList()
    {
      return $this->productDimensionList;
    }

    /**
     * @param ProductDimensionList $productDimensionList
     * @return SearchParameterType
     */
    public function setProductDimensionList($productDimensionList)
    {
      $this->productDimensionList = $productDimensionList;
      return $this;
    }

    /**
     * @return ProductWeight
     */
    public function getProductWeight()
    {
      return $this->productWeight;
    }

    /**
     * @param ProductWeight $productWeight
     * @return SearchParameterType
     */
    public function setProductWeight($productWeight)
    {
      $this->productWeight = $productWeight;
      return $this;
    }

    /**
     * @return ProductPropertyList
     */
    public function getProductPropertyList()
    {
      return $this->productPropertyList;
    }

    /**
     * @param ProductPropertyList $productPropertyList
     * @return SearchParameterType
     */
    public function setProductPropertyList($productPropertyList)
    {
      $this->productPropertyList = $productPropertyList;
      return $this;
    }

    /**
     * @return ProductUsage
     */
    public function getProductUsage()
    {
      return $this->productUsage;
    }

    /**
     * @param ProductUsage $productUsage
     * @return SearchParameterType
     */
    public function setProductUsage($productUsage)
    {
      $this->productUsage = $productUsage;
      return $this;
    }

    /**
     * @return ProductCategory
     */
    public function getProductCategory()
    {
      return $this->productCategory;
    }

    /**
     * @param ProductCategory $productCategory
     * @return SearchParameterType
     */
    public function setProductCategory($productCategory)
    {
      $this->productCategory = $productCategory;
      return $this;
    }

    /**
     * @return ProductStampType
     */
    public function getProductStampType()
    {
      return $this->productStampType;
    }

    /**
     * @param ProductStampType $productStampType
     * @return SearchParameterType
     */
    public function setProductStampType($productStampType)
    {
      $this->productStampType = $productStampType;
      return $this;
    }

    /**
     * @return ProductGroup
     */
    public function getProductGroup()
    {
      return $this->productGroup;
    }

    /**
     * @param ProductGroup $productGroup
     * @return SearchParameterType
     */
    public function setProductGroup($productGroup)
    {
      $this->productGroup = $productGroup;
      return $this;
    }

    /**
     * @return Branch
     */
    public function getBranch()
    {
      return $this->branch;
    }

    /**
     * @param Branch $branch
     * @return SearchParameterType
     */
    public function setBranch($branch)
    {
      $this->branch = $branch;
      return $this;
    }

    /**
     * @return destination
     */
    public function getDestination()
    {
      return $this->destination;
    }

    /**
     * @param destination $destination
     * @return SearchParameterType
     */
    public function setDestination($destination)
    {
      $this->destination = $destination;
      return $this;
    }

    /**
     * @return CountryGroupList
     */
    public function getCountryGroupList()
    {
      return $this->countryGroupList;
    }

    /**
     * @param CountryGroupList $countryGroupList
     * @return SearchParameterType
     */
    public function setCountryGroupList($countryGroupList)
    {
      $this->countryGroupList = $countryGroupList;
      return $this;
    }

    /**
     * @return ChargeZoneList
     */
    public function getChargeZoneList()
    {
      return $this->chargeZoneList;
    }

    /**
     * @param ChargeZoneList $chargeZoneList
     * @return SearchParameterType
     */
    public function setChargeZoneList($chargeZoneList)
    {
      $this->chargeZoneList = $chargeZoneList;
      return $this;
    }

    /**
     * @return CountryList
     */
    public function getCountryList()
    {
      return $this->countryList;
    }

    /**
     * @param CountryList $countryList
     * @return SearchParameterType
     */
    public function setCountryList($countryList)
    {
      $this->countryList = $countryList;
      return $this;
    }

    /**
     * @return AdditionalProductList
     */
    public function getAdditionalProductList()
    {
      return $this->additionalProductList;
    }

    /**
     * @param AdditionalProductList $additionalProductList
     * @return SearchParameterType
     */
    public function setAdditionalProductList($additionalProductList)
    {
      $this->additionalProductList = $additionalProductList;
      return $this;
    }

}
