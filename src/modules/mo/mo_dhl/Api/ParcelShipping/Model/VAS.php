<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class VAS extends \ArrayObject
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
     * Preferred neighbour. Can be specified as text.
     *
     * @var string
     */
    protected $preferredNeighbour;
    /**
     * Preferred location. Can be specified as text.
     *
     * @var string
     */
    protected $preferredLocation;
    /**
     * An email notification to the recipient that is sent at the time the sipment is closed. It can be send to multiple emails. A custom email template can be referenced, this must be set up first and managed via the business customer portal. This service is about to be deprecated. Please use DHL Parcel Notification instead. To use the DHL Parcel Notification you enter the e-mail address of the consignee in the section of the consignee. The notification will be sent automatically.
     *
     * @var ShippingConfirmation
     */
    protected $shippingConfirmation;
    /**
     * if used it will trigger checking the age of recipient
     *
     * @var string
     */
    protected $visualCheckOfAge;
    /**
     * Delivery can only be signed for by yourself personally.
     *
     * @var bool
     */
    protected $namedPersonOnly;
    /**
     * Check the identity of the recipient. name (Firstname, lastname), dob or age. This uses firstName and lastName as separate attributes since for identity check an automatic split of a one-line name is not considered reliable enough.
     *
     * @var VASIdentCheck
     */
    protected $identCheck;
    /**
     * Instructions and endorsement how to treat international undeliverable shipment. By default, shipments are returned if undeliverable. There are country specific rules whether the shipment is returned immediately or after a grace period.
     *
     * @var string
     */
    protected $endorsement;
    /**
     * Preferred day of delivery in format YYYY-MM-DD. Shipper can request a preferred day of delivery. The preferred day should be between 2 and 6 working days after handover to DHL.
     *
     * @var \DateTime
     */
    protected $preferredDay;
    /**
     * Delivery can only be signed for by yourself personally or by members of your household.
     *
     * @var bool
     */
    protected $noNeighbourDelivery;
    /**
     * Currency and numeric value.
     *
     * @var Value
     */
    protected $additionalInsurance;
    /**
     * Leaving this out is same as setting to false. Sperrgut.
     *
     * @var bool
     */
    protected $bulkyGoods;
    /**
     * Cash on delivery (Nachnahme). Currency must be Euro. Either bank account information or account reference (from customer profile) must be provided. Transfernote1 + 2 are references transmitted during bank transfer. Providing account information explicitly requires elevated privileges.
     *
     * @var VASCashOnDelivery
     */
    protected $cashOnDelivery;
    /**
     * Special instructions for delivery. 2 character code, possible values agreed in contract.
     *
     * @var string
     */
    protected $individualSenderRequirement;
    /**
     * Choice of premium vs economy parcel. Availability is country dependent and may be manipulated by DHL if choice is not available. Please review the label. 
     *
     * @var bool
     */
    protected $premium;
    /**
     * Requires also DHL Retoure to be set
     *
     * @var bool
     */
    protected $packagingReturn;
    /**
     * Undeliverable domestic shipment can be forwarded and held at retail. Notification to email (fallback: consignee email) will be used.
     *
     * @var string
     */
    protected $parcelOutletRouting;
    /**
     * Requests return label (aka 'retoure') to be provided. Also requires returnAddress and return billing number. Neither weight nor dimension need to be specified for the retoure (flat rate service).
     *
     * @var VASDhlRetoure
     */
    protected $dhlRetoure;
    /**
     * 
     *
     * @var bool
     */
    protected $postalDeliveryDutyPaid;
    /**
     * Preferred neighbour. Can be specified as text.
     *
     * @return string
     */
    public function getPreferredNeighbour() : string
    {
        return $this->preferredNeighbour;
    }
    /**
     * Preferred neighbour. Can be specified as text.
     *
     * @param string $preferredNeighbour
     *
     * @return self
     */
    public function setPreferredNeighbour(string $preferredNeighbour) : self
    {
        $this->initialized['preferredNeighbour'] = true;
        $this->preferredNeighbour = $preferredNeighbour;
        return $this;
    }
    /**
     * Preferred location. Can be specified as text.
     *
     * @return string
     */
    public function getPreferredLocation() : string
    {
        return $this->preferredLocation;
    }
    /**
     * Preferred location. Can be specified as text.
     *
     * @param string $preferredLocation
     *
     * @return self
     */
    public function setPreferredLocation(string $preferredLocation) : self
    {
        $this->initialized['preferredLocation'] = true;
        $this->preferredLocation = $preferredLocation;
        return $this;
    }
    /**
     * An email notification to the recipient that is sent at the time the sipment is closed. It can be send to multiple emails. A custom email template can be referenced, this must be set up first and managed via the business customer portal. This service is about to be deprecated. Please use DHL Parcel Notification instead. To use the DHL Parcel Notification you enter the e-mail address of the consignee in the section of the consignee. The notification will be sent automatically.
     *
     * @return ShippingConfirmation
     */
    public function getShippingConfirmation() : ShippingConfirmation
    {
        return $this->shippingConfirmation;
    }
    /**
     * An email notification to the recipient that is sent at the time the sipment is closed. It can be send to multiple emails. A custom email template can be referenced, this must be set up first and managed via the business customer portal. This service is about to be deprecated. Please use DHL Parcel Notification instead. To use the DHL Parcel Notification you enter the e-mail address of the consignee in the section of the consignee. The notification will be sent automatically.
     *
     * @param ShippingConfirmation $shippingConfirmation
     *
     * @return self
     */
    public function setShippingConfirmation(ShippingConfirmation $shippingConfirmation) : self
    {
        $this->initialized['shippingConfirmation'] = true;
        $this->shippingConfirmation = $shippingConfirmation;
        return $this;
    }
    /**
     * if used it will trigger checking the age of recipient
     *
     * @return string
     */
    public function getVisualCheckOfAge() : string
    {
        return $this->visualCheckOfAge;
    }
    /**
     * if used it will trigger checking the age of recipient
     *
     * @param string $visualCheckOfAge
     *
     * @return self
     */
    public function setVisualCheckOfAge(string $visualCheckOfAge) : self
    {
        $this->initialized['visualCheckOfAge'] = true;
        $this->visualCheckOfAge = $visualCheckOfAge;
        return $this;
    }
    /**
     * Delivery can only be signed for by yourself personally.
     *
     * @return bool
     */
    public function getNamedPersonOnly() : bool
    {
        return $this->namedPersonOnly;
    }
    /**
     * Delivery can only be signed for by yourself personally.
     *
     * @param bool $namedPersonOnly
     *
     * @return self
     */
    public function setNamedPersonOnly(bool $namedPersonOnly) : self
    {
        $this->initialized['namedPersonOnly'] = true;
        $this->namedPersonOnly = $namedPersonOnly;
        return $this;
    }
    /**
     * Check the identity of the recipient. name (Firstname, lastname), dob or age. This uses firstName and lastName as separate attributes since for identity check an automatic split of a one-line name is not considered reliable enough.
     *
     * @return VASIdentCheck
     */
    public function getIdentCheck() : VASIdentCheck
    {
        return $this->identCheck;
    }
    /**
     * Check the identity of the recipient. name (Firstname, lastname), dob or age. This uses firstName and lastName as separate attributes since for identity check an automatic split of a one-line name is not considered reliable enough.
     *
     * @param VASIdentCheck $identCheck
     *
     * @return self
     */
    public function setIdentCheck(VASIdentCheck $identCheck) : self
    {
        $this->initialized['identCheck'] = true;
        $this->identCheck = $identCheck;
        return $this;
    }
    /**
     * Instructions and endorsement how to treat international undeliverable shipment. By default, shipments are returned if undeliverable. There are country specific rules whether the shipment is returned immediately or after a grace period.
     *
     * @return string
     */
    public function getEndorsement() : string
    {
        return $this->endorsement;
    }
    /**
     * Instructions and endorsement how to treat international undeliverable shipment. By default, shipments are returned if undeliverable. There are country specific rules whether the shipment is returned immediately or after a grace period.
     *
     * @param string $endorsement
     *
     * @return self
     */
    public function setEndorsement(string $endorsement) : self
    {
        $this->initialized['endorsement'] = true;
        $this->endorsement = $endorsement;
        return $this;
    }
    /**
     * Preferred day of delivery in format YYYY-MM-DD. Shipper can request a preferred day of delivery. The preferred day should be between 2 and 6 working days after handover to DHL.
     *
     * @return \DateTime
     */
    public function getPreferredDay() : \DateTime
    {
        return $this->preferredDay;
    }
    /**
     * Preferred day of delivery in format YYYY-MM-DD. Shipper can request a preferred day of delivery. The preferred day should be between 2 and 6 working days after handover to DHL.
     *
     * @param \DateTime $preferredDay
     *
     * @return self
     */
    public function setPreferredDay(\DateTime $preferredDay) : self
    {
        $this->initialized['preferredDay'] = true;
        $this->preferredDay = $preferredDay;
        return $this;
    }
    /**
     * Delivery can only be signed for by yourself personally or by members of your household.
     *
     * @return bool
     */
    public function getNoNeighbourDelivery() : bool
    {
        return $this->noNeighbourDelivery;
    }
    /**
     * Delivery can only be signed for by yourself personally or by members of your household.
     *
     * @param bool $noNeighbourDelivery
     *
     * @return self
     */
    public function setNoNeighbourDelivery(bool $noNeighbourDelivery) : self
    {
        $this->initialized['noNeighbourDelivery'] = true;
        $this->noNeighbourDelivery = $noNeighbourDelivery;
        return $this;
    }
    /**
     * Currency and numeric value.
     *
     * @return Value
     */
    public function getAdditionalInsurance() : Value
    {
        return $this->additionalInsurance;
    }
    /**
     * Currency and numeric value.
     *
     * @param Value $additionalInsurance
     *
     * @return self
     */
    public function setAdditionalInsurance(Value $additionalInsurance) : self
    {
        $this->initialized['additionalInsurance'] = true;
        $this->additionalInsurance = $additionalInsurance;
        return $this;
    }
    /**
     * Leaving this out is same as setting to false. Sperrgut.
     *
     * @return bool
     */
    public function getBulkyGoods() : bool
    {
        return $this->bulkyGoods;
    }
    /**
     * Leaving this out is same as setting to false. Sperrgut.
     *
     * @param bool $bulkyGoods
     *
     * @return self
     */
    public function setBulkyGoods(bool $bulkyGoods) : self
    {
        $this->initialized['bulkyGoods'] = true;
        $this->bulkyGoods = $bulkyGoods;
        return $this;
    }
    /**
     * Cash on delivery (Nachnahme). Currency must be Euro. Either bank account information or account reference (from customer profile) must be provided. Transfernote1 + 2 are references transmitted during bank transfer. Providing account information explicitly requires elevated privileges.
     *
     * @return VASCashOnDelivery
     */
    public function getCashOnDelivery() : VASCashOnDelivery
    {
        return $this->cashOnDelivery;
    }
    /**
     * Cash on delivery (Nachnahme). Currency must be Euro. Either bank account information or account reference (from customer profile) must be provided. Transfernote1 + 2 are references transmitted during bank transfer. Providing account information explicitly requires elevated privileges.
     *
     * @param VASCashOnDelivery $cashOnDelivery
     *
     * @return self
     */
    public function setCashOnDelivery(VASCashOnDelivery $cashOnDelivery) : self
    {
        $this->initialized['cashOnDelivery'] = true;
        $this->cashOnDelivery = $cashOnDelivery;
        return $this;
    }
    /**
     * Special instructions for delivery. 2 character code, possible values agreed in contract.
     *
     * @return string
     */
    public function getIndividualSenderRequirement() : string
    {
        return $this->individualSenderRequirement;
    }
    /**
     * Special instructions for delivery. 2 character code, possible values agreed in contract.
     *
     * @param string $individualSenderRequirement
     *
     * @return self
     */
    public function setIndividualSenderRequirement(string $individualSenderRequirement) : self
    {
        $this->initialized['individualSenderRequirement'] = true;
        $this->individualSenderRequirement = $individualSenderRequirement;
        return $this;
    }
    /**
     * Choice of premium vs economy parcel. Availability is country dependent and may be manipulated by DHL if choice is not available. Please review the label. 
     *
     * @return bool
     */
    public function getPremium() : bool
    {
        return $this->premium;
    }
    /**
     * Choice of premium vs economy parcel. Availability is country dependent and may be manipulated by DHL if choice is not available. Please review the label. 
     *
     * @param bool $premium
     *
     * @return self
     */
    public function setPremium(bool $premium) : self
    {
        $this->initialized['premium'] = true;
        $this->premium = $premium;
        return $this;
    }
    /**
     * Requires also DHL Retoure to be set
     *
     * @return bool
     */
    public function getPackagingReturn() : bool
    {
        return $this->packagingReturn;
    }
    /**
     * Requires also DHL Retoure to be set
     *
     * @param bool $packagingReturn
     *
     * @return self
     */
    public function setPackagingReturn(bool $packagingReturn) : self
    {
        $this->initialized['packagingReturn'] = true;
        $this->packagingReturn = $packagingReturn;
        return $this;
    }
    /**
     * Undeliverable domestic shipment can be forwarded and held at retail. Notification to email (fallback: consignee email) will be used.
     *
     * @return string
     */
    public function getParcelOutletRouting() : string
    {
        return $this->parcelOutletRouting;
    }
    /**
     * Undeliverable domestic shipment can be forwarded and held at retail. Notification to email (fallback: consignee email) will be used.
     *
     * @param string $parcelOutletRouting
     *
     * @return self
     */
    public function setParcelOutletRouting(string $parcelOutletRouting) : self
    {
        $this->initialized['parcelOutletRouting'] = true;
        $this->parcelOutletRouting = $parcelOutletRouting;
        return $this;
    }
    /**
     * Requests return label (aka 'retoure') to be provided. Also requires returnAddress and return billing number. Neither weight nor dimension need to be specified for the retoure (flat rate service).
     *
     * @return VASDhlRetoure
     */
    public function getDhlRetoure() : VASDhlRetoure
    {
        return $this->dhlRetoure;
    }
    /**
     * Requests return label (aka 'retoure') to be provided. Also requires returnAddress and return billing number. Neither weight nor dimension need to be specified for the retoure (flat rate service).
     *
     * @param VASDhlRetoure $dhlRetoure
     *
     * @return self
     */
    public function setDhlRetoure(VASDhlRetoure $dhlRetoure) : self
    {
        $this->initialized['dhlRetoure'] = true;
        $this->dhlRetoure = $dhlRetoure;
        return $this;
    }
    /**
     * 
     *
     * @return bool
     */
    public function getPostalDeliveryDutyPaid() : bool
    {
        return $this->postalDeliveryDutyPaid;
    }
    /**
     * 
     *
     * @param bool $postalDeliveryDutyPaid
     *
     * @return self
     */
    public function setPostalDeliveryDutyPaid(bool $postalDeliveryDutyPaid) : self
    {
        $this->initialized['postalDeliveryDutyPaid'] = true;
        $this->postalDeliveryDutyPaid = $postalDeliveryDutyPaid;
        return $this;
    }
}