<?php


namespace Mediaopt\DHL\Api\ProdWS;

class FormulaExpressionType
{

    /**
     * @var base64Binary $condition
     */
    protected $condition = null;

    /**
     * @var base64Binary $formula
     */
    protected $formula = null;

    /**
     * @var FormulaComponentType[] $formulaComponent
     */
    protected $formulaComponent = null;

    /**
     * @param base64Binary $formula
     */
    public function __construct($formula)
    {
      $this->formula = $formula;
    }

    /**
     * @return base64Binary
     */
    public function getCondition()
    {
      return $this->condition;
    }

    /**
     * @param base64Binary $condition
     * @return FormulaExpressionType
     */
    public function setCondition($condition)
    {
      $this->condition = $condition;
      return $this;
    }

    /**
     * @return base64Binary
     */
    public function getFormula()
    {
      return $this->formula;
    }

    /**
     * @param base64Binary $formula
     * @return FormulaExpressionType
     */
    public function setFormula($formula)
    {
      $this->formula = $formula;
      return $this;
    }

    /**
     * @return FormulaComponentType[]
     */
    public function getFormulaComponent()
    {
      return $this->formulaComponent;
    }

    /**
     * @param FormulaComponentType[] $formulaComponent
     * @return FormulaExpressionType
     */
    public function setFormulaComponent(array $formulaComponent = null)
    {
      $this->formulaComponent = $formulaComponent;
      return $this;
    }

}
