<?php


namespace Mediaopt\DHL\Api\ProdWS;

class PropertyType
{

    /**
     * @var PropertyValueType $propertyValue
     */
    protected $propertyValue = null;

    /**
     * @var UnitPriceType $price
     */
    protected $price = null;

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var string $shortName
     */
    protected $shortName = null;

    /**
     * @var string $description
     */
    protected $description = null;

    /**
     * @var string $annotation
     */
    protected $annotation = null;

    /**
     * @param PropertyValueType $propertyValue
     * @param string            $name
     * @param string            $shortName
     * @param string            $description
     * @param string            $annotation
     */
    public function __construct($propertyValue, $name, $shortName, $description, $annotation)
    {
      $this->propertyValue = $propertyValue;
      $this->name = $name;
      $this->shortName = $shortName;
      $this->description = $description;
      $this->annotation = $annotation;
    }

    /**
     * @return PropertyValueType
     */
    public function getPropertyValue()
    {
      return $this->propertyValue;
    }

    /**
     * @param PropertyValueType $propertyValue
     * @return PropertyType
     */
    public function setPropertyValue($propertyValue)
    {
      $this->propertyValue = $propertyValue;
      return $this;
    }

    /**
     * @return UnitPriceType
     */
    public function getPrice()
    {
      return $this->price;
    }

    /**
     * @param UnitPriceType $price
     * @return PropertyType
     */
    public function setPrice($price)
    {
      $this->price = $price;
      return $this;
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
     * @return PropertyType
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return string
     */
    public function getShortName()
    {
      return $this->shortName;
    }

    /**
     * @param string $shortName
     * @return PropertyType
     */
    public function setShortName($shortName)
    {
      $this->shortName = $shortName;
      return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
      return $this->description;
    }

    /**
     * @param string $description
     * @return PropertyType
     */
    public function setDescription($description)
    {
      $this->description = $description;
      return $this;
    }

    /**
     * @return string
     */
    public function getAnnotation()
    {
      return $this->annotation;
    }

    /**
     * @param string $annotation
     * @return PropertyType
     */
    public function setAnnotation($annotation)
    {
      $this->annotation = $annotation;
      return $this;
    }

}
