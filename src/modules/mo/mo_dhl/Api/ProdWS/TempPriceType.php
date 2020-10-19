<?php


namespace Mediaopt\DHL\Api\ProdWS;

class TempPriceType
{

    /**
     * @var PriceType $price
     */
    protected $price = null;

    /**
     * @var TimestampType $validFrom
     */
    protected $validFrom = null;

    /**
     * @var TimestampType $validTo
     */
    protected $validTo = null;

    /**
     * @param PriceType     $price
     * @param TimestampType $validFrom
     * @param TimestampType $validTo
     */
    public function __construct($price, $validFrom, $validTo)
    {
      $this->price = $price;
      $this->validFrom = $validFrom;
      $this->validTo = $validTo;
    }

    /**
     * @return PriceType
     */
    public function getPrice()
    {
      return $this->price;
    }

    /**
     * @param PriceType $price
     * @return TempPriceType
     */
    public function setPrice($price)
    {
      $this->price = $price;
      return $this;
    }

    /**
     * @return TimestampType
     */
    public function getValidFrom()
    {
      return $this->validFrom;
    }

    /**
     * @param TimestampType $validFrom
     * @return TempPriceType
     */
    public function setValidFrom($validFrom)
    {
      $this->validFrom = $validFrom;
      return $this;
    }

    /**
     * @return TimestampType
     */
    public function getValidTo()
    {
      return $this->validTo;
    }

    /**
     * @param TimestampType $validTo
     * @return TempPriceType
     */
    public function setValidTo($validTo)
    {
      $this->validTo = $validTo;
      return $this;
    }

}
