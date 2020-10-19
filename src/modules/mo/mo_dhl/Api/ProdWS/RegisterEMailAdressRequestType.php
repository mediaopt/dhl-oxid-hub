<?php


namespace Mediaopt\DHL\Api\ProdWS;

class RegisterEMailAdressRequestType
{

    /**
     * @var string $mandantID
     */
    protected $mandantID = null;

    /**
     * @var string[] $eMailAdress
     */
    protected $eMailAdress = null;

    /**
     * @var SubMandant $subMandant
     */
    protected $subMandant = null;

    /**
     * @var boolean $overwrite
     */
    protected $overwrite = null;

    /**
     * @param boolean $overwrite
     */
    public function __construct($overwrite)
    {
      $this->overwrite = $overwrite;
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
     * @return RegisterEMailAdressRequestType
     */
    public function setMandantID($mandantID)
    {
      $this->mandantID = $mandantID;
      return $this;
    }

    /**
     * @return string[]
     */
    public function getEMailAdress()
    {
      return $this->eMailAdress;
    }

    /**
     * @param string[] $eMailAdress
     * @return RegisterEMailAdressRequestType
     */
    public function setEMailAdress(array $eMailAdress = null)
    {
      $this->eMailAdress = $eMailAdress;
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
     * @return RegisterEMailAdressRequestType
     */
    public function setSubMandant($subMandant)
    {
      $this->subMandant = $subMandant;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getOverwrite()
    {
      return $this->overwrite;
    }

    /**
     * @param boolean $overwrite
     * @return RegisterEMailAdressRequestType
     */
    public function setOverwrite($overwrite)
    {
      $this->overwrite = $overwrite;
      return $this;
    }

}
