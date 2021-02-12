<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetCatalogListRequestType
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
     * @var boolean $catalogProperties
     */
    protected $catalogProperties = null;

    /**
     * @param boolean $catalogProperties
     */
    public function __construct($catalogProperties)
    {
      $this->catalogProperties = $catalogProperties;
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
     * @return GetCatalogListRequestType
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
     * @return GetCatalogListRequestType
     */
    public function setSubMandantID($subMandantID)
    {
      $this->subMandantID = $subMandantID;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getCatalogProperties()
    {
      return $this->catalogProperties;
    }

    /**
     * @param boolean $catalogProperties
     * @return GetCatalogListRequestType
     */
    public function setCatalogProperties($catalogProperties)
    {
      $this->catalogProperties = $catalogProperties;
      return $this;
    }

}
