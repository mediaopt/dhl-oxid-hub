<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ProductName
{

    /**
     * @var AlphanumericOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @param AlphanumericOperatorType $operator
     * @param string                   $name
     */
    public function __construct($operator, $name)
    {
      $this->operator = $operator;
      $this->name = $name;
    }

    /**
     * @return AlphanumericOperatorType
     */
    public function getOperator()
    {
      return $this->operator;
    }

    /**
     * @param AlphanumericOperatorType $operator
     * @return ProductName
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
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
     * @return ProductName
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

}
