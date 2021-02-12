<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ShortProductIdentifierType
{

    /**
     * @var string $ProdWSID
     */
    protected $ProdWSID = null;

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var \DateTime $validFrom
     */
    protected $validFrom = null;

    /**
     * @var \DateTime $validTo
     */
    protected $validTo = null;

    /**
     * @var int $version
     */
    protected $version = null;

    /**
     * @param string $ProdWSID
     * @param string $name
     * @param \DateTime $validFrom
     * @param \DateTime $validTo
     * @param int $version
     */
    public function __construct($ProdWSID, $name, \DateTime $validFrom, \DateTime $validTo, $version)
    {
      $this->ProdWSID = $ProdWSID;
      $this->name = $name;
      $this->validFrom = $validFrom->format(\DateTime::ATOM);
      $this->validTo = $validTo->format(\DateTime::ATOM);
      $this->version = $version;
    }

    /**
     * @return string
     */
    public function getProdWSID()
    {
      return $this->ProdWSID;
    }

    /**
     * @param string $ProdWSID
     * @return ShortProductIdentifierType
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
     * @return ShortProductIdentifierType
     */
    public function setName($name)
    {
      $this->name = $name;
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
     * @return ShortProductIdentifierType
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
     * @return ShortProductIdentifierType
     */
    public function setValidTo(\DateTime $validTo)
    {
      $this->validTo = $validTo->format(\DateTime::ATOM);
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
     * @return ShortProductIdentifierType
     */
    public function setVersion($version)
    {
      $this->version = $version;
      return $this;
    }

}
