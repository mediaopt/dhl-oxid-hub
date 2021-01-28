<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetCatalogRequestType
{

    /**
     * @var string $mandantID
     */
    protected $mandantID = null;

    /**
     * @var string $subMandantID
     */
    protected $subMandantID = null;

    /**
     * @var string $catalogName
     */
    protected $catalogName = null;

    /**
     * @param string $catalogName
     */
    public function __construct($catalogName)
    {
      $this->catalogName = $catalogName;
    }

    /**
     * @return string
     */
    public function getMandantID()
    {
      return $this->mandantID;
    }

    /**
     * @param string $mandantID
     * @return GetCatalogRequestType
     */
    public function setMandantID($mandantID)
    {
      $this->mandantID = $mandantID;
      return $this;
    }

    /**
     * @return string
     */
    public function getSubMandantID()
    {
      return $this->subMandantID;
    }

    /**
     * @param string $subMandantID
     * @return GetCatalogRequestType
     */
    public function setSubMandantID($subMandantID)
    {
      $this->subMandantID = $subMandantID;
      return $this;
    }

    /**
     * @return string
     */
    public function getCatalogName()
    {
      return $this->catalogName;
    }

    /**
     * @param string $catalogName
     * @return GetCatalogRequestType
     */
    public function setCatalogName($catalogName)
    {
      $this->catalogName = $catalogName;
      return $this;
    }

}
