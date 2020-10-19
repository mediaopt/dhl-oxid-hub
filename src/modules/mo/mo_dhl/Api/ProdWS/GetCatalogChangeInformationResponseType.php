<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetCatalogChangeInformationResponseType
{

    /**
     * @var boolean $changesAvailable
     */
    protected $changesAvailable = null;

    /**
     * @var CatalogType[] $catalog
     */
    protected $catalog = null;

    /**
     * @param boolean $changesAvailable
     */
    public function __construct($changesAvailable)
    {
      $this->changesAvailable = $changesAvailable;
    }

    /**
     * @return boolean
     */
    public function getChangesAvailable()
    {
      return $this->changesAvailable;
    }

    /**
     * @param boolean $changesAvailable
     * @return GetCatalogChangeInformationResponseType
     */
    public function setChangesAvailable($changesAvailable)
    {
      $this->changesAvailable = $changesAvailable;
      return $this;
    }

    /**
     * @return CatalogType[]
     */
    public function getCatalog()
    {
      return $this->catalog;
    }

    /**
     * @param CatalogType[] $catalog
     * @return GetCatalogChangeInformationResponseType
     */
    public function setCatalog(array $catalog = null)
    {
      $this->catalog = $catalog;
      return $this;
    }

}
