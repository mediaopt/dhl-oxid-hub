<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetProductChangeInformationRequestType
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
     * @return GetProductChangeInformationRequestType
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
     * @return GetProductChangeInformationRequestType
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
     * @return GetProductChangeInformationRequestType
     */
    public function setLastQueryDate($lastQueryDate)
    {
      $this->lastQueryDate = $lastQueryDate;
      return $this;
    }

}
