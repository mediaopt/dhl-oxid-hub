<?php


namespace Mediaopt\DHL\Api\ProdWS;

class PriceDefinitionType
{

    /**
     * @var PriceType $price
     */
    protected $price = null;

    /**
     * @var TempPriceList $tempPriceList
     */
    protected $tempPriceList = null;

    /**
     * @var PriceType $minimalPrice
     */
    protected $minimalPrice = null;

    /**
     * @var PriceFormulaType $priceFormula
     */
    protected $priceFormula = null;

    /**
     * @param PriceType        $price
     * @param PriceFormulaType $priceFormula
     */
    public function __construct($price, $priceFormula)
    {
      $this->price = $price;
      $this->priceFormula = $priceFormula;
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
     * @return PriceDefinitionType
     */
    public function setPrice($price)
    {
      $this->price = $price;
      return $this;
    }

    /**
     * @return TempPriceList
     */
    public function getTempPriceList()
    {
      return $this->tempPriceList;
    }

    /**
     * @param TempPriceList $tempPriceList
     * @return PriceDefinitionType
     */
    public function setTempPriceList($tempPriceList)
    {
      $this->tempPriceList = $tempPriceList;
      return $this;
    }

    /**
     * @return PriceType
     */
    public function getMinimalPrice()
    {
      return $this->minimalPrice;
    }

    /**
     * @param PriceType $minimalPrice
     * @return PriceDefinitionType
     */
    public function setMinimalPrice($minimalPrice)
    {
      $this->minimalPrice = $minimalPrice;
      return $this;
    }

    /**
     * @return PriceFormulaType
     */
    public function getPriceFormula()
    {
      return $this->priceFormula;
    }

    /**
     * @param PriceFormulaType $priceFormula
     * @return PriceDefinitionType
     */
    public function setPriceFormula($priceFormula)
    {
      $this->priceFormula = $priceFormula;
      return $this;
    }

}
