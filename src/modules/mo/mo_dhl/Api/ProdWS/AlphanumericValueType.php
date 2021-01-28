<?php


namespace Mediaopt\DHL\Api\ProdWS;

class AlphanumericValueType
{

    /**
     * @var string $firstValue
     */
    protected $firstValue = null;

    /**
     * @var string $lastValue
     */
    protected $lastValue = null;

    /**
     * @var string $fixValue
     */
    protected $fixValue = null;

    /**
     * @param string $firstValue
     * @param string $lastValue
     * @param string $fixValue
     */
    public function __construct($firstValue, $lastValue, $fixValue)
    {
      $this->firstValue = $firstValue;
      $this->lastValue = $lastValue;
      $this->fixValue = $fixValue;
    }

    /**
     * @return string
     */
    public function getFirstValue()
    {
      return $this->firstValue;
    }

    /**
     * @param string $firstValue
     * @return AlphanumericValueType
     */
    public function setFirstValue($firstValue)
    {
      $this->firstValue = $firstValue;
      return $this;
    }

    /**
     * @return string
     */
    public function getLastValue()
    {
      return $this->lastValue;
    }

    /**
     * @param string $lastValue
     * @return AlphanumericValueType
     */
    public function setLastValue($lastValue)
    {
      $this->lastValue = $lastValue;
      return $this;
    }

    /**
     * @return string
     */
    public function getFixValue()
    {
      return $this->fixValue;
    }

    /**
     * @param string $fixValue
     * @return AlphanumericValueType
     */
    public function setFixValue($fixValue)
    {
      $this->fixValue = $fixValue;
      return $this;
    }

}
