<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CatalogList
{

    /**
     * @var CatalogType $catalog
     */
    protected $catalog = null;

    /**
     * @param CatalogType $catalog
     */
    public function __construct($catalog)
    {
      $this->catalog = $catalog;
    }

    /**
     * @return CatalogType
     */
    public function getCatalog()
    {
      return $this->catalog;
    }

    /**
     * @param CatalogType $catalog
     * @return CatalogList
     */
    public function setCatalog($catalog)
    {
      $this->catalog = $catalog;
      return $this;
    }

}
