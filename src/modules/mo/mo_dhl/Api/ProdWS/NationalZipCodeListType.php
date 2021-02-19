<?php


namespace Mediaopt\DHL\Api\ProdWS;

class NationalZipCodeListType
{

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var string $description
     */
    protected $description = null;

    /**
     * @var nationalZipCodeType[] $nationalZipCode
     */
    protected $nationalZipCode = null;

    /**
     * @param nationalZipCodeType[] $nationalZipCode
     */
    public function __construct(array $nationalZipCode)
    {
      $this->nationalZipCode = $nationalZipCode;
    }

    /**
     * @return string
     */
    public function getName()
    {
      return $this->name;
    }

    /**
     * @param string $name
     * @return NationalZipCodeListType
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
      return $this->description;
    }

    /**
     * @param string $description
     * @return NationalZipCodeListType
     */
    public function setDescription($description)
    {
      $this->description = $description;
      return $this;
    }

    /**
     * @return nationalZipCodeType[]
     */
    public function getNationalZipCode()
    {
      return $this->nationalZipCode;
    }

    /**
     * @param nationalZipCodeType[] $nationalZipCode
     * @return NationalZipCodeListType
     */
    public function setNationalZipCode(array $nationalZipCode)
    {
      $this->nationalZipCode = $nationalZipCode;
      return $this;
    }

}
