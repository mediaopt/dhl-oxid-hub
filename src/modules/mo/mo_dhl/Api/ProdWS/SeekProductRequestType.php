<?php


namespace Mediaopt\DHL\Api\ProdWS;

class SeekProductRequestType
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
     * @var SearchParameterList $searchParameterList
     */
    protected $searchParameterList = null;

    /**
     * @param string $mandantID
     */
    public function __construct($mandantID)
    {
      $this->mandantID = $mandantID;
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
     * @return SeekProductRequestType
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
     * @return SeekProductRequestType
     */
    public function setSubMandantID($subMandantID)
    {
      $this->subMandantID = $subMandantID;
      return $this;
    }

    /**
     * @return SearchParameterList
     */
    public function getSearchParameterList()
    {
      return $this->searchParameterList;
    }

    /**
     * @param SearchParameterList $searchParameterList
     * @return SeekProductRequestType
     */
    public function setSearchParameterList($searchParameterList)
    {
      $this->searchParameterList = $searchParameterList;
      return $this;
    }

}
