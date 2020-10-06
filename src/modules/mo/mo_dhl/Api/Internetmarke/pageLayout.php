<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class pageLayout
{

    /**
     * @var Dimension $size
     */
    protected $size = null;

    /**
     * @var Orientation $orientation
     */
    protected $orientation = null;

    /**
     * @var Dimension $labelSpacing
     */
    protected $labelSpacing = null;

    /**
     * @var Position $labelCount
     */
    protected $labelCount = null;

    /**
     * @var BorderDimension $margin
     */
    protected $margin = null;

    /**
     * @param Dimension $size
     * @param Orientation $orientation
     * @param Dimension $labelSpacing
     * @param Position $labelCount
     * @param BorderDimension $margin
     */
    public function __construct($size, $orientation, $labelSpacing, $labelCount, $margin)
    {
      $this->size = $size;
      $this->orientation = $orientation;
      $this->labelSpacing = $labelSpacing;
      $this->labelCount = $labelCount;
      $this->margin = $margin;
    }

    /**
     * @return Dimension
     */
    public function getSize()
    {
      return $this->size;
    }

    /**
     * @param Dimension $size
     * @return pageLayout
     */
    public function setSize($size)
    {
      $this->size = $size;
      return $this;
    }

    /**
     * @return Orientation
     */
    public function getOrientation()
    {
      return $this->orientation;
    }

    /**
     * @param Orientation $orientation
     * @return pageLayout
     */
    public function setOrientation($orientation)
    {
      $this->orientation = $orientation;
      return $this;
    }

    /**
     * @return Dimension
     */
    public function getLabelSpacing()
    {
      return $this->labelSpacing;
    }

    /**
     * @param Dimension $labelSpacing
     * @return pageLayout
     */
    public function setLabelSpacing($labelSpacing)
    {
      $this->labelSpacing = $labelSpacing;
      return $this;
    }

    /**
     * @return Position
     */
    public function getLabelCount()
    {
      return $this->labelCount;
    }

    /**
     * @param Position $labelCount
     * @return pageLayout
     */
    public function setLabelCount($labelCount)
    {
      $this->labelCount = $labelCount;
      return $this;
    }

    /**
     * @return BorderDimension
     */
    public function getMargin()
    {
      return $this->margin;
    }

    /**
     * @param BorderDimension $margin
     * @return pageLayout
     */
    public function setMargin($margin)
    {
      $this->margin = $margin;
      return $this;
    }

}
