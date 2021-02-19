<?php


namespace Mediaopt\DHL\Api\ProdWS;

class RegisterNotificationRequestType
{

    /**
     * @var string $mandantID
     */
    protected $mandantID = null;

    /**
     * @var SubMandant $subMandant
     */
    protected $subMandant = null;

    /**
     * @var string $url
     */
    protected $url = null;

    /**
     * @param string $url
     */
    public function __construct($url)
    {
      $this->url = $url;
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
     * @return RegisterNotificationRequestType
     */
    public function setMandantID($mandantID)
    {
      $this->mandantID = $mandantID;
      return $this;
    }

    /**
     * @return SubMandant
     */
    public function getSubMandant()
    {
      return $this->subMandant;
    }

    /**
     * @param SubMandant $subMandant
     * @return RegisterNotificationRequestType
     */
    public function setSubMandant($subMandant)
    {
      $this->subMandant = $subMandant;
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
     * @return RegisterNotificationRequestType
     */
    public function setUrl($url)
    {
      $this->url = $url;
      return $this;
    }

}
