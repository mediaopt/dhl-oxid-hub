<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetChangedProductVersionsListResponseType
{

    /**
     * @var SalesProductList $salesProductList
     */
    protected $salesProductList = null;

    /**
     * @var BasicProductList $basicProductList
     */
    protected $basicProductList = null;

    /**
     * @var AdditionalProductList $additionalProductList
     */
    protected $additionalProductList = null;

    /**
     * @var SpecialServiceList $specialServiceList
     */
    protected $specialServiceList = null;

    /**
     * @var string $message
     */
    protected $message = null;


    public function __construct()
    {

    }

    /**
     * @return SalesProductList
     */
    public function getSalesProductList()
    {
      return $this->salesProductList;
    }

    /**
     * @param SalesProductList $salesProductList
     * @return GetChangedProductVersionsListResponseType
     */
    public function setSalesProductList($salesProductList)
    {
      $this->salesProductList = $salesProductList;
      return $this;
    }

    /**
     * @return BasicProductList
     */
    public function getBasicProductList()
    {
      return $this->basicProductList;
    }

    /**
     * @param BasicProductList $basicProductList
     * @return GetChangedProductVersionsListResponseType
     */
    public function setBasicProductList($basicProductList)
    {
      $this->basicProductList = $basicProductList;
      return $this;
    }

    /**
     * @return AdditionalProductList
     */
    public function getAdditionalProductList()
    {
      return $this->additionalProductList;
    }

    /**
     * @param AdditionalProductList $additionalProductList
     * @return GetChangedProductVersionsListResponseType
     */
    public function setAdditionalProductList($additionalProductList)
    {
      $this->additionalProductList = $additionalProductList;
      return $this;
    }

    /**
     * @return SpecialServiceList
     */
    public function getSpecialServiceList()
    {
      return $this->specialServiceList;
    }

    /**
     * @param SpecialServiceList $specialServiceList
     * @return GetChangedProductVersionsListResponseType
     */
    public function setSpecialServiceList($specialServiceList)
    {
      $this->specialServiceList = $specialServiceList;
      return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
      return $this->message;
    }

    /**
     * @param string $message
     * @return GetChangedProductVersionsListResponseType
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

}
