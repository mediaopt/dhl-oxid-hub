<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ProductID
{

    /**
     * @var AlphanumericOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var string $id
     */
    protected $id = null;

    /**
     * @var string $source
     */
    protected $source = null;

    /**
     * @param AlphanumericOperatorType $operator
     * @param string                   $id
     * @param string                   $source
     */
    public function __construct($operator, $id, $source)
    {
      $this->operator = $operator;
      $this->id = $id;
      $this->source = $source;
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
     * @return ProductID
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param string $id
     * @return ProductID
     */
    public function setId($id)
    {
      $this->id = $id;
      return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
      return $this->source;
    }

    /**
     * @param string $source
     * @return ProductID
     */
    public function setSource($source)
    {
      $this->source = $source;
      return $this;
    }

}
