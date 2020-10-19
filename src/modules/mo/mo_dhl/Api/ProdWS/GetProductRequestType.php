<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetProductRequestType
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
     * @var string $ProdWSID
     */
    protected $ProdWSID = null;

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
     * @param string $ProdWSID
     * @param boolean $dedicatedProducts
     * @param int $responseMode
     */
    public function __construct($ProdWSID, $dedicatedProducts, $responseMode)
    {
      $this->ProdWSID = $ProdWSID;
      $this->dedicatedProducts = $dedicatedProducts;
      $this->responseMode = $responseMode;
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
     * @return GetProductRequestType
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
     * @return GetProductRequestType
     */
    public function setSubMandantID($subMandantID)
    {
      $this->subMandantID = $subMandantID;
      return $this;
    }

    /**
     * @return string
     */
    public function getProdWSID()
    {
      return $this->ProdWSID;
    }

    /**
     * @param string $ProdWSID
     * @return GetProductRequestType
     */
    public function setProdWSID($ProdWSID)
    {
      $this->ProdWSID = $ProdWSID;
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
     * @return GetProductRequestType
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
     * @return GetProductRequestType
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
     * @return GetProductRequestType
     */
    public function setResponseMode($responseMode)
    {
      $this->responseMode = $responseMode;
      return $this;
    }

}
