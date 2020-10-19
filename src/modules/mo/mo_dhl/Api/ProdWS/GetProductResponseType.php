<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetProductResponseType
{

    /**
     * @var SalesProductType $SalesProduct
     */
    protected $SalesProduct = null;

    /**
     * @var BasicProductType $BasicProduct
     */
    protected $BasicProduct = null;

    /**
     * @var AdditionalProductType $AdditionalProduct
     */
    protected $AdditionalProduct = null;

    /**
     * @var SpecialServiceType $SpecialService
     */
    protected $SpecialService = null;

    /**
     * @var string $message
     */
    protected $message = null;

    /**
     * @param SalesProductType      $SalesProduct
     * @param BasicProductType      $BasicProduct
     * @param AdditionalProductType $AdditionalProduct
     * @param SpecialServiceType    $SpecialService
     */
    public function __construct($SalesProduct, $BasicProduct, $AdditionalProduct, $SpecialService)
    {
      $this->SalesProduct = $SalesProduct;
      $this->BasicProduct = $BasicProduct;
      $this->AdditionalProduct = $AdditionalProduct;
      $this->SpecialService = $SpecialService;
    }

    /**
     * @return SalesProductType
     */
    public function getSalesProduct()
    {
      return $this->SalesProduct;
    }

    /**
     * @param SalesProductType $SalesProduct
     * @return GetProductResponseType
     */
    public function setSalesProduct($SalesProduct)
    {
      $this->SalesProduct = $SalesProduct;
      return $this;
    }

    /**
     * @return BasicProductType
     */
    public function getBasicProduct()
    {
      return $this->BasicProduct;
    }

    /**
     * @param BasicProductType $BasicProduct
     * @return GetProductResponseType
     */
    public function setBasicProduct($BasicProduct)
    {
      $this->BasicProduct = $BasicProduct;
      return $this;
    }

    /**
     * @return AdditionalProductType
     */
    public function getAdditionalProduct()
    {
      return $this->AdditionalProduct;
    }

    /**
     * @param AdditionalProductType $AdditionalProduct
     * @return GetProductResponseType
     */
    public function setAdditionalProduct($AdditionalProduct)
    {
      $this->AdditionalProduct = $AdditionalProduct;
      return $this;
    }

    /**
     * @return SpecialServiceType
     */
    public function getSpecialService()
    {
      return $this->SpecialService;
    }

    /**
     * @param SpecialServiceType $SpecialService
     * @return GetProductResponseType
     */
    public function setSpecialService($SpecialService)
    {
      $this->SpecialService = $SpecialService;
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
     * @return GetProductResponseType
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

}
