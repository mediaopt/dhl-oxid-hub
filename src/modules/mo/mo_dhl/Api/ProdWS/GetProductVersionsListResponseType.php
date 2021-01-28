<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetProductVersionsListResponseType
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
     * @var ShortSalesProductList $shortSalesProductList
     */
    protected $shortSalesProductList = null;

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
     * @return GetProductVersionsListResponseType
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
     * @return GetProductVersionsListResponseType
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
     * @return GetProductVersionsListResponseType
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
     * @return GetProductVersionsListResponseType
     */
    public function setSpecialServiceList($specialServiceList)
    {
      $this->specialServiceList = $specialServiceList;
      return $this;
    }

    /**
     * @return ShortSalesProductList
     */
    public function getShortSalesProductList()
    {
      return $this->shortSalesProductList;
    }

    /**
     * @param ShortSalesProductList $shortSalesProductList
     * @return GetProductVersionsListResponseType
     */
    public function setShortSalesProductList($shortSalesProductList)
    {
      $this->shortSalesProductList = $shortSalesProductList;
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
     * @return GetProductVersionsListResponseType
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

}
