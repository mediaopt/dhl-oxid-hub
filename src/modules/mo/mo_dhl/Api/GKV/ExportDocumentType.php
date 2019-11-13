<?php

namespace Mediaopt\DHL\Api\GKV;

class ExportDocumentType
{

    /**
     * @var string $invoiceNumber
     */
    protected $invoiceNumber = null;

    /**
     * @var string $exportType
     */
    protected $exportType = null;

    /**
     * @var string $exportTypeDescription
     */
    protected $exportTypeDescription = null;

    /**
     * @var string $termsOfTrade
     */
    protected $termsOfTrade = null;

    /**
     * @var string $placeOfCommital
     */
    protected $placeOfCommital = null;

    /**
     * @var float $additionalFee
     */
    protected $additionalFee = null;

    /**
     * @var string $permitNumber
     */
    protected $permitNumber = null;

    /**
     * @var string $attestationNumber
     */
    protected $attestationNumber = null;

    /**
     * @var Serviceconfiguration $WithElectronicExportNtfctn
     */
    protected $WithElectronicExportNtfctn = null;

    /**
     * @var ExportDocPosition[] $ExportDocPosition
     */
    protected $ExportDocPosition = null;

    /**
     * @param string $exportType
     * @param string $placeOfCommital
     * @param float  $additionalFee
     */
    public function __construct($exportType, $placeOfCommital, $additionalFee)
    {
        $this->exportType = $exportType;
        $this->placeOfCommital = $placeOfCommital;
        $this->additionalFee = $additionalFee;
    }

    /**
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @param string $invoiceNumber
     * @return ExportDocumentType
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getExportType()
    {
        return $this->exportType;
    }

    /**
     * @param string $exportType
     * @return ExportDocumentType
     */
    public function setExportType($exportType)
    {
        $this->exportType = $exportType;
        return $this;
    }

    /**
     * @return string
     */
    public function getExportTypeDescription()
    {
        return $this->exportTypeDescription;
    }

    /**
     * @param string $exportTypeDescription
     * @return ExportDocumentType
     */
    public function setExportTypeDescription($exportTypeDescription)
    {
        $this->exportTypeDescription = $exportTypeDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getTermsOfTrade()
    {
        return $this->termsOfTrade;
    }

    /**
     * @param string $termsOfTrade
     * @return ExportDocumentType
     */
    public function setTermsOfTrade($termsOfTrade)
    {
        $this->termsOfTrade = $termsOfTrade;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceOfCommital()
    {
        return $this->placeOfCommital;
    }

    /**
     * @param string $placeOfCommital
     * @return ExportDocumentType
     */
    public function setPlaceOfCommital($placeOfCommital)
    {
        $this->placeOfCommital = $placeOfCommital;
        return $this;
    }

    /**
     * @return float
     */
    public function getAdditionalFee()
    {
        return $this->additionalFee;
    }

    /**
     * @param float $additionalFee
     * @return ExportDocumentType
     */
    public function setAdditionalFee($additionalFee)
    {
        $this->additionalFee = $additionalFee;
        return $this;
    }

    /**
     * @return string
     */
    public function getPermitNumber()
    {
        return $this->permitNumber;
    }

    /**
     * @param string $permitNumber
     * @return ExportDocumentType
     */
    public function setPermitNumber($permitNumber)
    {
        $this->permitNumber = $permitNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttestationNumber()
    {
        return $this->attestationNumber;
    }

    /**
     * @param string $attestationNumber
     * @return ExportDocumentType
     */
    public function setAttestationNumber($attestationNumber)
    {
        $this->attestationNumber = $attestationNumber;
        return $this;
    }

    /**
     * @return Serviceconfiguration
     */
    public function getWithElectronicExportNtfctn()
    {
        return $this->WithElectronicExportNtfctn;
    }

    /**
     * @param Serviceconfiguration $WithElectronicExportNtfctn
     * @return ExportDocumentType
     */
    public function setWithElectronicExportNtfctn($WithElectronicExportNtfctn)
    {
        $this->WithElectronicExportNtfctn = $WithElectronicExportNtfctn;
        return $this;
    }

    /**
     * @return ExportDocPosition[]
     */
    public function getExportDocPosition()
    {
        return $this->ExportDocPosition;
    }

    /**
     * @param ExportDocPosition[] $ExportDocPosition
     * @return ExportDocumentType
     */
    public function setExportDocPosition(array $ExportDocPosition = null)
    {
        $this->ExportDocPosition = $ExportDocPosition;
        return $this;
    }

}
