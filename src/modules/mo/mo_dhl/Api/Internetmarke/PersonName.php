<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class PersonName
{

    /**
     * @var string $salutation
     */
    protected $salutation = null;

    /**
     * @var string $title
     */
    protected $title = null;

    /**
     * @var string $firstname
     */
    protected $firstname = null;

    /**
     * @var string $lastname
     */
    protected $lastname = null;

    /**
     * @param string $firstname
     * @param string $lastname
     */
    public function __construct($firstname, $lastname)
    {
      $this->firstname = $firstname;
      $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getSalutation()
    {
      return $this->salutation;
    }

    /**
     * @param string $salutation
     * @return PersonName
     */
    public function setSalutation($salutation)
    {
      $this->salutation = $salutation;
      return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
      return $this->title;
    }

    /**
     * @param string $title
     * @return PersonName
     */
    public function setTitle($title)
    {
      $this->title = $title;
      return $this;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
      return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return PersonName
     */
    public function setFirstname($firstname)
    {
      $this->firstname = $firstname;
      return $this;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
      return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return PersonName
     */
    public function setLastname($lastname)
    {
      $this->lastname = $lastname;
      return $this;
    }

}
