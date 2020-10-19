<?php


namespace Mediaopt\DHL\Api\ProdWS;

class GetProductChangeInformationResponseType
{

    /**
     * @var boolean $changesAvailable
     */
    protected $changesAvailable = null;

    /**
     * @var TimestampType $providingDate
     */
    protected $providingDate = null;

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
     * @return GetProductChangeInformationResponseType
     */
    public function setChangesAvailable($changesAvailable)
    {
      $this->changesAvailable = $changesAvailable;
      return $this;
    }

    /**
     * @return TimestampType
     */
    public function getProvidingDate()
    {
      return $this->providingDate;
    }

    /**
     * @param TimestampType $providingDate
     * @return GetProductChangeInformationResponseType
     */
    public function setProvidingDate($providingDate)
    {
      $this->providingDate = $providingDate;
      return $this;
    }

}
