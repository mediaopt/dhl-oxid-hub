<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class VASIdentCheck extends \ArrayObject
{
    /**
     * @var array
     */
    protected $initialized = array();
    public function isInitialized($property) : bool
    {
        return array_key_exists($property, $this->initialized);
    }
    /**
     * 
     *
     * @var string
     */
    protected $firstName;
    /**
     * 
     *
     * @var string
     */
    protected $lastName;
    /**
     * date of birth, used in conjunction with minimumAge and shipping date. Format yyyy-mm-dd is used.
     *
     * @var \DateTime
     */
    protected $dateOfBirth;
    /**
     * Checks if recipient will have reached specified age by shipping date.
     *
     * @var string
     */
    protected $minimumAge;
    /**
     * 
     *
     * @return string
     */
    public function getFirstName() : string
    {
        return $this->firstName;
    }
    /**
     * 
     *
     * @param string $firstName
     *
     * @return self
     */
    public function setFirstName(string $firstName) : self
    {
        $this->initialized['firstName'] = true;
        $this->firstName = $firstName;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getLastName() : string
    {
        return $this->lastName;
    }
    /**
     * 
     *
     * @param string $lastName
     *
     * @return self
     */
    public function setLastName(string $lastName) : self
    {
        $this->initialized['lastName'] = true;
        $this->lastName = $lastName;
        return $this;
    }
    /**
     * date of birth, used in conjunction with minimumAge and shipping date. Format yyyy-mm-dd is used.
     *
     * @return \DateTime
     */
    public function getDateOfBirth() : \DateTime
    {
        return $this->dateOfBirth;
    }
    /**
     * date of birth, used in conjunction with minimumAge and shipping date. Format yyyy-mm-dd is used.
     *
     * @param \DateTime $dateOfBirth
     *
     * @return self
     */
    public function setDateOfBirth(\DateTime $dateOfBirth) : self
    {
        $this->initialized['dateOfBirth'] = true;
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }
    /**
     * Checks if recipient will have reached specified age by shipping date.
     *
     * @return string
     */
    public function getMinimumAge() : string
    {
        return $this->minimumAge;
    }
    /**
     * Checks if recipient will have reached specified age by shipping date.
     *
     * @param string $minimumAge
     *
     * @return self
     */
    public function setMinimumAge(string $minimumAge) : self
    {
        $this->initialized['minimumAge'] = true;
        $this->minimumAge = $minimumAge;
        return $this;
    }
}