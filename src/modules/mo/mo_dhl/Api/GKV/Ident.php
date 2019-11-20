<?php

namespace Mediaopt\DHL\Api\GKV;

class Ident
{

    /**
     * @var string $surname
     */
    protected $surname = null;

    /**
     * @var string $givenName
     */
    protected $givenName = null;

    /**
     * @var string $dateOfBirth
     */
    protected $dateOfBirth = null;

    /**
     * @var string $minimumAge
     */
    protected $minimumAge = null;

    /**
     * @param string $surname
     * @param string $givenName
     * @param string $dateOfBirth
     * @param string $minimumAge
     */
    public function __construct($surname, $givenName, $dateOfBirth, $minimumAge)
    {
        $this->surname = $surname;
        $this->givenName = $givenName;
        $this->dateOfBirth = $dateOfBirth;
        $this->minimumAge = $minimumAge;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return Ident
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string
     */
    public function getGivenName()
    {
        return $this->givenName;
    }

    /**
     * @param string $givenName
     * @return Ident
     */
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param string $dateOfBirth
     * @return Ident
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    /**
     * @return string
     */
    public function getMinimumAge()
    {
        return $this->minimumAge;
    }

    /**
     * @param string $minimumAge
     * @return Ident
     */
    public function setMinimumAge($minimumAge)
    {
        $this->minimumAge = $minimumAge;
        return $this;
    }

}
