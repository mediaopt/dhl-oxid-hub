<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CountryGroupList
{

    /**
     * @var LogicalOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var string $countryGroup_shortName
     */
    protected $countryGroup_shortName = null;

    /**
     * @param LogicalOperatorType $operator
     * @param string              $countryGroup_shortName
     */
    public function __construct($operator, $countryGroup_shortName)
    {
      $this->operator = $operator;
      $this->countryGroup_shortName = $countryGroup_shortName;
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
     * @return CountryGroupList
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
    }

    /**
     * @return string
     */
    public function getCountryGroup_shortName()
    {
      return $this->countryGroup_shortName;
    }

    /**
     * @param string $countryGroup_shortName
     * @return CountryGroupList
     */
    public function setCountryGroup_shortName($countryGroup_shortName)
    {
      $this->countryGroup_shortName = $countryGroup_shortName;
      return $this;
    }

}
