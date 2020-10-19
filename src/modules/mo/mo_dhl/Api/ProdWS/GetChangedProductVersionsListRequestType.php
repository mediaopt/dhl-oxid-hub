<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetChangedProductVersionsListRequestType
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
     * @var boolean $dedicatedProducts
     */
    protected $dedicatedProducts = null;

    /**
     * @var int $responseMode
     */
    protected $responseMode = null;

    /**
     * @param boolean $dedicatedProducts
     * @param int $responseMode
     */
    public function __construct($dedicatedProducts, $responseMode)
    {
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
     * @return GetChangedProductVersionsListRequestType
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
     * @return GetChangedProductVersionsListRequestType
     */
    public function setSubMandantID($subMandantID)
    {
      $this->subMandantID = $subMandantID;
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
     * @return GetChangedProductVersionsListRequestType
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
     * @return GetChangedProductVersionsListRequestType
     */
    public function setResponseMode($responseMode)
    {
      $this->responseMode = $responseMode;
      return $this;
    }

}
