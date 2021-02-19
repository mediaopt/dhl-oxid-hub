<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ShortSalesProductType
{

    /**
     * @var string $ProdWSID
     */
    protected $ProdWSID = null;

    /**
     * @var ExternIdentifierType $externIdentifier
     */
    protected $externIdentifier = null;

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var destination $destination
     */
    protected $destination = null;

    /**
     * @var \DateTime $validFrom
     */
    protected $validFrom = null;

    /**
     * @var \DateTime $validTo
     */
    protected $validTo = null;

    /**
     * @var PriceDefinition $priceDefinition
     */
    protected $priceDefinition = null;

    /**
     * @var NumericValueType $length
     */
    protected $length = null;

    /**
     * @var NumericValueType $width
     */
    protected $width = null;

    /**
     * @var NumericValueType $height
     */
    protected $height = null;

    /**
     * @var NumericValueType $diameter
     */
    protected $diameter = null;

    /**
     * @var NumericValueType $girth
     */
    protected $girth = null;

    /**
     * @var NumericValueType $addedEdgeLength
     */
    protected $addedEdgeLength = null;

    /**
     * @var NumericValueType $weight
     */
    protected $weight = null;

    /**
     * @param string               $ProdWSID
     * @param ExternIdentifierType $externIdentifier
     * @param string               $name
     * @param destination          $destination
     * @param \DateTime            $validFrom
     * @param PriceDefinition      $priceDefinition
     */
    public function __construct($ProdWSID, $externIdentifier, $name, $destination, \DateTime $validFrom, $priceDefinition)
    {
      $this->ProdWSID = $ProdWSID;
      $this->externIdentifier = $externIdentifier;
      $this->name = $name;
      $this->destination = $destination;
      $this->validFrom = $validFrom->format(\DateTime::ATOM);
      $this->priceDefinition = $priceDefinition;
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
     * @return ShortSalesProductType
     */
    public function setProdWSID($ProdWSID)
    {
      $this->ProdWSID = $ProdWSID;
      return $this;
    }

    /**
     * @return ExternIdentifierType
     */
    public function getExternIdentifier()
    {
      return $this->externIdentifier;
    }

    /**
     * @param ExternIdentifierType $externIdentifier
     * @return ShortSalesProductType
     */
    public function setExternIdentifier($externIdentifier)
    {
      $this->externIdentifier = $externIdentifier;
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
     * @return ShortSalesProductType
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return destination
     */
    public function getDestination()
    {
      return $this->destination;
    }

    /**
     * @param destination $destination
     * @return ShortSalesProductType
     */
    public function setDestination($destination)
    {
      $this->destination = $destination;
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
     * @return ShortSalesProductType
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
     * @return ShortSalesProductType
     */
    public function setValidTo(\DateTime $validTo = null)
    {
      if ($validTo == null) {
       $this->validTo = null;
      } else {
        $this->validTo = $validTo->format(\DateTime::ATOM);
      }
      return $this;
    }

    /**
     * @return PriceDefinition
     */
    public function getPriceDefinition()
    {
      return $this->priceDefinition;
    }

    /**
     * @param PriceDefinition $priceDefinition
     * @return ShortSalesProductType
     */
    public function setPriceDefinition($priceDefinition)
    {
      $this->priceDefinition = $priceDefinition;
      return $this;
    }

    /**
     * @return NumericValueType
     */
    public function getLength()
    {
      return $this->length;
    }

    /**
     * @param NumericValueType $length
     * @return ShortSalesProductType
     */
    public function setLength($length)
    {
      $this->length = $length;
      return $this;
    }

    /**
     * @return NumericValueType
     */
    public function getWidth()
    {
      return $this->width;
    }

    /**
     * @param NumericValueType $width
     * @return ShortSalesProductType
     */
    public function setWidth($width)
    {
      $this->width = $width;
      return $this;
    }

    /**
     * @return NumericValueType
     */
    public function getHeight()
    {
      return $this->height;
    }

    /**
     * @param NumericValueType $height
     * @return ShortSalesProductType
     */
    public function setHeight($height)
    {
      $this->height = $height;
      return $this;
    }

    /**
     * @return NumericValueType
     */
    public function getDiameter()
    {
      return $this->diameter;
    }

    /**
     * @param NumericValueType $diameter
     * @return ShortSalesProductType
     */
    public function setDiameter($diameter)
    {
      $this->diameter = $diameter;
      return $this;
    }

    /**
     * @return NumericValueType
     */
    public function getGirth()
    {
      return $this->girth;
    }

    /**
     * @param NumericValueType $girth
     * @return ShortSalesProductType
     */
    public function setGirth($girth)
    {
      $this->girth = $girth;
      return $this;
    }

    /**
     * @return NumericValueType
     */
    public function getAddedEdgeLength()
    {
      return $this->addedEdgeLength;
    }

    /**
     * @param NumericValueType $addedEdgeLength
     * @return ShortSalesProductType
     */
    public function setAddedEdgeLength($addedEdgeLength)
    {
      $this->addedEdgeLength = $addedEdgeLength;
      return $this;
    }

    /**
     * @return NumericValueType
     */
    public function getWeight()
    {
      return $this->weight;
    }

    /**
     * @param NumericValueType $weight
     * @return ShortSalesProductType
     */
    public function setWeight($weight)
    {
      $this->weight = $weight;
      return $this;
    }

}
