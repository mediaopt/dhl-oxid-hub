<?php

namespace Mediaopt\DHL\Api\GKV;

class ExportDocPosition
{

    /**
     * @var string $description
     */
    protected $description = null;

    /**
     * @var string $countryCodeOrigin
     */
    protected $countryCodeOrigin = null;

    /**
     * @var string $customsTariffNumber
     */
    protected $customsTariffNumber = null;

    /**
     * @var int $amount
     */
    protected $amount = null;

    /**
     * @var float $netWeightInKG
     */
    protected $netWeightInKG = null;

    /**
     * @var float $customsValue
     */
    protected $customsValue = null;

    /**
     * @param string $description
     * @param string $countryCodeOrigin
     * @param string $customsTariffNumber
     * @param int    $amount
     * @param float  $netWeightInKG
     * @param float  $customsValue
     */
    public function __construct($description, $countryCodeOrigin, $customsTariffNumber, $amount, $netWeightInKG, $customsValue)
    {
        $this->description = $description;
        $this->countryCodeOrigin = $countryCodeOrigin;
        $this->customsTariffNumber = $customsTariffNumber;
        $this->amount = $amount;
        $this->netWeightInKG = $netWeightInKG;
        $this->customsValue = $customsValue;
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
     * @return ExportDocPosition
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCodeOrigin()
    {
        return $this->countryCodeOrigin;
    }

    /**
     * @param string $countryCodeOrigin
     * @return ExportDocPosition
     */
    public function setCountryCodeOrigin($countryCodeOrigin)
    {
        $this->countryCodeOrigin = $countryCodeOrigin;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomsTariffNumber()
    {
        return $this->customsTariffNumber;
    }

    /**
     * @param string $customsTariffNumber
     * @return ExportDocPosition
     */
    public function setCustomsTariffNumber($customsTariffNumber)
    {
        $this->customsTariffNumber = $customsTariffNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return ExportDocPosition
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return float
     */
    public function getNetWeightInKG()
    {
        return $this->netWeightInKG;
    }

    /**
     * @param float $netWeightInKG
     * @return ExportDocPosition
     */
    public function setNetWeightInKG($netWeightInKG)
    {
        $this->netWeightInKG = $netWeightInKG;
        return $this;
    }

    /**
     * @return float
     */
    public function getCustomsValue()
    {
        return $this->customsValue;
    }

    /**
     * @param float $customsValue
     * @return ExportDocPosition
     */
    public function setCustomsValue($customsValue)
    {
        $this->customsValue = $customsValue;
        return $this;
    }

}
