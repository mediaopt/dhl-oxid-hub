<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetProductVersionsRequestType
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
     * @param string $ProdWSID
     * @param boolean $dedicatedProducts
     * @param int $responseMode
     * @param boolean $onlyChanges
     * @param date $referenceDate
     * @param boolean $shortList
     */
    public function __construct($ProdWSID, $dedicatedProducts, $responseMode, $onlyChanges, $referenceDate, $shortList)
    {
      $this->ProdWSID = $ProdWSID;
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
     * @return GetProductVersionsRequestType
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
     * @return GetProductVersionsRequestType
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
     * @return GetProductVersionsRequestType
     */
    public function setProdWSID($ProdWSID)
    {
      $this->ProdWSID = $ProdWSID;
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
     * @return GetProductVersionsRequestType
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
     * @return GetProductVersionsRequestType
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
     * @return GetProductVersionsRequestType
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
     * @return GetProductVersionsRequestType
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
     * @return GetProductVersionsRequestType
     */
    public function setShortList($shortList)
    {
      $this->shortList = $shortList;
      return $this;
    }

}
