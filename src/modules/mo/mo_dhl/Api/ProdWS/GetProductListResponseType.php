<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetProductListResponseType
{

    /**
     * @var date $date
     */
    protected $date = null;

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

    /**
     * @param date $date
     */
    public function __construct($date)
    {
      $this->date = $date;
    }

    /**
     * @return date
     */
    public function getDate()
    {
      return $this->date;
    }

    /**
     * @param date $date
     * @return GetProductListResponseType
     */
    public function setDate($date)
    {
      $this->date = $date;
      return $this;
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
     * @return GetProductListResponseType
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
     * @return GetProductListResponseType
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
     * @return GetProductListResponseType
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
     * @return GetProductListResponseType
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
     * @return GetProductListResponseType
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
     * @return GetProductListResponseType
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

}
