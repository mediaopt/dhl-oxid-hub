<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CountryList
{

    /**
     * @var LogicalOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var string $country_ISOCode
     */
    protected $country_ISOCode = null;

    /**
     * @param LogicalOperatorType $operator
     * @param string              $country_ISOCode
     */
    public function __construct($operator, $country_ISOCode)
    {
      $this->operator = $operator;
      $this->country_ISOCode = $country_ISOCode;
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
     * @return CountryList
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
    }

    /**
     * @return string
     */
    public function getCountry_ISOCode()
    {
      return $this->country_ISOCode;
    }

    /**
     * @param string $country_ISOCode
     * @return CountryList
     */
    public function setCountry_ISOCode($country_ISOCode)
    {
      $this->country_ISOCode = $country_ISOCode;
      return $this;
    }

}
