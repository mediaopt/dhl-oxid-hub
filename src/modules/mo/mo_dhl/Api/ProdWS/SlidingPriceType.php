<?php


namespace Mediaopt\DHL\Api\ProdWS;

class SlidingPriceType
{

    /**
     * @var NumericValueType $slidingScale
     */
    protected $slidingScale = null;

    /**
     * @var UnitPriceType $price
     */
    protected $price = null;

    /**
     * @param NumericValueType $slidingScale
     * @param UnitPriceType    $price
     */
    public function __construct($slidingScale, $price)
    {
      $this->slidingScale = $slidingScale;
      $this->price = $price;
    }

    /**
     * @return NumericValueType
     */
    public function getSlidingScale()
    {
      return $this->slidingScale;
    }

    /**
     * @param NumericValueType $slidingScale
     * @return SlidingPriceType
     */
    public function setSlidingScale($slidingScale)
    {
      $this->slidingScale = $slidingScale;
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
     * @return SlidingPriceType
     */
    public function setPrice($price)
    {
      $this->price = $price;
      return $this;
    }

}
