<?php


namespace Mediaopt\DHL\Api\ProdWS;

class DimensionList
{

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
     * @param NumericValueType $length
     * @param NumericValueType $width
     * @param NumericValueType $height
     * @param NumericValueType $diameter
     * @param NumericValueType $girth
     * @param NumericValueType $addedEdgeLength
     */
    public function __construct($length, $width, $height, $diameter, $girth, $addedEdgeLength)
    {
      $this->length = $length;
      $this->width = $width;
      $this->height = $height;
      $this->diameter = $diameter;
      $this->girth = $girth;
      $this->addedEdgeLength = $addedEdgeLength;
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
     * @return DimensionList
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
     * @return DimensionList
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
     * @return DimensionList
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
     * @return DimensionList
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
     * @return DimensionList
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
     * @return DimensionList
     */
    public function setAddedEdgeLength($addedEdgeLength)
    {
      $this->addedEdgeLength = $addedEdgeLength;
      return $this;
    }

}
