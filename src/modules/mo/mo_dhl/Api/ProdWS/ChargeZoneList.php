<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ChargeZoneList
{

    /**
     * @var LogicalOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var string $chargeZone_shortName
     */
    protected $chargeZone_shortName = null;

    /**
     * @param LogicalOperatorType $operator
     * @param string              $chargeZone_shortName
     */
    public function __construct($operator, $chargeZone_shortName)
    {
      $this->operator = $operator;
      $this->chargeZone_shortName = $chargeZone_shortName;
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
     * @return ChargeZoneList
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
    }

    /**
     * @return string
     */
    public function getChargeZone_shortName()
    {
      return $this->chargeZone_shortName;
    }

    /**
     * @param string $chargeZone_shortName
     * @return ChargeZoneList
     */
    public function setChargeZone_shortName($chargeZone_shortName)
    {
      $this->chargeZone_shortName = $chargeZone_shortName;
      return $this;
    }

}
