<?php


namespace Mediaopt\DHL\Api\ProdWS;

class SalesProductType
{

    /**
     * @var ExtendedIdentifierType $extendedIdentifier
     */
    protected $extendedIdentifier = null;

    /**
     * @var PriceDefinitionType $priceDefinition
     */
    protected $priceDefinition = null;

    /**
     * @var DimensionList $dimensionList
     */
    protected $dimensionList = null;

    /**
     * @var NumericValueType $weight
     */
    protected $weight = null;

    /**
     * @var PropertyList $propertyList
     */
    protected $propertyList = null;

    /**
     * @var CountrySpecificPropertyList $countrySpecificPropertyList
     */
    protected $countrySpecificPropertyList = null;

    /**
     * @var GroupedPropertyList $groupedPropertyList
     */
    protected $groupedPropertyList = null;

    /**
     * @var DestinationAreaType $destinationArea
     */
    protected $destinationArea = null;

    /**
     * @var UsageList $usageList
     */
    protected $usageList = null;

    /**
     * @var CategoryList $categoryList
     */
    protected $categoryList = null;

    /**
     * @var StampTypeList $stampTypeList
     */
    protected $stampTypeList = null;

    /**
     * @var DocumentReferenceList $documentReferenceList
     */
    protected $documentReferenceList = null;

    /**
     * @var ReferenceTextList $referenceTextList
     */
    protected $referenceTextList = null;

    /**
     * @var AccountProductReferenceList $accountProductReferenceList
     */
    protected $accountProductReferenceList = null;

    /**
     * @var AccountServiceReferenceList $accountServiceReferenceList
     */
    protected $accountServiceReferenceList = null;

    /**
     * @param ExtendedIdentifierType      $extendedIdentifier
     * @param PriceDefinitionType         $priceDefinition
     * @param AccountProductReferenceList $accountProductReferenceList
     */
    public function __construct($extendedIdentifier, $priceDefinition, $accountProductReferenceList)
    {
      $this->extendedIdentifier = $extendedIdentifier;
      $this->priceDefinition = $priceDefinition;
      $this->accountProductReferenceList = $accountProductReferenceList;
    }

    /**
     * @return ExtendedIdentifierType
     */
    public function getExtendedIdentifier()
    {
      return $this->extendedIdentifier;
    }

    /**
     * @param ExtendedIdentifierType $extendedIdentifier
     * @return SalesProductType
     */
    public function setExtendedIdentifier($extendedIdentifier)
    {
      $this->extendedIdentifier = $extendedIdentifier;
      return $this;
    }

    /**
     * @return PriceDefinitionType
     */
    public function getPriceDefinition()
    {
      return $this->priceDefinition;
    }

    /**
     * @param PriceDefinitionType $priceDefinition
     * @return SalesProductType
     */
    public function setPriceDefinition($priceDefinition)
    {
      $this->priceDefinition = $priceDefinition;
      return $this;
    }

    /**
     * @return DimensionList
     */
    public function getDimensionList()
    {
      return $this->dimensionList;
    }

    /**
     * @param DimensionList $dimensionList
     * @return SalesProductType
     */
    public function setDimensionList($dimensionList)
    {
      $this->dimensionList = $dimensionList;
      return $this;
    }

    /**
     * @return NumericValueType
     */
    public function getWeight()
    {
      return $this->weight;
    }

    /**
     * @param NumericValueType $weight
     * @return SalesProductType
     */
    public function setWeight($weight)
    {
      $this->weight = $weight;
      return $this;
    }

    /**
     * @return PropertyList
     */
    public function getPropertyList()
    {
      return $this->propertyList;
    }

    /**
     * @param PropertyList $propertyList
     * @return SalesProductType
     */
    public function setPropertyList($propertyList)
    {
      $this->propertyList = $propertyList;
      return $this;
    }

    /**
     * @return CountrySpecificPropertyList
     */
    public function getCountrySpecificPropertyList()
    {
      return $this->countrySpecificPropertyList;
    }

    /**
     * @param CountrySpecificPropertyList $countrySpecificPropertyList
     * @return SalesProductType
     */
    public function setCountrySpecificPropertyList($countrySpecificPropertyList)
    {
      $this->countrySpecificPropertyList = $countrySpecificPropertyList;
      return $this;
    }

    /**
     * @return GroupedPropertyList
     */
    public function getGroupedPropertyList()
    {
      return $this->groupedPropertyList;
    }

    /**
     * @param GroupedPropertyList $groupedPropertyList
     * @return SalesProductType
     */
    public function setGroupedPropertyList($groupedPropertyList)
    {
      $this->groupedPropertyList = $groupedPropertyList;
      return $this;
    }

    /**
     * @return DestinationAreaType
     */
    public function getDestinationArea()
    {
      return $this->destinationArea;
    }

    /**
     * @param DestinationAreaType $destinationArea
     * @return SalesProductType
     */
    public function setDestinationArea($destinationArea)
    {
      $this->destinationArea = $destinationArea;
      return $this;
    }

    /**
     * @return UsageList
     */
    public function getUsageList()
    {
      return $this->usageList;
    }

    /**
     * @param UsageList $usageList
     * @return SalesProductType
     */
    public function setUsageList($usageList)
    {
      $this->usageList = $usageList;
      return $this;
    }

    /**
     * @return CategoryList
     */
    public function getCategoryList()
    {
      return $this->categoryList;
    }

    /**
     * @param CategoryList $categoryList
     * @return SalesProductType
     */
    public function setCategoryList($categoryList)
    {
      $this->categoryList = $categoryList;
      return $this;
    }

    /**
     * @return StampTypeList
     */
    public function getStampTypeList()
    {
      return $this->stampTypeList;
    }

    /**
     * @param StampTypeList $stampTypeList
     * @return SalesProductType
     */
    public function setStampTypeList($stampTypeList)
    {
      $this->stampTypeList = $stampTypeList;
      return $this;
    }

    /**
     * @return DocumentReferenceList
     */
    public function getDocumentReferenceList()
    {
      return $this->documentReferenceList;
    }

    /**
     * @param DocumentReferenceList $documentReferenceList
     * @return SalesProductType
     */
    public function setDocumentReferenceList($documentReferenceList)
    {
      $this->documentReferenceList = $documentReferenceList;
      return $this;
    }

    /**
     * @return ReferenceTextList
     */
    public function getReferenceTextList()
    {
      return $this->referenceTextList;
    }

    /**
     * @param ReferenceTextList $referenceTextList
     * @return SalesProductType
     */
    public function setReferenceTextList($referenceTextList)
    {
      $this->referenceTextList = $referenceTextList;
      return $this;
    }

    /**
     * @return AccountProductReferenceList
     */
    public function getAccountProductReferenceList()
    {
      return $this->accountProductReferenceList;
    }

    /**
     * @param AccountProductReferenceList $accountProductReferenceList
     * @return SalesProductType
     */
    public function setAccountProductReferenceList($accountProductReferenceList)
    {
      $this->accountProductReferenceList = $accountProductReferenceList;
      return $this;
    }

    /**
     * @return AccountServiceReferenceList
     */
    public function getAccountServiceReferenceList()
    {
      return $this->accountServiceReferenceList;
    }

    /**
     * @param AccountServiceReferenceList $accountServiceReferenceList
     * @return SalesProductType
     */
    public function setAccountServiceReferenceList($accountServiceReferenceList)
    {
      $this->accountServiceReferenceList = $accountServiceReferenceList;
      return $this;
    }

}
