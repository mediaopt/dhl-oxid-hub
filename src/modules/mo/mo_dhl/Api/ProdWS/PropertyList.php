<?php


namespace Mediaopt\DHL\Api\ProdWS;

class PropertyList
{

    /**
     * @var PropertyType $property
     */
    protected $property = null;

    /**
     * @param PropertyType $property
     */
    public function __construct($property)
    {
      $this->property = $property;
    }

    /**
     * @return PropertyType
     */
    public function getProperty()
    {
      return $this->property;
    }

    /**
     * @param PropertyType $property
     * @return PropertyList
     */
    public function setProperty($property)
    {
      $this->property = $property;
      return $this;
    }

}
