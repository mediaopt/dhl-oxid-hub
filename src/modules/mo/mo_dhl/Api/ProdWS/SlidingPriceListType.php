<?php


namespace Mediaopt\DHL\Api\ProdWS;

class SlidingPriceListType
{

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
     * @var SlidingPriceType[] $slidingPrice
     */
    protected $slidingPrice = null;

    /**
     * @param SlidingPriceType[] $slidingPrice
     */
    public function __construct(array $slidingPrice)
    {
      $this->slidingPrice = $slidingPrice;
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
     * @return SlidingPriceListType
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
     * @return SlidingPriceListType
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
     * @return SlidingPriceListType
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
     * @return SlidingPriceListType
     */
    public function setAnnotation($annotation)
    {
      $this->annotation = $annotation;
      return $this;
    }

    /**
     * @return SlidingPriceType[]
     */
    public function getSlidingPrice()
    {
      return $this->slidingPrice;
    }

    /**
     * @param SlidingPriceType[] $slidingPrice
     * @return SlidingPriceListType
     */
    public function setSlidingPrice(array $slidingPrice)
    {
      $this->slidingPrice = $slidingPrice;
      return $this;
    }

}
