<?php


namespace Mediaopt\DHL\Api\ProdWS;

class NationalZipCodeArea
{

    /**
     * @var nationalZipCodeType $firstZipCode
     */
    protected $firstZipCode = null;

    /**
     * @var nationalZipCodeType $lastZipCode
     */
    protected $lastZipCode = null;

    /**
     * @param nationalZipCodeType $firstZipCode
     * @param nationalZipCodeType $lastZipCode
     */
    public function __construct($firstZipCode, $lastZipCode)
    {
      $this->firstZipCode = $firstZipCode;
      $this->lastZipCode = $lastZipCode;
    }

    /**
     * @return nationalZipCodeType
     */
    public function getFirstZipCode()
    {
      return $this->firstZipCode;
    }

    /**
     * @param nationalZipCodeType $firstZipCode
     * @return NationalZipCodeArea
     */
    public function setFirstZipCode($firstZipCode)
    {
      $this->firstZipCode = $firstZipCode;
      return $this;
    }

    /**
     * @return nationalZipCodeType
     */
    public function getLastZipCode()
    {
      return $this->lastZipCode;
    }

    /**
     * @param nationalZipCodeType $lastZipCode
     * @return NationalZipCodeArea
     */
    public function setLastZipCode($lastZipCode)
    {
      $this->lastZipCode = $lastZipCode;
      return $this;
    }

}
