<?php


namespace Mediaopt\DHL\Api\ProdWS;

class StampTypeList
{

    /**
     * @var GroupedPropertyType $stampType
     */
    protected $stampType = null;

    /**
     * @param GroupedPropertyType $stampType
     */
    public function __construct($stampType)
    {
      $this->stampType = $stampType;
    }

    /**
     * @return GroupedPropertyType
     */
    public function getStampType()
    {
      return $this->stampType;
    }

    /**
     * @param GroupedPropertyType $stampType
     * @return StampTypeList
     */
    public function setStampType($stampType)
    {
      $this->stampType = $stampType;
      return $this;
    }

}
