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
     * 
     *
     * @var string
     */
    protected $mRN;
    /**
     * Postal charges that have been charged to the recipient. The information must match the information on the invoice. Postal charges are added to the customs value which is the basis for the calculation of import duties. Since 1.1.2021 this information is mandatory according to requirements of the Universal Postal Union. The currency of the postal charges is used throughout the customs declaration form. The currency details of the individual goods items and the currency of the postal charges must match. Otherwise no shipping label will be created.
     *
     * @var CustomsDetailsPostalCharges
     */
    protected $postalCharges;
    /**
     * Deprecated (do not use anymore). Will appear on CN23.
     *
     * @var string
     */
    protected $officeOfOrigin;
    /**
     * Optional. The customs reference is used by customs authorities to identify economics operators an/or other persons involved. With the given reference, granted authorizations and/or relevant processes in customs clearance an/or taxation can be taken into account. Aka Zoll-Nummer or EORI-Number but dependent on destination.
     *
     * @var string
     */
    protected $shipperCustomsRef;
    /**
     * Optional. The customs reference is used by customs authorities to identify economics operators an/or other persons involved. With the given reference, granted authorizations and/or relevant processes in customs clearance an/or taxation can be taken into account. Aka Zoll-Nummer or EORI-Number but dependent on destination.
     *
     * @var string
     */
    protected $consigneeCustomsRef;
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
     * 
     *
     * @return string
     */
    public function getMRN() : string
    {
        return $this->mRN;
    }
    /**
     * 
     *
     * @param string $mRN
     *
     * @return self
     */
    public function setMRN(string $mRN) : self
    {
        $this->initialized['mRN'] = true;
        $this->mRN = $mRN;
        return $this;
    }
    /**
     * Postal charges that have been charged to the recipient. The information must match the information on the invoice. Postal charges are added to the customs value which is the basis for the calculation of import duties. Since 1.1.2021 this information is mandatory according to requirements of the Universal Postal Union. The currency of the postal charges is used throughout the customs declaration form. The currency details of the individual goods items and the currency of the postal charges must match. Otherwise no shipping label will be created.
     *
     * @return CustomsDetailsPostalCharges
     */
    public function getPostalCharges() : CustomsDetailsPostalCharges
    {
        return $this->postalCharges;
    }
    /**
     * Postal charges that have been charged to the recipient. The information must match the information on the invoice. Postal charges are added to the customs value which is the basis for the calculation of import duties. Since 1.1.2021 this information is mandatory according to requirements of the Universal Postal Union. The currency of the postal charges is used throughout the customs declaration form. The currency details of the individual goods items and the currency of the postal charges must match. Otherwise no shipping label will be created.
     *
     * @param CustomsDetailsPostalCharges $postalCharges
     *
     * @return self
     */
    public function setPostalCharges(CustomsDetailsPostalCharges $postalCharges) : self
    {
        $this->initialized['postalCharges'] = true;
        $this->postalCharges = $postalCharges;
        return $this;
    }
    /**
     * Deprecated (do not use anymore). Will appear on CN23.
     *
     * @return string
     */
    public function getOfficeOfOrigin() : string
    {
        return $this->officeOfOrigin;
    }
    /**
     * Deprecated (do not use anymore). Will appear on CN23.
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
     * Optional. The customs reference is used by customs authorities to identify economics operators an/or other persons involved. With the given reference, granted authorizations and/or relevant processes in customs clearance an/or taxation can be taken into account. Aka Zoll-Nummer or EORI-Number but dependent on destination.
     *
     * @return string
     */
    public function getShipperCustomsRef() : string
    {
        return $this->shipperCustomsRef;
    }
    /**
     * Optional. The customs reference is used by customs authorities to identify economics operators an/or other persons involved. With the given reference, granted authorizations and/or relevant processes in customs clearance an/or taxation can be taken into account. Aka Zoll-Nummer or EORI-Number but dependent on destination.
     *
     * @param string $shipperCustomsRef
     *
     * @return self
     */
    public function setShipperCustomsRef(string $shipperCustomsRef) : self
    {
        $this->initialized['shipperCustomsRef'] = true;
        $this->shipperCustomsRef = $shipperCustomsRef;
        return $this;
    }
    /**
     * Optional. The customs reference is used by customs authorities to identify economics operators an/or other persons involved. With the given reference, granted authorizations and/or relevant processes in customs clearance an/or taxation can be taken into account. Aka Zoll-Nummer or EORI-Number but dependent on destination.
     *
     * @return string
     */
    public function getConsigneeCustomsRef() : string
    {
        return $this->consigneeCustomsRef;
    }
    /**
     * Optional. The customs reference is used by customs authorities to identify economics operators an/or other persons involved. With the given reference, granted authorizations and/or relevant processes in customs clearance an/or taxation can be taken into account. Aka Zoll-Nummer or EORI-Number but dependent on destination.
     *
     * @param string $consigneeCustomsRef
     *
     * @return self
     */
    public function setConsigneeCustomsRef(string $consigneeCustomsRef) : self
    {
        $this->initialized['consigneeCustomsRef'] = true;
        $this->consigneeCustomsRef = $consigneeCustomsRef;
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