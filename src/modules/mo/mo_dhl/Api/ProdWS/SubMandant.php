<?php


namespace Mediaopt\DHL\Api\ProdWS;

class SubMandant
{

    /**
     * @var string $subMandantID
     */
    protected $subMandantID = null;

    /**
     * @var string $subMandantName
     */
    protected $subMandantName = null;

    /**
     * @var string $url
     */
    protected $url = null;

    /**
     * @param string $subMandantID
     * @param string $subMandantName
     * @param string $url
     */
    public function __construct($subMandantID, $subMandantName, $url)
    {
      $this->subMandantID = $subMandantID;
      $this->subMandantName = $subMandantName;
      $this->url = $url;
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
     * @return SubMandant
     */
    public function setSubMandantID($subMandantID)
    {
      $this->subMandantID = $subMandantID;
      return $this;
    }

    /**
     * @return string
     */
    public function getSubMandantName()
    {
      return $this->subMandantName;
    }

    /**
     * @param string $subMandantName
     * @return SubMandant
     */
    public function setSubMandantName($subMandantName)
    {
      $this->subMandantName = $subMandantName;
      return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
      return $this->url;
    }

    /**
     * @param string $url
     * @return SubMandant
     */
    public function setUrl($url)
    {
      $this->url = $url;
      return $this;
    }

}
