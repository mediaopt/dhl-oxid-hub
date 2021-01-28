<?php


namespace Mediaopt\DHL\Api\ProdWS;

class RegisterEMailAdressResponseType
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
     * @var boolean $registration
     */
    protected $registration = null;

    /**
     * @var \DateTime $registrationDateTime
     */
    protected $registrationDateTime = null;

    /**
     * @var string $message
     */
    protected $message = null;

    /**
     * @param boolean $registration
     */
    public function __construct($registration)
    {
      $this->registration = $registration;
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
     * @return RegisterEMailAdressResponseType
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
     * @return RegisterEMailAdressResponseType
     */
    public function setSubMandantID($subMandantID)
    {
      $this->subMandantID = $subMandantID;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getRegistration()
    {
      return $this->registration;
    }

    /**
     * @param boolean $registration
     * @return RegisterEMailAdressResponseType
     */
    public function setRegistration($registration)
    {
      $this->registration = $registration;
      return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRegistrationDateTime()
    {
      if ($this->registrationDateTime == null) {
        return null;
      } else {
        try {
          return new \DateTime($this->registrationDateTime);
        } catch (\Exception $e) {
          return false;
        }
      }
    }

    /**
     * @param \DateTime $registrationDateTime
     * @return RegisterEMailAdressResponseType
     */
    public function setRegistrationDateTime(\DateTime $registrationDateTime = null)
    {
      if ($registrationDateTime == null) {
       $this->registrationDateTime = null;
      } else {
        $this->registrationDateTime = $registrationDateTime->format(\DateTime::ATOM);
      }
      return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
      return $this->message;
    }

    /**
     * @param string $message
     * @return RegisterEMailAdressResponseType
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

}
