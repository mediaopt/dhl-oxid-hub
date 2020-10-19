<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CountryType
{

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var string $alternativeName
     */
    protected $alternativeName = null;

    /**
     * @var string $insularAreaOf
     */
    protected $insularAreaOf = null;

    /**
     * @var string $annotation
     */
    protected $annotation = null;

    /**
     * @var mixed $alpha2ISOCode
     */
    protected $alpha2ISOCode = null;

    /**
     * @var mixed $alpha3ISOCode
     */
    protected $alpha3ISOCode = null;

    /**
     * @var int $numISOCode
     */
    protected $numISOCode = null;

    /**
     * @var mixed $pseudoCode
     */
    protected $pseudoCode = null;

    /**
     * @var boolean $syntheticKey
     */
    protected $syntheticKey = null;

    /**
     * @var date $validFrom
     */
    protected $validFrom = null;

    /**
     * @var date $validTo
     */
    protected $validTo = null;

    /**
     * @param string $name
     * @param string $alternativeName
     * @param string $insularAreaOf
     * @param string $annotation
     * @param mixed $alpha2ISOCode
     * @param mixed $alpha3ISOCode
     * @param int $numISOCode
     * @param mixed $pseudoCode
     * @param boolean $syntheticKey
     * @param date $validFrom
     * @param date $validTo
     */
    public function __construct($name, $alternativeName, $insularAreaOf, $annotation, $alpha2ISOCode, $alpha3ISOCode, $numISOCode, $pseudoCode, $syntheticKey, $validFrom, $validTo)
    {
      $this->name = $name;
      $this->alternativeName = $alternativeName;
      $this->insularAreaOf = $insularAreaOf;
      $this->annotation = $annotation;
      $this->alpha2ISOCode = $alpha2ISOCode;
      $this->alpha3ISOCode = $alpha3ISOCode;
      $this->numISOCode = $numISOCode;
      $this->pseudoCode = $pseudoCode;
      $this->syntheticKey = $syntheticKey;
      $this->validFrom = $validFrom;
      $this->validTo = $validTo;
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
     * @return CountryType
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return string
     */
    public function getAlternativeName()
    {
      return $this->alternativeName;
    }

    /**
     * @param string $alternativeName
     * @return CountryType
     */
    public function setAlternativeName($alternativeName)
    {
      $this->alternativeName = $alternativeName;
      return $this;
    }

    /**
     * @return string
     */
    public function getInsularAreaOf()
    {
      return $this->insularAreaOf;
    }

    /**
     * @param string $insularAreaOf
     * @return CountryType
     */
    public function setInsularAreaOf($insularAreaOf)
    {
      $this->insularAreaOf = $insularAreaOf;
      return $this;
    }

    /**
     * @return string
     */
    public function getAnnotation()
    {
      return $this->annotation;
    }

    /**
     * @param string $annotation
     * @return CountryType
     */
    public function setAnnotation($annotation)
    {
      $this->annotation = $annotation;
      return $this;
    }

    /**
     * @return mixed
     */
    public function getAlpha2ISOCode()
    {
      return $this->alpha2ISOCode;
    }

    /**
     * @param mixed $alpha2ISOCode
     * @return CountryType
     */
    public function setAlpha2ISOCode($alpha2ISOCode)
    {
      $this->alpha2ISOCode = $alpha2ISOCode;
      return $this;
    }

    /**
     * @return mixed
     */
    public function getAlpha3ISOCode()
    {
      return $this->alpha3ISOCode;
    }

    /**
     * @param mixed $alpha3ISOCode
     * @return CountryType
     */
    public function setAlpha3ISOCode($alpha3ISOCode)
    {
      $this->alpha3ISOCode = $alpha3ISOCode;
      return $this;
    }

    /**
     * @return int
     */
    public function getNumISOCode()
    {
      return $this->numISOCode;
    }

    /**
     * @param int $numISOCode
     * @return CountryType
     */
    public function setNumISOCode($numISOCode)
    {
      $this->numISOCode = $numISOCode;
      return $this;
    }

    /**
     * @return mixed
     */
    public function getPseudoCode()
    {
      return $this->pseudoCode;
    }

    /**
     * @param mixed $pseudoCode
     * @return CountryType
     */
    public function setPseudoCode($pseudoCode)
    {
      $this->pseudoCode = $pseudoCode;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getSyntheticKey()
    {
      return $this->syntheticKey;
    }

    /**
     * @param boolean $syntheticKey
     * @return CountryType
     */
    public function setSyntheticKey($syntheticKey)
    {
      $this->syntheticKey = $syntheticKey;
      return $this;
    }

    /**
     * @return date
     */
    public function getValidFrom()
    {
      return $this->validFrom;
    }

    /**
     * @param date $validFrom
     * @return CountryType
     */
    public function setValidFrom($validFrom)
    {
      $this->validFrom = $validFrom;
      return $this;
    }

    /**
     * @return date
     */
    public function getValidTo()
    {
      return $this->validTo;
    }

    /**
     * @param date $validTo
     * @return CountryType
     */
    public function setValidTo($validTo)
    {
      $this->validTo = $validTo;
      return $this;
    }

}
