<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ProductWeight
{

    /**
     * @var NumericOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var WeightType $weight1
     */
    protected $weight1 = null;

    /**
     * @var WeightType $weight2
     */
    protected $weight2 = null;

    /**
     * @param NumericOperatorType $operator
     * @param WeightType          $weight1
     * @param WeightType          $weight2
     */
    public function __construct($operator, $weight1, $weight2)
    {
      $this->operator = $operator;
      $this->weight1 = $weight1;
      $this->weight2 = $weight2;
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
     * @return ProductWeight
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
    }

    /**
     * @return WeightType
     */
    public function getWeight1()
    {
      return $this->weight1;
    }

    /**
     * @param WeightType $weight1
     * @return ProductWeight
     */
    public function setWeight1($weight1)
    {
      $this->weight1 = $weight1;
      return $this;
    }

    /**
     * @return WeightType
     */
    public function getWeight2()
    {
      return $this->weight2;
    }

    /**
     * @param WeightType $weight2
     * @return ProductWeight
     */
    public function setWeight2($weight2)
    {
      $this->weight2 = $weight2;
      return $this;
    }

}
