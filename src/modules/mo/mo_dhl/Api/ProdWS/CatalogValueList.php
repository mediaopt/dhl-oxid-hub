<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CatalogValueList
{

    /**
     * @var CatalogValueType $catalogValue
     */
    protected $catalogValue = null;

    /**
     * @param CatalogValueType $catalogValue
     */
    public function __construct($catalogValue)
    {
      $this->catalogValue = $catalogValue;
    }

    /**
     * @return CatalogValueType
     */
    public function getCatalogValue()
    {
      return $this->catalogValue;
    }

    /**
     * @param CatalogValueType $catalogValue
     * @return CatalogValueList
     */
    public function setCatalogValue($catalogValue)
    {
      $this->catalogValue = $catalogValue;
      return $this;
    }

}
