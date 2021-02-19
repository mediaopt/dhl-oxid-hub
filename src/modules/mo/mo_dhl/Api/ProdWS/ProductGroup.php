<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ProductGroup
{

    /**
     * @var LogicalOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var string $group_name
     */
    protected $group_name = null;

    /**
     * @param LogicalOperatorType $operator
     * @param string              $group_name
     */
    public function __construct($operator, $group_name)
    {
      $this->operator = $operator;
      $this->group_name = $group_name;
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
     * @return ProductGroup
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
    }

    /**
     * @return string
     */
    public function getGroup_name()
    {
      return $this->group_name;
    }

    /**
     * @param string $group_name
     * @return ProductGroup
     */
    public function setGroup_name($group_name)
    {
      $this->group_name = $group_name;
      return $this;
    }

}
