<?php


namespace Mediaopt\DHL\Api\ProdWS;

class TempPriceList
{

    /**
     * @var TempPriceType $tempPrice
     */
    protected $tempPrice = null;

    /**
     * @param TempPriceType $tempPrice
     */
    public function __construct($tempPrice)
    {
      $this->tempPrice = $tempPrice;
    }

    /**
     * @return TempPriceType
     */
    public function getTempPrice()
    {
      return $this->tempPrice;
    }

    /**
     * @param TempPriceType $tempPrice
     * @return TempPriceList
     */
    public function setTempPrice($tempPrice)
    {
      $this->tempPrice = $tempPrice;
      return $this;
    }

}
