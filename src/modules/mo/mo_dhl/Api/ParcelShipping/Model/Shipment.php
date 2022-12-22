<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class Shipment extends \ArrayObject
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
    * Determines the DHL Paket product to be used.
    
    * V01PAK: DHL PAKET;
    * V53WPAK: DHL PAKET International;
    * V54EPAK: DHL Europaket;
    * V62WP: Warenpost;
    * V66WPI: Warenpost International
    *
    * @var string
    */
    protected $product;
    /**
     * 14 digit long number that identifies the contract the shipment is booked on. Please note that in rare cases the last to characters can be letters. Digit 11 and digit 12 must correspondent to the number of the product, e.g. 333333333301tt can only be used for the product V01PAK (DHL Paket).
     *
     * @var string
     */
    protected $billingNumber;
    /**
     * A reference number that the user can assign for better association purposes. It appears on shipment labels. To use the reference number for tracking purposes, it should be at least 8 characters long and unique.
     *
     * @var string
     */
    protected $refNo;
    /**
     * Textfield that appears on the shipment label. It cannot be used to search for the shipment.
     *
     * @var string
     */
    protected $costCenter;
    /**
     * Is only to be indicated by DHL partners.
     *
     * @var string
     */
    protected $creationSoftware;
    /**
     * Date the shipment is transferred to DHL. The shipment date can be the current date or a date up to a few days in the future. It must not be in the past. Iso format required: yyyy-mm-dd. On the shipment date the shipment will be automatically closed at your end of day closing time.
     *
     * @var \DateTime
     */
    protected $shipDate;
    /**
     * Shipper information, including contact information, address. Alternatively, a predefined shipper reference can be used.
     *
     * @var Shipper
     */
    protected $shipper;
    /**
     * Consignee address information. Either a doorstep address (contact address) including contact information or a droppoint address. One of packstation (parcel locker), or post office (postfiliale/retail shop). To use a German post office box (Postfach) please use contactAddress.
     *
     * @var mixed[]
     */
    protected $consignee;
    /**
     * Details for the shipment, such as dimensions, content
     *
     * @var ShipmentDetails
     */
    protected $details;
    /**
     * Value added services. Please note that services are specific to products and geographies and/or may require individual setup and billing numbers. Please test and contact your account representative in case of questions.
     *
     * @var VAS
     */
    protected $services;
    /**
     * For international shipments, this section contains information necessary for customs about the exported goods. ExportDocument can contain one or more positions as child element. This data is also transferred as electronic declaration to customs. The custom details are mandatory depending on whether the parcel will go to a country outside the European Customs Union. For DHL Parcel International (V53WPAK) CN23 will returned as a separate document, while for Warenpost International the customs information will be printed onto the shipment label (CN22).
     *
     * @var CustomsDetails
     */
    protected $customs;
    /**
    * Determines the DHL Paket product to be used.
    
    * V01PAK: DHL PAKET;
    * V53WPAK: DHL PAKET International;
    * V54EPAK: DHL Europaket;
    * V62WP: Warenpost;
    * V66WPI: Warenpost International
    *
    * @return string
    */
    public function getProduct() : string
    {
        return $this->product;
    }
    /**
    * Determines the DHL Paket product to be used.
    
    * V01PAK: DHL PAKET;
    * V53WPAK: DHL PAKET International;
    * V54EPAK: DHL Europaket;
    * V62WP: Warenpost;
    * V66WPI: Warenpost International
    *
    * @param string $product
    *
    * @return self
    */
    public function setProduct(string $product) : self
    {
        $this->initialized['product'] = true;
        $this->product = $product;
        return $this;
    }
    /**
     * 14 digit long number that identifies the contract the shipment is booked on. Please note that in rare cases the last to characters can be letters. Digit 11 and digit 12 must correspondent to the number of the product, e.g. 333333333301tt can only be used for the product V01PAK (DHL Paket).
     *
     * @return string
     */
    public function getBillingNumber() : string
    {
        return $this->billingNumber;
    }
    /**
     * 14 digit long number that identifies the contract the shipment is booked on. Please note that in rare cases the last to characters can be letters. Digit 11 and digit 12 must correspondent to the number of the product, e.g. 333333333301tt can only be used for the product V01PAK (DHL Paket).
     *
     * @param string $billingNumber
     *
     * @return self
     */
    public function setBillingNumber(string $billingNumber) : self
    {
        $this->initialized['billingNumber'] = true;
        $this->billingNumber = $billingNumber;
        return $this;
    }
    /**
     * A reference number that the user can assign for better association purposes. It appears on shipment labels. To use the reference number for tracking purposes, it should be at least 8 characters long and unique.
     *
     * @return string
     */
    public function getRefNo() : string
    {
        return $this->refNo;
    }
    /**
     * A reference number that the user can assign for better association purposes. It appears on shipment labels. To use the reference number for tracking purposes, it should be at least 8 characters long and unique.
     *
     * @param string $refNo
     *
     * @return self
     */
    public function setRefNo(string $refNo) : self
    {
        $this->initialized['refNo'] = true;
        $this->refNo = $refNo;
        return $this;
    }
    /**
     * Textfield that appears on the shipment label. It cannot be used to search for the shipment.
     *
     * @return string
     */
    public function getCostCenter() : string
    {
        return $this->costCenter;
    }
    /**
     * Textfield that appears on the shipment label. It cannot be used to search for the shipment.
     *
     * @param string $costCenter
     *
     * @return self
     */
    public function setCostCenter(string $costCenter) : self
    {
        $this->initialized['costCenter'] = true;
        $this->costCenter = $costCenter;
        return $this;
    }
    /**
     * Is only to be indicated by DHL partners.
     *
     * @return string
     */
    public function getCreationSoftware() : string
    {
        return $this->creationSoftware;
    }
    /**
     * Is only to be indicated by DHL partners.
     *
     * @param string $creationSoftware
     *
     * @return self
     */
    public function setCreationSoftware(string $creationSoftware) : self
    {
        $this->initialized['creationSoftware'] = true;
        $this->creationSoftware = $creationSoftware;
        return $this;
    }
    /**
     * Date the shipment is transferred to DHL. The shipment date can be the current date or a date up to a few days in the future. It must not be in the past. Iso format required: yyyy-mm-dd. On the shipment date the shipment will be automatically closed at your end of day closing time.
     *
     * @return \DateTime
     */
    public function getShipDate() : \DateTime
    {
        return $this->shipDate;
    }
    /**
     * Date the shipment is transferred to DHL. The shipment date can be the current date or a date up to a few days in the future. It must not be in the past. Iso format required: yyyy-mm-dd. On the shipment date the shipment will be automatically closed at your end of day closing time.
     *
     * @param \DateTime $shipDate
     *
     * @return self
     */
    public function setShipDate(\DateTime $shipDate) : self
    {
        $this->initialized['shipDate'] = true;
        $this->shipDate = $shipDate;
        return $this;
    }
    /**
     * Shipper information, including contact information, address. Alternatively, a predefined shipper reference can be used.
     *
     * @return Shipper
     */
    public function getShipper() : Shipper
    {
        return $this->shipper;
    }
    /**
     * Shipper information, including contact information, address. Alternatively, a predefined shipper reference can be used.
     *
     * @param Shipper $shipper
     *
     * @return self
     */
    public function setShipper(Shipper $shipper) : self
    {
        $this->initialized['shipper'] = true;
        $this->shipper = $shipper;
        return $this;
    }
    /**
     * Consignee address information. Either a doorstep address (contact address) including contact information or a droppoint address. One of packstation (parcel locker), or post office (postfiliale/retail shop). To use a German post office box (Postfach) please use contactAddress.
     *
     * @return mixed[]
     */
    public function getConsignee() : iterable
    {
        return $this->consignee;
    }
    /**
     * Consignee address information. Either a doorstep address (contact address) including contact information or a droppoint address. One of packstation (parcel locker), or post office (postfiliale/retail shop). To use a German post office box (Postfach) please use contactAddress.
     *
     * @param mixed[] $consignee
     *
     * @return self
     */
    public function setConsignee(iterable $consignee) : self
    {
        $this->initialized['consignee'] = true;
        $this->consignee = $consignee;
        return $this;
    }
    /**
     * Details for the shipment, such as dimensions, content
     *
     * @return ShipmentDetails
     */
    public function getDetails() : ShipmentDetails
    {
        return $this->details;
    }
    /**
     * Details for the shipment, such as dimensions, content
     *
     * @param ShipmentDetails $details
     *
     * @return self
     */
    public function setDetails(ShipmentDetails $details) : self
    {
        $this->initialized['details'] = true;
        $this->details = $details;
        return $this;
    }
    /**
     * Value added services. Please note that services are specific to products and geographies and/or may require individual setup and billing numbers. Please test and contact your account representative in case of questions.
     *
     * @return VAS
     */
    public function getServices() : VAS
    {
        return $this->services;
    }
    /**
     * Value added services. Please note that services are specific to products and geographies and/or may require individual setup and billing numbers. Please test and contact your account representative in case of questions.
     *
     * @param VAS $services
     *
     * @return self
     */
    public function setServices(VAS $services) : self
    {
        $this->initialized['services'] = true;
        $this->services = $services;
        return $this;
    }
    /**
     * For international shipments, this section contains information necessary for customs about the exported goods. ExportDocument can contain one or more positions as child element. This data is also transferred as electronic declaration to customs. The custom details are mandatory depending on whether the parcel will go to a country outside the European Customs Union. For DHL Parcel International (V53WPAK) CN23 will returned as a separate document, while for Warenpost International the customs information will be printed onto the shipment label (CN22).
     *
     * @return CustomsDetails
     */
    public function getCustoms() : CustomsDetails
    {
        return $this->customs;
    }
    /**
     * For international shipments, this section contains information necessary for customs about the exported goods. ExportDocument can contain one or more positions as child element. This data is also transferred as electronic declaration to customs. The custom details are mandatory depending on whether the parcel will go to a country outside the European Customs Union. For DHL Parcel International (V53WPAK) CN23 will returned as a separate document, while for Warenpost International the customs information will be printed onto the shipment label (CN22).
     *
     * @param CustomsDetails $customs
     *
     * @return self
     */
    public function setCustoms(CustomsDetails $customs) : self
    {
        $this->initialized['customs'] = true;
        $this->customs = $customs;
        return $this;
    }
}