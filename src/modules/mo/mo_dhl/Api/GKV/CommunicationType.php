<?php

namespace Mediaopt\DHL\Api\GKV;

class CommunicationType
{

    /**
     * @var string $phone
     */
    protected $phone = null;

    /**
     * @var string $email
     */
    protected $email = null;

    /**
     * @var string $contactPerson
     */
    protected $contactPerson = null;


    public function __construct()
    {

    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return CommunicationType
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return CommunicationType
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     * @param string $contactPerson
     * @return CommunicationType
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;
        return $this;
    }

}
