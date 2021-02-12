<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CatalogType
{

    /**
     * @var CatalogValueList $catalogValueList
     */
    protected $catalogValueList = null;

    /**
     * @var int $id
     */
    protected $id = null;

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
     * @var \DateTime $validFrom
     */
    protected $validFrom = null;

    /**
     * @var \DateTime $validTo
     */
    protected $validTo = null;

    /**
     * @param int $id
     * @param string $name
     * @param string $shortName
     * @param string $description
     * @param string $annotation
     * @param \DateTime $validFrom
     * @param \DateTime $validTo
     */
    public function __construct($id, $name, $shortName, $description, $annotation, \DateTime $validFrom, \DateTime $validTo)
    {
      $this->id = $id;
      $this->name = $name;
      $this->shortName = $shortName;
      $this->description = $description;
      $this->annotation = $annotation;
      $this->validFrom = $validFrom->format(\DateTime::ATOM);
      $this->validTo = $validTo->format(\DateTime::ATOM);
    }

    /**
     * @return CatalogValueList
     */
    public function getCatalogValueList()
    {
      return $this->catalogValueList;
    }

    /**
     * @param CatalogValueList $catalogValueList
     * @return CatalogType
     */
    public function setCatalogValueList($catalogValueList)
    {
      $this->catalogValueList = $catalogValueList;
      return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param int $id
     * @return CatalogType
     */
    public function setId($id)
    {
      $this->id = $id;
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
     * @return CatalogType
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
     * @return CatalogType
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
     * @return CatalogType
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
     * @return CatalogType
     */
    public function setAnnotation($annotation)
    {
      $this->annotation = $annotation;
      return $this;
    }

    /**
     * @return \DateTime
     */
    public function getValidFrom()
    {
      if ($this->validFrom == null) {
        return null;
      } else {
        try {
          return new \DateTime($this->validFrom);
        } catch (\Exception $e) {
          return false;
        }
      }
    }

    /**
     * @param \DateTime $validFrom
     * @return CatalogType
     */
    public function setValidFrom(\DateTime $validFrom)
    {
      $this->validFrom = $validFrom->format(\DateTime::ATOM);
      return $this;
    }

    /**
     * @return \DateTime
     */
    public function getValidTo()
    {
      if ($this->validTo == null) {
        return null;
      } else {
        try {
          return new \DateTime($this->validTo);
        } catch (\Exception $e) {
          return false;
        }
      }
    }

    /**
     * @param \DateTime $validTo
     * @return CatalogType
     */
    public function setValidTo(\DateTime $validTo)
    {
      $this->validTo = $validTo->format(\DateTime::ATOM);
      return $this;
    }

}
