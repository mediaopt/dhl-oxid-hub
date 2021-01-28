<?php


namespace Mediaopt\DHL\Api\ProdWS;

class Dimension
{

    /**
     * @var NumericOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var DimensionType $dimension1
     */
    protected $dimension1 = null;

    /**
     * @var DimensionType $dimension2
     */
    protected $dimension2 = null;

    /**
     * @param NumericOperatorType $operator
     * @param DimensionType       $dimension1
     * @param DimensionType       $dimension2
     */
    public function __construct($operator, $dimension1, $dimension2)
    {
      $this->operator = $operator;
      $this->dimension1 = $dimension1;
      $this->dimension2 = $dimension2;
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
     * @return Dimension
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
    }

    /**
     * @return DimensionType
     */
    public function getDimension1()
    {
      return $this->dimension1;
    }

    /**
     * @param DimensionType $dimension1
     * @return Dimension
     */
    public function setDimension1($dimension1)
    {
      $this->dimension1 = $dimension1;
      return $this;
    }

    /**
     * @return DimensionType
     */
    public function getDimension2()
    {
      return $this->dimension2;
    }

    /**
     * @param DimensionType $dimension2
     * @return Dimension
     */
    public function setDimension2($dimension2)
    {
      $this->dimension2 = $dimension2;
      return $this;
    }

}
