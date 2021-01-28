<?php


namespace Mediaopt\DHL\Api\ProdWS;

class PropertyValueType
{

    /**
     * @var AlphanumericValueType $alphanumericValue
     */
    protected $alphanumericValue = null;

    /**
     * @var NumericValueType $numericValue
     */
    protected $numericValue = null;

    /**
     * @var boolean $booleanValue
     */
    protected $booleanValue = null;

    /**
     * @var DateValueType $dateValue
     */
    protected $dateValue = null;

    /**
     * @var CurrencyValueType $currencyValue
     */
    protected $currencyValue = null;

    /**
     * @var string $hyperlinkValue
     */
    protected $hyperlinkValue = null;

    /**
     * @param AlphanumericValueType $alphanumericValue
     * @param NumericValueType      $numericValue
     * @param boolean               $booleanValue
     * @param DateValueType         $dateValue
     * @param CurrencyValueType     $currencyValue
     * @param string                $hyperlinkValue
     */
    public function __construct($alphanumericValue, $numericValue, $booleanValue, $dateValue, $currencyValue, $hyperlinkValue)
    {
      $this->alphanumericValue = $alphanumericValue;
      $this->numericValue = $numericValue;
      $this->booleanValue = $booleanValue;
      $this->dateValue = $dateValue;
      $this->currencyValue = $currencyValue;
      $this->hyperlinkValue = $hyperlinkValue;
    }

    /**
     * @return AlphanumericValueType
     */
    public function getAlphanumericValue()
    {
      return $this->alphanumericValue;
    }

    /**
     * @param AlphanumericValueType $alphanumericValue
     * @return PropertyValueType
     */
    public function setAlphanumericValue($alphanumericValue)
    {
      $this->alphanumericValue = $alphanumericValue;
      return $this;
    }

    /**
     * @return NumericValueType
     */
    public function getNumericValue()
    {
      return $this->numericValue;
    }

    /**
     * @param NumericValueType $numericValue
     * @return PropertyValueType
     */
    public function setNumericValue($numericValue)
    {
      $this->numericValue = $numericValue;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getBooleanValue()
    {
      return $this->booleanValue;
    }

    /**
     * @param boolean $booleanValue
     * @return PropertyValueType
     */
    public function setBooleanValue($booleanValue)
    {
      $this->booleanValue = $booleanValue;
      return $this;
    }

    /**
     * @return DateValueType
     */
    public function getDateValue()
    {
      return $this->dateValue;
    }

    /**
     * @param DateValueType $dateValue
     * @return PropertyValueType
     */
    public function setDateValue($dateValue)
    {
      $this->dateValue = $dateValue;
      return $this;
    }

    /**
     * @return CurrencyValueType
     */
    public function getCurrencyValue()
    {
      return $this->currencyValue;
    }

    /**
     * @param CurrencyValueType $currencyValue
     * @return PropertyValueType
     */
    public function setCurrencyValue($currencyValue)
    {
      $this->currencyValue = $currencyValue;
      return $this;
    }

    /**
     * @return string
     */
    public function getHyperlinkValue()
    {
      return $this->hyperlinkValue;
    }

    /**
     * @param string $hyperlinkValue
     * @return PropertyValueType
     */
    public function setHyperlinkValue($hyperlinkValue)
    {
      $this->hyperlinkValue = $hyperlinkValue;
      return $this;
    }

}
