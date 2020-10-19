<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ProductValidity
{

    /**
     * @var TimestampType $timestamp
     */
    protected $timestamp = null;

    /**
     * @var NumericOperatorType $operator
     */
    protected $operator = null;

    /**
     * @var TimestampType $timestamp1
     */
    protected $timestamp1 = null;

    /**
     * @var TimestampType $timestamp2
     */
    protected $timestamp2 = null;

    /**
     * @param TimestampType       $timestamp
     * @param NumericOperatorType $operator
     * @param TimestampType       $timestamp1
     * @param TimestampType       $timestamp2
     */
    public function __construct($timestamp, $operator, $timestamp1, $timestamp2)
    {
      $this->timestamp = $timestamp;
      $this->operator = $operator;
      $this->timestamp1 = $timestamp1;
      $this->timestamp2 = $timestamp2;
    }

    /**
     * @return TimestampType
     */
    public function getTimestamp()
    {
      return $this->timestamp;
    }

    /**
     * @param TimestampType $timestamp
     * @return ProductValidity
     */
    public function setTimestamp($timestamp)
    {
      $this->timestamp = $timestamp;
      return $this;
    }

    /**
     * @return NumericOperatorType
     */
    public function getOperator()
    {
      return $this->operator;
    }

    /**
     * @param NumericOperatorType $operator
     * @return ProductValidity
     */
    public function setOperator($operator)
    {
      $this->operator = $operator;
      return $this;
    }

    /**
     * @return TimestampType
     */
    public function getTimestamp1()
    {
      return $this->timestamp1;
    }

    /**
     * @param TimestampType $timestamp1
     * @return ProductValidity
     */
    public function setTimestamp1($timestamp1)
    {
      $this->timestamp1 = $timestamp1;
      return $this;
    }

    /**
     * @return TimestampType
     */
    public function getTimestamp2()
    {
      return $this->timestamp2;
    }

    /**
     * @param TimestampType $timestamp2
     * @return ProductValidity
     */
    public function setTimestamp2($timestamp2)
    {
      $this->timestamp2 = $timestamp2;
      return $this;
    }

}
