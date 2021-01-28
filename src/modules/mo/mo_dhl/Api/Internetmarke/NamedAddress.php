<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class NamedAddress
{

    /**
     * @var Name $name
     */
    protected $name = null;

    /**
     * @var Address $address
     */
    protected $address = null;

    /**
     * @param Name $name
     * @param Address $address
     */
    public function __construct($name, $address)
    {
      $this->name = $name;
      $this->address = $address;
    }

    /**
     * @return Name
     */
    public function getName()
    {
      return $this->name;
    }

    /**
     * @param Name $name
     * @return NamedAddress
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
      return $this->address;
    }

    /**
     * @param Address $address
     * @return NamedAddress
     */
    public function setAddress($address)
    {
      $this->address = $address;
      return $this;
    }

}
