<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ExtendedIdentifierType
{

    /**
     * @var ExternIdentifierType[] $externIdentifier
     */
    protected $externIdentifier = null;

    /**
     * @var string $ProdWSID
     */
    protected $ProdWSID = null;

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
     * @var branchType $branche
     */
    protected $branche = null;

    /**
     * @var mixed $destination
     */
    protected $destination = null;

    /**
     * @var string $transport
     */
    protected $transport = null;

    /**
     * @var string $type
     */
    protected $type = null;

    /**
     * @var string $state
     */
    protected $state = null;

    /**
     * @var int $version
     */
    protected $version = null;

    /**
     * @var \DateTime $validFrom
     */
    protected $validFrom = null;

    /**
     * @var \DateTime $validTo
     */
    protected $validTo = null;

    /**
     * @var date $release
     */
    protected $release = null;

    /**
     * @param string $ProdWSID
     * @param string $name
     * @param string $shortName
     * @param string $description
     * @param string $annotation
     * @param branchType $branche
     * @param mixed $destination
     * @param string $transport
     * @param string $type
     * @param string $state
     * @param int $version
     * @param \DateTime $validFrom
     * @param \DateTime $validTo
     * @param date $release
     */
    public function __construct($ProdWSID, $name, $shortName, $description, $annotation, $branche, $destination, $transport, $type, $state, $version, \DateTime $validFrom, \DateTime $validTo, $release)
    {
      $this->ProdWSID = $ProdWSID;
      $this->name = $name;
      $this->shortName = $shortName;
      $this->description = $description;
      $this->annotation = $annotation;
      $this->branche = $branche;
      $this->destination = $destination;
      $this->transport = $transport;
      $this->type = $type;
      $this->state = $state;
      $this->version = $version;
      $this->validFrom = $validFrom->format(\DateTime::ATOM);
      $this->validTo = $validTo->format(\DateTime::ATOM);
      $this->release = $release;
    }

    /**
     * @return ExternIdentifierType[]
     */
    public function getExternIdentifier()
    {
      return $this->externIdentifier;
    }

    /**
     * @param ExternIdentifierType[] $externIdentifier
     * @return ExtendedIdentifierType
     */
    public function setExternIdentifier(array $externIdentifier = null)
    {
      $this->externIdentifier = $externIdentifier;
      return $this;
    }

    /**
     * @return string
     */
    public function getProdWSID()
    {
      return $this->{'ProdWS-ID'};
    }

    /**
     * @param string $ProdWSID
     * @return ExtendedIdentifierType
     */
    public function setProdWSID($ProdWSID)
    {
      $this->ProdWSID = $ProdWSID;
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
     * @return ExtendedIdentifierType
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
     * @return ExtendedIdentifierType
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
     * @return ExtendedIdentifierType
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
     * @return ExtendedIdentifierType
     */
    public function setAnnotation($annotation)
    {
      $this->annotation = $annotation;
      return $this;
    }

    /**
     * @return branchType
     */
    public function getBranche()
    {
      return $this->branche;
    }

    /**
     * @param branchType $branche
     * @return ExtendedIdentifierType
     */
    public function setBranche($branche)
    {
      $this->branche = $branche;
      return $this;
    }

    /**
     * @return mixed
     */
    public function getDestination()
    {
      return $this->destination;
    }

    /**
     * @param mixed $destination
     * @return ExtendedIdentifierType
     */
    public function setDestination($destination)
    {
      $this->destination = $destination;
      return $this;
    }

    /**
     * @return string
     */
    public function getTransport()
    {
      return $this->transport;
    }

    /**
     * @param string $transport
     * @return ExtendedIdentifierType
     */
    public function setTransport($transport)
    {
      $this->transport = $transport;
      return $this;
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
     * @return ExtendedIdentifierType
     */
    public function setType($type)
    {
      $this->type = $type;
      return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
      return $this->state;
    }

    /**
     * @param string $state
     * @return ExtendedIdentifierType
     */
    public function setState($state)
    {
      $this->state = $state;
      return $this;
    }

    /**
     * @return int
     */
    public function getVersion()
    {
      return $this->version;
    }

    /**
     * @param int $version
     * @return ExtendedIdentifierType
     */
    public function setVersion($version)
    {
      $this->version = $version;
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
     * @return ExtendedIdentifierType
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
     * @return ExtendedIdentifierType
     */
    public function setValidTo(\DateTime $validTo)
    {
      $this->validTo = $validTo->format(\DateTime::ATOM);
      return $this;
    }

    /**
     * @return date
     */
    public function getRelease()
    {
      return $this->release;
    }

    /**
     * @param date $release
     * @return ExtendedIdentifierType
     */
    public function setRelease($release)
    {
      $this->release = $release;
      return $this;
    }

}
