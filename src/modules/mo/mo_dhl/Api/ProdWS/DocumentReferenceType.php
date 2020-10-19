<?php


namespace Mediaopt\DHL\Api\ProdWS;

class DocumentReferenceType
{

    /**
     * @var string $type
     */
    protected $type = null;

    /**
     * @var string $title
     */
    protected $title = null;

    /**
     * @var string $reference
     */
    protected $reference = null;

    /**
     * @var string $description
     */
    protected $description = null;

    /**
     * @var string $format
     */
    protected $format = null;

    /**
     * @var string $materialNumber
     */
    protected $materialNumber = null;

    /**
     * @var string $publishing
     */
    protected $publishing = null;

    /**
     * @param string $type
     * @param string $title
     */
    public function __construct($type, $title)
    {
      $this->type = $type;
      $this->title = $title;
    }

    /**
     * @return string
     */
    public function getType()
    {
      return $this->type;
    }

    /**
     * @param string $type
     * @return DocumentReferenceType
     */
    public function setType($type)
    {
      $this->type = $type;
      return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
      return $this->title;
    }

    /**
     * @param string $title
     * @return DocumentReferenceType
     */
    public function setTitle($title)
    {
      $this->title = $title;
      return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
      return $this->reference;
    }

    /**
     * @param string $reference
     * @return DocumentReferenceType
     */
    public function setReference($reference)
    {
      $this->reference = $reference;
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
     * @return DocumentReferenceType
     */
    public function setDescription($description)
    {
      $this->description = $description;
      return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
      return $this->format;
    }

    /**
     * @param string $format
     * @return DocumentReferenceType
     */
    public function setFormat($format)
    {
      $this->format = $format;
      return $this;
    }

    /**
     * @return string
     */
    public function getMaterialNumber()
    {
      return $this->materialNumber;
    }

    /**
     * @param string $materialNumber
     * @return DocumentReferenceType
     */
    public function setMaterialNumber($materialNumber)
    {
      $this->materialNumber = $materialNumber;
      return $this;
    }

    /**
     * @return string
     */
    public function getPublishing()
    {
      return $this->publishing;
    }

    /**
     * @param string $publishing
     * @return DocumentReferenceType
     */
    public function setPublishing($publishing)
    {
      $this->publishing = $publishing;
      return $this;
    }

}
