<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ProductUsage
{

    /**
     * @var LogicalOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var string $usage_name
     */
    protected $usage_name = null;

    /**
     * @param LogicalOperatorType $operator
     * @param string              $usage_name
     */
    public function __construct($operator, $usage_name)
    {
      $this->operator = $operator;
      $this->usage_name = $usage_name;
    }

    /**
     * @return LogicalOperatorType
     */
    public function getOperator()
    {
      return $this->operator;
    }

    /**
     * @param LogicalOperatorType $operator
     * @return ProductUsage
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
    }

    /**
     * @return string
     */
    public function getUsage_name()
    {
      return $this->usage_name;
    }

    /**
     * @param string $usage_name
     * @return ProductUsage
     */
    public function setUsage_name($usage_name)
    {
      $this->usage_name = $usage_name;
      return $this;
    }

}
