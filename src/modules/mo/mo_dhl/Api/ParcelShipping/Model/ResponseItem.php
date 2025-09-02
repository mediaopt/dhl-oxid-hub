<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class ResponseItem extends \ArrayObject
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
     * 
     *
     * @var string
     */
    protected $shipmentNo;
    /**
     * Routing code of the consignee address
     *
     * @var string
     */
    protected $routingCode;
    /**
     * Routing code of the return address
     *
     * @var string
     */
    protected $returnRoutingCode;
    /**
     * 
     *
     * @var string
     */
    protected $returnShipmentNo;
    /**
     * General status description for the attached response or response item.
     *
     * @var RequestStatus
     */
    protected $sstatus;
    /**
     * 
     *
     * @var string
     */
    protected $shipmentRefNo;
    /**
     * Encoded document. All types of labels and documents.
     *
     * @var Document
     */
    protected $label;
    /**
     * Encoded document. All types of labels and documents.
     *
     * @var Document
     */
    protected $returnLabel;
    /**
     * Encoded document. All types of labels and documents.
     *
     * @var Document
     */
    protected $customsDoc;
    /**
     * Encoded document. All types of labels and documents.
     *
     * @var Document
     */
    protected $codLabel;
    /**
     * Optional validation messages attached to the shipment.
     *
     * @var ValidationMessageItem[]
     */
    protected $validationMessages;
    /**
     * 
     *
     * @return string
     */
    public function getShipmentNo() : string
    {
        return $this->shipmentNo;
    }
    /**
     * 
     *
     * @param string $shipmentNo
     *
     * @return self
     */
    public function setShipmentNo(string $shipmentNo) : self
    {
        $this->initialized['shipmentNo'] = true;
        $this->shipmentNo = $shipmentNo;
        return $this;
    }
    /**
     * Routing code of the consignee address
     *
     * @return string
     */
    public function getRoutingCode() : string
    {
        return $this->routingCode;
    }
    /**
     * Routing code of the consignee address
     *
     * @param string $routingCode
     *
     * @return self
     */
    public function setRoutingCode(string $routingCode) : self
    {
        $this->initialized['routingCode'] = true;
        $this->routingCode = $routingCode;
        return $this;
    }
    /**
     * Routing code of the return address
     *
     * @return string
     */
    public function getReturnRoutingCode() : string
    {
        return $this->returnRoutingCode;
    }
    /**
     * Routing code of the return address
     *
     * @param string $returnRoutingCode
     *
     * @return self
     */
    public function setReturnRoutingCode(string $returnRoutingCode) : self
    {
        $this->initialized['returnRoutingCode'] = true;
        $this->returnRoutingCode = $returnRoutingCode;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getReturnShipmentNo() : string
    {
        return $this->returnShipmentNo;
    }
    /**
     * 
     *
     * @param string $returnShipmentNo
     *
     * @return self
     */
    public function setReturnShipmentNo(string $returnShipmentNo) : self
    {
        $this->initialized['returnShipmentNo'] = true;
        $this->returnShipmentNo = $returnShipmentNo;
        return $this;
    }
    /**
     * General status description for the attached response or response item.
     *
     * @return RequestStatus
     */
    public function getSstatus() : RequestStatus
    {
        return $this->sstatus;
    }
    /**
     * General status description for the attached response or response item.
     *
     * @param RequestStatus $sstatus
     *
     * @return self
     */
    public function setSstatus(RequestStatus $sstatus) : self
    {
        $this->initialized['sstatus'] = true;
        $this->sstatus = $sstatus;
        return $this;
    }
    /**
     * 
     *
     * @return string
     */
    public function getShipmentRefNo() : string
    {
        return $this->shipmentRefNo;
    }
    /**
     * 
     *
     * @param string $shipmentRefNo
     *
     * @return self
     */
    public function setShipmentRefNo(string $shipmentRefNo) : self
    {
        $this->initialized['shipmentRefNo'] = true;
        $this->shipmentRefNo = $shipmentRefNo;
        return $this;
    }
    /**
     * Encoded document. All types of labels and documents.
     *
     * @return Document
     */
    public function getLabel() : Document
    {
        return $this->label;
    }
    /**
     * Encoded document. All types of labels and documents.
     *
     * @param Document $label
     *
     * @return self
     */
    public function setLabel(Document $label) : self
    {
        $this->initialized['label'] = true;
        $this->label = $label;
        return $this;
    }
    /**
     * Encoded document. All types of labels and documents.
     *
     * @return Document
     */
    public function getReturnLabel() : Document
    {
        return $this->returnLabel;
    }
    /**
     * Encoded document. All types of labels and documents.
     *
     * @param Document $returnLabel
     *
     * @return self
     */
    public function setReturnLabel(Document $returnLabel) : self
    {
        $this->initialized['returnLabel'] = true;
        $this->returnLabel = $returnLabel;
        return $this;
    }
    /**
     * Encoded document. All types of labels and documents.
     *
     * @return Document
     */
    public function getCustomsDoc() : Document
    {
        return $this->customsDoc;
    }
    /**
     * Encoded document. All types of labels and documents.
     *
     * @param Document $customsDoc
     *
     * @return self
     */
    public function setCustomsDoc(Document $customsDoc) : self
    {
        $this->initialized['customsDoc'] = true;
        $this->customsDoc = $customsDoc;
        return $this;
    }
    /**
     * Encoded document. All types of labels and documents.
     *
     * @return Document
     */
    public function getCodLabel() : Document
    {
        return $this->codLabel;
    }
    /**
     * Encoded document. All types of labels and documents.
     *
     * @param Document $codLabel
     *
     * @return self
     */
    public function setCodLabel(Document $codLabel) : self
    {
        $this->initialized['codLabel'] = true;
        $this->codLabel = $codLabel;
        return $this;
    }
    /**
     * Optional validation messages attached to the shipment.
     *
     * @return ValidationMessageItem[]
     */
    public function getValidationMessages() : array
    {
        return $this->validationMessages;
    }
    /**
     * Optional validation messages attached to the shipment.
     *
     * @param ValidationMessageItem[] $validationMessages
     *
     * @return self
     */
    public function setValidationMessages(array $validationMessages) : self
    {
        $this->initialized['validationMessages'] = true;
        $this->validationMessages = $validationMessages;
        return $this;
    }
}