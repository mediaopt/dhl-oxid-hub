<?php


namespace Mediaopt\DHL\Api\ProdWS;

class FormulaComponentType
{

    /**
     * @var int $prodwsID
     */
    protected $prodwsID = null;

    /**
     * @var int $version
     */
    protected $version = null;

    /**
     * @var string $component
     */
    protected $component = null;

    /**
     * @param int $prodwsID
     * @param int $version
     * @param string $component
     */
    public function __construct($prodwsID, $version, $component)
    {
      $this->prodwsID = $prodwsID;
      $this->version = $version;
      $this->component = $component;
    }

    /**
     * @return int
     */
    public function getProdwsID()
    {
      return $this->prodwsID;
    }

    /**
     * @param int $prodwsID
     * @return FormulaComponentType
     */
    public function setProdwsID($prodwsID)
    {
      $this->prodwsID = $prodwsID;
      return $this;
    }

    /**
     * @return int
     */
    public function getVersion()
    {
      return $this->version;
    }

    /**
     * @param int $version
     * @return FormulaComponentType
     */
    public function setVersion($version)
    {
      $this->version = $version;
      return $this;
    }

    /**
     * @return string
     */
    public function getComponent()
    {
      return $this->component;
    }

    /**
     * @param string $component
     * @return FormulaComponentType
     */
    public function setComponent($component)
    {
      $this->component = $component;
      return $this;
    }

}
