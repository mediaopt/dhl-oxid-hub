<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ProductStampType
{

    /**
     * @var LogicalOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var string $stampType_name
     */
    protected $stampType_name = null;

    /**
     * @param LogicalOperatorType $operator
     * @param string              $stampType_name
     */
    public function __construct($operator, $stampType_name)
    {
      $this->operator = $operator;
      $this->stampType_name = $stampType_name;
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
     * @return ProductStampType
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
    }

    /**
     * @return string
     */
    public function getStampType_name()
    {
      return $this->stampType_name;
    }

    /**
     * @param string $stampType_name
     * @return ProductStampType
     */
    public function setStampType_name($stampType_name)
    {
      $this->stampType_name = $stampType_name;
      return $this;
    }

}
