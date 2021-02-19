<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ExternIdentifierType
{

    /**
     * @var string $source
     */
    protected $source = null;

    /**
     * @var string $id
     */
    protected $id = null;

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var string $description
     */
    protected $description = null;

    /**
     * @var string $annotation
     */
    protected $annotation = null;

    /**
     * @var int $firstPPLVersion
     */
    protected $firstPPLVersion = null;

    /**
     * @var int $lastPPLVersion
     */
    protected $lastPPLVersion = null;

    /**
     * @var int $actualPPLVersion
     */
    protected $actualPPLVersion = null;

    /**
     * @var mixed $sapProductType
     */
    protected $sapProductType = null;

    /**
     * @param string $source
     * @param string $id
     * @param string $name
     * @param string $description
     * @param string $annotation
     * @param int $firstPPLVersion
     * @param int $lastPPLVersion
     * @param int $actualPPLVersion
     * @param mixed $sapProductType
     */
    public function __construct($source, $id, $name, $description, $annotation, $firstPPLVersion, $lastPPLVersion, $actualPPLVersion, $sapProductType)
    {
      $this->source = $source;
      $this->id = $id;
      $this->name = $name;
      $this->description = $description;
      $this->annotation = $annotation;
      $this->firstPPLVersion = $firstPPLVersion;
      $this->lastPPLVersion = $lastPPLVersion;
      $this->actualPPLVersion = $actualPPLVersion;
      $this->sapProductType = $sapProductType;
    }

    /**
     * @return string
     */
    public function getSource()
    {
      return $this->source;
    }

    /**
     * @param string $source
     * @return ExternIdentifierType
     */
    public function setSource($source)
    {
      $this->source = $source;
      return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param string $id
     * @return ExternIdentifierType
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
     * @return ExternIdentifierType
     */
    public function setName($name)
    {
      $this->name = $name;
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
     * @return ExternIdentifierType
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
     * @return ExternIdentifierType
     */
    public function setAnnotation($annotation)
    {
      $this->annotation = $annotation;
      return $this;
    }

    /**
     * @return int
     */
    public function getFirstPPLVersion()
    {
      return $this->firstPPLVersion;
    }

    /**
     * @param int $firstPPLVersion
     * @return ExternIdentifierType
     */
    public function setFirstPPLVersion($firstPPLVersion)
    {
      $this->firstPPLVersion = $firstPPLVersion;
      return $this;
    }

    /**
     * @return int
     */
    public function getLastPPLVersion()
    {
      return $this->lastPPLVersion;
    }

    /**
     * @param int $lastPPLVersion
     * @return ExternIdentifierType
     */
    public function setLastPPLVersion($lastPPLVersion)
    {
      $this->lastPPLVersion = $lastPPLVersion;
      return $this;
    }

    /**
     * @return int
     */
    public function getActualPPLVersion()
    {
      return $this->actualPPLVersion;
    }

    /**
     * @param int $actualPPLVersion
     * @return ExternIdentifierType
     */
    public function setActualPPLVersion($actualPPLVersion)
    {
      $this->actualPPLVersion = $actualPPLVersion;
      return $this;
    }

    /**
     * @return mixed
     */
    public function getSapProductType()
    {
      return $this->sapProductType;
    }

    /**
     * @param mixed $sapProductType
     * @return ExternIdentifierType
     */
    public function setSapProductType($sapProductType)
    {
      $this->sapProductType = $sapProductType;
      return $this;
    }

}
