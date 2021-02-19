<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CatalogValueType
{

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var string $value
     */
    protected $value = null;

    /**
     * @var PropertyList $propertyList
     */
    protected $propertyList = null;

    /**
     * @var ValidityType $validity
     */
    protected $validity = null;

    /**
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value)
    {
      $this->name = $name;
      $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
      return $this->name;
    }

    /**
     * @param string $name
     * @return CatalogValueType
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
      return $this->value;
    }

    /**
     * @param string $value
     * @return CatalogValueType
     */
    public function setValue($value)
    {
      $this->value = $value;
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
     * @return CatalogValueType
     */
    public function setPropertyList($propertyList)
    {
      $this->propertyList = $propertyList;
      return $this;
    }

    /**
     * @return ValidityType
     */
    public function getValidity()
    {
      return $this->validity;
    }

    /**
     * @param ValidityType $validity
     * @return CatalogValueType
     */
    public function setValidity($validity)
    {
      $this->validity = $validity;
      return $this;
    }

}
