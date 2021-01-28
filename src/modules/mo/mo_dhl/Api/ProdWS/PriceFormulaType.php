<?php


namespace Mediaopt\DHL\Api\ProdWS;

class PriceFormulaType
{

    /**
     * @var string $expression
     */
    protected $expression = null;

    /**
     * @var string $agenda
     */
    protected $agenda = null;

    /**
     * @var FormulaExpressionType[] $formulaExpression
     */
    protected $formulaExpression = null;

    /**
     * @param string $expression
     */
    public function __construct($expression)
    {
      $this->expression = $expression;
    }

    /**
     * @return string
     */
    public function getExpression()
    {
      return $this->expression;
    }

    /**
     * @param string $expression
     * @return PriceFormulaType
     */
    public function setExpression($expression)
    {
      $this->expression = $expression;
      return $this;
    }

    /**
     * @return string
     */
    public function getAgenda()
    {
      return $this->agenda;
    }

    /**
     * @param string $agenda
     * @return PriceFormulaType
     */
    public function setAgenda($agenda)
    {
      $this->agenda = $agenda;
      return $this;
    }

    /**
     * @return FormulaExpressionType[]
     */
    public function getFormulaExpression()
    {
      return $this->formulaExpression;
    }

    /**
     * @param FormulaExpressionType[] $formulaExpression
     * @return PriceFormulaType
     */
    public function setFormulaExpression(array $formulaExpression = null)
    {
      $this->formulaExpression = $formulaExpression;
      return $this;
    }

}
