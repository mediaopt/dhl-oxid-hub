<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class RetrieveContractProductsResponseType
{

    /**
     * @var ContractProductResponseType[] $products
     */
    protected $products = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return ContractProductResponseType[]
     */
    public function getProducts()
    {
      return $this->products;
    }

    /**
     * @param ContractProductResponseType[] $products
     * @return RetrieveContractProductsResponseType
     */
    public function setProducts(array $products = null)
    {
      $this->products = $products;
      return $this;
    }

}
