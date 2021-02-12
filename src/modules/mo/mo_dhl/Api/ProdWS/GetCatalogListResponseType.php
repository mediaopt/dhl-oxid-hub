<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetCatalogListResponseType
{

    /**
     * @var CatalogList $catalogList
     */
    protected $catalogList = null;

    /**
     * @var string $message
     */
    protected $message = null;


    public function __construct()
    {

    }

    /**
     * @return CatalogList
     */
    public function getCatalogList()
    {
      return $this->catalogList;
    }

    /**
     * @param CatalogList $catalogList
     * @return GetCatalogListResponseType
     */
    public function setCatalogList($catalogList)
    {
      $this->catalogList = $catalogList;
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
     * @return GetCatalogListResponseType
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

}
