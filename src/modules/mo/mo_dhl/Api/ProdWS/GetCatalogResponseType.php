<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetCatalogResponseType
{

    /**
     * @var CatalogType $catalog
     */
    protected $catalog = null;

    /**
     * @var string $message
     */
    protected $message = null;


    public function __construct()
    {

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
     * @return GetCatalogResponseType
     */
    public function setCatalog($catalog)
    {
      $this->catalog = $catalog;
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
     * @return GetCatalogResponseType
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

}
