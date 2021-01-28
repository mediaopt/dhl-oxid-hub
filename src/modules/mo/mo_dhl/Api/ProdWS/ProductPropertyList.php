<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ProductPropertyList
{

    /**
     * @var Property $property
     */
    protected $property = null;

    /**
     * @param Property $property
     */
    public function __construct($property)
    {
      $this->property = $property;
    }

    /**
     * @return Property
     */
    public function getProperty()
    {
      return $this->property;
    }

    /**
     * @param Property $property
     * @return ProductPropertyList
     */
    public function setProperty($property)
    {
      $this->property = $property;
      return $this;
    }

}
