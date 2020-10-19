<?php


namespace Mediaopt\DHL\Api\ProdWS;

class SalesProduct
{

    /**
     * @var ShortProductIdentifierType $salesProductShortIdentifier
     */
    protected $salesProductShortIdentifier = null;

    /**
     * @var CurrencyAmountType $salesProductGrossPrice
     */
    protected $salesProductGrossPrice = null;

    /**
     * @param ShortProductIdentifierType $salesProductShortIdentifier
     * @param CurrencyAmountType         $salesProductGrossPrice
     */
    public function __construct($salesProductShortIdentifier, $salesProductGrossPrice)
    {
      $this->salesProductShortIdentifier = $salesProductShortIdentifier;
      $this->salesProductGrossPrice = $salesProductGrossPrice;
    }

    /**
     * @return ShortProductIdentifierType
     */
    public function getSalesProductShortIdentifier()
    {
      return $this->salesProductShortIdentifier;
    }

    /**
     * @param ShortProductIdentifierType $salesProductShortIdentifier
     * @return SalesProduct
     */
    public function setSalesProductShortIdentifier($salesProductShortIdentifier)
    {
      $this->salesProductShortIdentifier = $salesProductShortIdentifier;
      return $this;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getSalesProductGrossPrice()
    {
      return $this->salesProductGrossPrice;
    }

    /**
     * @param CurrencyAmountType $salesProductGrossPrice
     * @return SalesProduct
     */
    public function setSalesProductGrossPrice($salesProductGrossPrice)
    {
      $this->salesProductGrossPrice = $salesProductGrossPrice;
      return $this;
    }

}
