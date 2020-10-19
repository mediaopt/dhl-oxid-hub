<?php


namespace Mediaopt\DHL\Api\ProdWS;

class BasicProductType
{

    /**
     * @var ExtendedIdentifierType $extendedIdentifier
     */
    protected $extendedIdentifier = null;

    /**
     * @var UnitPriceType $priceDefinition
     */
    protected $priceDefinition = null;

    /**
     * @var SlidingPriceListType $slidingPriceList
     */
    protected $slidingPriceList = null;

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
     * @var GroupedPropertyList $groupedPropertyList
     */
    protected $groupedPropertyList = null;

    /**
     * @var DestinationAreaType $destinationArea
     */
    protected $destinationArea = null;

    /**
     * @var DocumentReferenceList $documentReferenceList
     */
    protected $documentReferenceList = null;

    /**
     * @param ExtendedIdentifierType $extendedIdentifier
     * @param UnitPriceType          $priceDefinition
     */
    public function __construct($extendedIdentifier, $priceDefinition)
    {
      $this->extendedIdentifier = $extendedIdentifier;
      $this->priceDefinition = $priceDefinition;
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
     * @return BasicProductType
     */
    public function setExtendedIdentifier($extendedIdentifier)
    {
      $this->extendedIdentifier = $extendedIdentifier;
      return $this;
    }

    /**
     * @return UnitPriceType
     */
    public function getPriceDefinition()
    {
      return $this->priceDefinition;
    }

    /**
     * @param UnitPriceType $priceDefinition
     * @return BasicProductType
     */
    public function setPriceDefinition($priceDefinition)
    {
      $this->priceDefinition = $priceDefinition;
      return $this;
    }

    /**
     * @return SlidingPriceListType
     */
    public function getSlidingPriceList()
    {
      return $this->slidingPriceList;
    }

    /**
     * @param SlidingPriceListType $slidingPriceList
     * @return BasicProductType
     */
    public function setSlidingPriceList($slidingPriceList)
    {
      $this->slidingPriceList = $slidingPriceList;
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
     * @return BasicProductType
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
     * @return BasicProductType
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
     * @return BasicProductType
     */
    public function setPropertyList($propertyList)
    {
      $this->propertyList = $propertyList;
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
     * @return BasicProductType
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
     * @return BasicProductType
     */
    public function setDestinationArea($destinationArea)
    {
      $this->destinationArea = $destinationArea;
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
     * @return BasicProductType
     */
    public function setDocumentReferenceList($documentReferenceList)
    {
      $this->documentReferenceList = $documentReferenceList;
      return $this;
    }

}
