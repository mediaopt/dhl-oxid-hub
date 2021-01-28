<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ValidityType
{

    /**
     * @var TimestampType $validFrom
     */
    protected $validFrom = null;

    /**
     * @var TimestampType $validTo
     */
    protected $validTo = null;

    /**
     * @param TimestampType $validFrom
     */
    public function __construct($validFrom)
    {
      $this->validFrom = $validFrom;
    }

    /**
     * @return TimestampType
     */
    public function getValidFrom()
    {
      return $this->validFrom;
    }

    /**
     * @param TimestampType $validFrom
     * @return ValidityType
     */
    public function setValidFrom($validFrom)
    {
      $this->validFrom = $validFrom;
      return $this;
    }

    /**
     * @return TimestampType
     */
    public function getValidTo()
    {
      return $this->validTo;
    }

    /**
     * @param TimestampType $validTo
     * @return ValidityType
     */
    public function setValidTo($validTo)
    {
      $this->validTo = $validTo;
      return $this;
    }

}
