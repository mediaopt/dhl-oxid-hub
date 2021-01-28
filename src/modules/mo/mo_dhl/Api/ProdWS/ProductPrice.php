<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ProductPrice
{

    /**
     * @var NumericOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var CurrencyAmountType $price1
     */
    protected $price1 = null;

    /**
     * @var CurrencyAmountType $price2
     */
    protected $price2 = null;

    /**
     * @param NumericOperatorType $operator
     * @param CurrencyAmountType  $price1
     * @param CurrencyAmountType  $price2
     */
    public function __construct($operator, $price1, $price2)
    {
      $this->operator = $operator;
      $this->price1 = $price1;
      $this->price2 = $price2;
    }

    /**
     * @return NumericOperatorType
     */
    public function getOperator()
    {
      return $this->operator;
    }

    /**
     * @param NumericOperatorType $operator
     * @return ProductPrice
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getPrice1()
    {
      return $this->price1;
    }

    /**
     * @param CurrencyAmountType $price1
     * @return ProductPrice
     */
    public function setPrice1($price1)
    {
      $this->price1 = $price1;
      return $this;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getPrice2()
    {
      return $this->price2;
    }

    /**
     * @param CurrencyAmountType $price2
     * @return ProductPrice
     */
    public function setPrice2($price2)
    {
      $this->price2 = $price2;
      return $this;
    }

}
