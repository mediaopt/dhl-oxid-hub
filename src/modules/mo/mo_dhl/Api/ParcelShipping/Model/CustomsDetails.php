<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class CustomsDetails extends \ArrayObject
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
     * Invoice number
     *
     * @var string
     */
    protected $invoiceNo;
    /**
     * This contains the category of goods contained in parcel.
     *
     * @var string
     */
    protected $exportType;
    /**
     * Mandatory if exporttype is 'OTHER'
     *
     * @var string
     */
    protected $exportDescription;
    /**
     * Aka 'Terms of Trade' aka 'Frankatur'. The attribute is exclusively used for the product Europaket (V54EPAK). DDU is deprecated (use DAP instead).
     *
     * @var string
     */
    protected $shippingConditions;
    /**
     * Permit number. Very rarely needed. Mostly relevant for higher value goods. An example use case would be an item made from crocodile leather which requires dedicated license / permit identified by that number.
     *
     * @var string
     */
    protected $permitNo;
    /**
     * Attest or certification identified by this number. Very rarely needed. An example use case would be a medical shipment referring to an attestation that a certain amount of medicine may be imported within e.g. the current quarter of the year.
     *
     * @var string
     */
    protected $attestationNo;
    /**
     * flag confirming whether electronic record for export was made
     *
     * @var bool
     */
    protected $hasElectronicExportNotification;
    /**
     * Currency and numeric value.
     *
     * @var Value
     */
    protected $postalCharges;
    /**
     * Optional. Will appear on CN23.
     *
     * @var string
     */
    protected $officeOfOrigin;
    /**
     * Commodity types in that package
     *
     * @var Commodity[]
     */
    protected $items;
    /**
     * Invoice number
     *
     * @return string
     */
    public function getInvoiceNo() : string
    {
        return $this->invoiceNo;
    }
    /**
     * Invoice number
     *
     * @param string $invoiceNo
     *
     * @return self
     */
    public function setInvoiceNo(string $invoiceNo) : self
    {
        $this->initialized['invoiceNo'] = true;
        $this->invoiceNo = $invoiceNo;
        return $this;
    }
    /**
     * This contains the category of goods contained in parcel.
     *
     * @return string
     */
    public function getExportType() : string
    {
        return $this->exportType;
    }
    /**
     * This contains the category of goods contained in parcel.
     *
     * @param string $exportType
     *
     * @return self
     */
    public function setExportType(string $exportType) : self
    {
        $this->initialized['exportType'] = true;
        $this->exportType = $exportType;
        return $this;
    }
    /**
     * Mandatory if exporttype is 'OTHER'
     *
     * @return string
     */
    public function getExportDescription() : string
    {
        return $this->exportDescription;
    }
    /**
     * Mandatory if exporttype is 'OTHER'
     *
     * @param string $exportDescription
     *
     * @return self
     */
    public function setExportDescription(string $exportDescription) : self
    {
        $this->initialized['exportDescription'] = true;
        $this->exportDescription = $exportDescription;
        return $this;
    }
    /**
     * Aka 'Terms of Trade' aka 'Frankatur'. The attribute is exclusively used for the product Europaket (V54EPAK). DDU is deprecated (use DAP instead).
     *
     * @return string
     */
    public function getShippingConditions() : string
    {
        return $this->shippingConditions;
    }
    /**
     * Aka 'Terms of Trade' aka 'Frankatur'. The attribute is exclusively used for the product Europaket (V54EPAK). DDU is deprecated (use DAP instead).
     *
     * @param string $shippingConditions
     *
     * @return self
     */
    public function setShippingConditions(string $shippingConditions) : self
    {
        $this->initialized['shippingConditions'] = true;
        $this->shippingConditions = $shippingConditions;
        return $this;
    }
    /**
     * Permit number. Very rarely needed. Mostly relevant for higher value goods. An example use case would be an item made from crocodile leather which requires dedicated license / permit identified by that number.
     *
     * @return string
     */
    public function getPermitNo() : string
    {
        return $this->permitNo;
    }
    /**
     * Permit number. Very rarely needed. Mostly relevant for higher value goods. An example use case would be an item made from crocodile leather which requires dedicated license / permit identified by that number.
     *
     * @param string $permitNo
     *
     * @return self
     */
    public function setPermitNo(string $permitNo) : self
    {
        $this->initialized['permitNo'] = true;
        $this->permitNo = $permitNo;
        return $this;
    }
    /**
     * Attest or certification identified by this number. Very rarely needed. An example use case would be a medical shipment referring to an attestation that a certain amount of medicine may be imported within e.g. the current quarter of the year.
     *
     * @return string
     */
    public function getAttestationNo() : string
    {
        return $this->attestationNo;
    }
    /**
     * Attest or certification identified by this number. Very rarely needed. An example use case would be a medical shipment referring to an attestation that a certain amount of medicine may be imported within e.g. the current quarter of the year.
     *
     * @param string $attestationNo
     *
     * @return self
     */
    public function setAttestationNo(string $attestationNo) : self
    {
        $this->initialized['attestationNo'] = true;
        $this->attestationNo = $attestationNo;
        return $this;
    }
    /**
     * flag confirming whether electronic record for export was made
     *
     * @return bool
     */
    public function getHasElectronicExportNotification() : bool
    {
        return $this->hasElectronicExportNotification;
    }
    /**
     * flag confirming whether electronic record for export was made
     *
     * @param bool $hasElectronicExportNotification
     *
     * @return self
     */
    public function setHasElectronicExportNotification(bool $hasElectronicExportNotification) : self
    {
        $this->initialized['hasElectronicExportNotification'] = true;
        $this->hasElectronicExportNotification = $hasElectronicExportNotification;
        return $this;
    }
    /**
     * Currency and numeric value.
     *
     * @return Value
     */
    public function getPostalCharges() : Value
    {
        return $this->postalCharges;
    }
    /**
     * Currency and numeric value.
     *
     * @param Value $postalCharges
     *
     * @return self
     */
    public function setPostalCharges(Value $postalCharges) : self
    {
        $this->initialized['postalCharges'] = true;
        $this->postalCharges = $postalCharges;
        return $this;
    }
    /**
     * Optional. Will appear on CN23.
     *
     * @return string
     */
    public function getOfficeOfOrigin() : string
    {
        return $this->officeOfOrigin;
    }
    /**
     * Optional. Will appear on CN23.
     *
     * @param string $officeOfOrigin
     *
     * @return self
     */
    public function setOfficeOfOrigin(string $officeOfOrigin) : self
    {
        $this->initialized['officeOfOrigin'] = true;
        $this->officeOfOrigin = $officeOfOrigin;
        return $this;
    }
    /**
     * Commodity types in that package
     *
     * @return Commodity[]
     */
    public function getItems() : array
    {
        return $this->items;
    }
    /**
     * Commodity types in that package
     *
     * @param Commodity[] $items
     *
     * @return self
     */
    public function setItems(array $items) : self
    {
        $this->initialized['items'] = true;
        $this->items = $items;
        return $this;
    }
}