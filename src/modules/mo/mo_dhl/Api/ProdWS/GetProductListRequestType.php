<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetProductListRequestType
{

    /**
     * @var string $mandantID
     */
    protected $mandantID = null;

    /**
     * @var string $subMandantID
     */
    protected $subMandantID = null;

    /**
     * @var TimestampType $timestamp
     */
    protected $timestamp = null;

    /**
     * @var boolean $dedicatedProducts
     */
    protected $dedicatedProducts = null;

    /**
     * @var int $responseMode
     */
    protected $responseMode = null;

    /**
     * @var boolean $onlyChanges
     */
    protected $onlyChanges = null;

    /**
     * @var date $referenceDate
     */
    protected $referenceDate = null;

    /**
     * @var boolean $shortList
     */
    protected $shortList = null;

    /**
     * @param boolean $dedicatedProducts
     * @param int $responseMode
     * @param boolean $onlyChanges
     * @param date $referenceDate
     * @param boolean $shortList
     */
    public function __construct($dedicatedProducts, $responseMode, $onlyChanges, $referenceDate, $shortList)
    {
      $this->dedicatedProducts = $dedicatedProducts;
      $this->responseMode = $responseMode;
      $this->onlyChanges = $onlyChanges;
      $this->referenceDate = $referenceDate;
      $this->shortList = $shortList;
    }

    /**
     * @return string
     */
    public function getMandantID()
    {
      return $this->mandantID;
    }

    /**
     * @param string $mandantID
     * @return GetProductListRequestType
     */
    public function setMandantID($mandantID)
    {
      $this->mandantID = $mandantID;
      return $this;
    }

    /**
     * @return string
     */
    public function getSubMandantID()
    {
      return $this->subMandantID;
    }

    /**
     * @param string $subMandantID
     * @return GetProductListRequestType
     */
    public function setSubMandantID($subMandantID)
    {
      $this->subMandantID = $subMandantID;
      return $this;
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
     * @return GetProductListRequestType
     */
    public function setTimestamp($timestamp)
    {
      $this->timestamp = $timestamp;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getDedicatedProducts()
    {
      return $this->dedicatedProducts;
    }

    /**
     * @param boolean $dedicatedProducts
     * @return GetProductListRequestType
     */
    public function setDedicatedProducts($dedicatedProducts)
    {
      $this->dedicatedProducts = $dedicatedProducts;
      return $this;
    }

    /**
     * @return int
     */
    public function getResponseMode()
    {
      return $this->responseMode;
    }

    /**
     * @param int $responseMode
     * @return GetProductListRequestType
     */
    public function setResponseMode($responseMode)
    {
      $this->responseMode = $responseMode;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getOnlyChanges()
    {
      return $this->onlyChanges;
    }

    /**
     * @param boolean $onlyChanges
     * @return GetProductListRequestType
     */
    public function setOnlyChanges($onlyChanges)
    {
      $this->onlyChanges = $onlyChanges;
      return $this;
    }

    /**
     * @return date
     */
    public function getReferenceDate()
    {
      return $this->referenceDate;
    }

    /**
     * @param date $referenceDate
     * @return GetProductListRequestType
     */
    public function setReferenceDate($referenceDate)
    {
      $this->referenceDate = $referenceDate;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getShortList()
    {
      return $this->shortList;
    }

    /**
     * @param boolean $shortList
     * @return GetProductListRequestType
     */
    public function setShortList($shortList)
    {
      $this->shortList = $shortList;
      return $this;
    }

}
