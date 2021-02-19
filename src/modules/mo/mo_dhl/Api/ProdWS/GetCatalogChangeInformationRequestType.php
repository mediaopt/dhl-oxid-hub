<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetCatalogChangeInformationRequestType
{

    /**
     * @var string $mandantID
     */
    protected $mandantID = null;

    /**
     * @var string $submandantID
     */
    protected $submandantID = null;

    /**
     * @var TimestampType $lastQueryDate
     */
    protected $lastQueryDate = null;

    /**
     * @param TimestampType $lastQueryDate
     */
    public function __construct($lastQueryDate)
    {
      $this->lastQueryDate = $lastQueryDate;
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
     * @return GetCatalogChangeInformationRequestType
     */
    public function setMandantID($mandantID)
    {
      $this->mandantID = $mandantID;
      return $this;
    }

    /**
     * @return string
     */
    public function getSubmandantID()
    {
      return $this->submandantID;
    }

    /**
     * @param string $submandantID
     * @return GetCatalogChangeInformationRequestType
     */
    public function setSubmandantID($submandantID)
    {
      $this->submandantID = $submandantID;
      return $this;
    }

    /**
     * @return TimestampType
     */
    public function getLastQueryDate()
    {
      return $this->lastQueryDate;
    }

    /**
     * @param TimestampType $lastQueryDate
     * @return GetCatalogChangeInformationRequestType
     */
    public function setLastQueryDate($lastQueryDate)
    {
      $this->lastQueryDate = $lastQueryDate;
      return $this;
    }

}
