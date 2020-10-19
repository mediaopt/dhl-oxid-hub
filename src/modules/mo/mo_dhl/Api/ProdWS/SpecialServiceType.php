<?php


namespace Mediaopt\DHL\Api\ProdWS;

class SpecialServiceType
{

    /**
     * @var ExtendedIdentifierType $extendedIdentifier
     */
    protected $extendedIdentifier = null;

    /**
     * @var string $condition
     */
    protected $condition = null;

    /**
     * @var UnitPriceType $priceDefinition
     */
    protected $priceDefinition = null;

    /**
     * @var SlidingPriceListType $slidingPriceList
     */
    protected $slidingPriceList = null;

    /**
     * @var PropertyList $propertyList
     */
    protected $propertyList = null;

    /**
     * @var GroupedPropertyList $groupedPropertyList
     */
    protected $groupedPropertyList = null;

    /**
     * @var ServiceDayList $serviceDayList
     */
    protected $serviceDayList = null;

    /**
     * @var ExclusionDayList $exclusionDayList
     */
    protected $exclusionDayList = null;

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
     * @return SpecialServiceType
     */
    public function setExtendedIdentifier($extendedIdentifier)
    {
      $this->extendedIdentifier = $extendedIdentifier;
      return $this;
    }

    /**
     * @return string
     */
    public function getCondition()
    {
      return $this->condition;
    }

    /**
     * @param string $condition
     * @return SpecialServiceType
     */
    public function setCondition($condition)
    {
      $this->condition = $condition;
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
     * @return SpecialServiceType
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
     * @return SpecialServiceType
     */
    public function setSlidingPriceList($slidingPriceList)
    {
      $this->slidingPriceList = $slidingPriceList;
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
     * @return SpecialServiceType
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
     * @return SpecialServiceType
     */
    public function setGroupedPropertyList($groupedPropertyList)
    {
      $this->groupedPropertyList = $groupedPropertyList;
      return $this;
    }

    /**
     * @return ServiceDayList
     */
    public function getServiceDayList()
    {
      return $this->serviceDayList;
    }

    /**
     * @param ServiceDayList $serviceDayList
     * @return SpecialServiceType
     */
    public function setServiceDayList($serviceDayList)
    {
      $this->serviceDayList = $serviceDayList;
      return $this;
    }

    /**
     * @return ExclusionDayList
     */
    public function getExclusionDayList()
    {
      return $this->exclusionDayList;
    }

    /**
     * @param ExclusionDayList $exclusionDayList
     * @return SpecialServiceType
     */
    public function setExclusionDayList($exclusionDayList)
    {
      $this->exclusionDayList = $exclusionDayList;
      return $this;
    }

}
