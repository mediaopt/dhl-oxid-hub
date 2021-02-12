<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GroupedPropertyType
{

    /**
     * @var PropertyList $propertyList
     */
    protected $propertyList = null;

    /**
     * @var UnitPriceType $price
     */
    protected $price = null;

    /**
     * @var DocumentReferenceList $documentReferenceList
     */
    protected $documentReferenceList = null;

    /**
     * @var FormatedTextList $formatedTextList
     */
    protected $formatedTextList = null;

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
     * @param string $name
     * @param string $shortName
     * @param string $description
     * @param string $annotation
     */
    public function __construct($name, $shortName, $description, $annotation)
    {
      $this->name = $name;
      $this->shortName = $shortName;
      $this->description = $description;
      $this->annotation = $annotation;
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
     * @return GroupedPropertyType
     */
    public function setPropertyList($propertyList)
    {
      $this->propertyList = $propertyList;
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
     * @return GroupedPropertyType
     */
    public function setPrice($price)
    {
      $this->price = $price;
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
     * @return GroupedPropertyType
     */
    public function setDocumentReferenceList($documentReferenceList)
    {
      $this->documentReferenceList = $documentReferenceList;
      return $this;
    }

    /**
     * @return FormatedTextList
     */
    public function getFormatedTextList()
    {
      return $this->formatedTextList;
    }

    /**
     * @param FormatedTextList $formatedTextList
     * @return GroupedPropertyType
     */
    public function setFormatedTextList($formatedTextList)
    {
      $this->formatedTextList = $formatedTextList;
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
     * @return GroupedPropertyType
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
     * @return GroupedPropertyType
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
     * @return GroupedPropertyType
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
     * @return GroupedPropertyType
     */
    public function setAnnotation($annotation)
    {
      $this->annotation = $annotation;
      return $this;
    }

}
