<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GroupedPropertyList
{

    /**
     * @var GroupedPropertyType $groupedProperty
     */
    protected $groupedProperty = null;

    /**
     * @param GroupedPropertyType $groupedProperty
     */
    public function __construct($groupedProperty)
    {
      $this->groupedProperty = $groupedProperty;
    }

    /**
     * @return GroupedPropertyType
     */
    public function getGroupedProperty()
    {
      return $this->groupedProperty;
    }

    /**
     * @param GroupedPropertyType $groupedProperty
     * @return GroupedPropertyList
     */
    public function setGroupedProperty($groupedProperty)
    {
      $this->groupedProperty = $groupedProperty;
      return $this;
    }

}
