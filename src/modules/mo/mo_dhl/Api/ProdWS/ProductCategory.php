<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ProductCategory
{

    /**
     * @var LogicalOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var string $category_name
     */
    protected $category_name = null;

    /**
     * @param LogicalOperatorType $operator
     * @param string              $category_name
     */
    public function __construct($operator, $category_name)
    {
      $this->operator = $operator;
      $this->category_name = $category_name;
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
     * @return ProductCategory
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
    }

    /**
     * @return string
     */
    public function getCategory_name()
    {
      return $this->category_name;
    }

    /**
     * @param string $category_name
     * @return ProductCategory
     */
    public function setCategory_name($category_name)
    {
      $this->category_name = $category_name;
      return $this;
    }

}
