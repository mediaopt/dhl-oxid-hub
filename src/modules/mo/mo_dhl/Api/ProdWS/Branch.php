<?php


namespace Mediaopt\DHL\Api\ProdWS;

class Branch
{

    /**
     * @var LogicalOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var branchType $branch_number
     */
    protected $branch_number = null;

    /**
     * @param LogicalOperatorType $operator
     * @param branchType          $branch_number
     */
    public function __construct($operator, $branch_number)
    {
      $this->operator = $operator;
      $this->branch_number = $branch_number;
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
     * @return Branch
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
    }

    /**
     * @return branchType
     */
    public function getBranch_number()
    {
      return $this->branch_number;
    }

    /**
     * @param branchType $branch_number
     * @return Branch
     */
    public function setBranch_number($branch_number)
    {
      $this->branch_number = $branch_number;
      return $this;
    }

}
