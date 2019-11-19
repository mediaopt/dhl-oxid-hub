<?php

namespace Mediaopt\DHL\Api\GKV;

class Shipment
{

    /**
     * @var ShipmentDetailsType $ShipmentDetails
     */
    protected $ShipmentDetails = null;

    /**
     * @var ShipperType $Shipper
     */
    protected $Shipper = null;

    /**
     * @var ReceiverType $Receiver
     */
    protected $Receiver = null;

    /**
     * @var ShipperType $ReturnReceiver
     */
    protected $ReturnReceiver = null;

    /**
     * @var ExportDocumentType $ExportDocument
     */
    protected $ExportDocument = null;

    /**
     * @param ShipmentDetailsType $ShipmentDetails
     * @param ShipperType         $Shipper
     * @param ReceiverType        $Receiver
     */
    public function __construct(ShipmentDetailsType $ShipmentDetails, ShipperType $Shipper, ReceiverType $Receiver)
    {
        $this->ShipmentDetails = $ShipmentDetails;
        $this->Shipper = $Shipper;
        $this->Receiver = $Receiver;
    }

    /**
     * @return ShipmentDetailsType
     */
    public function getShipmentDetails()
    {
        return $this->ShipmentDetails;
    }

    /**
     * @param ShipmentDetailsType $ShipmentDetails
     * @return Shipment
     */
    public function setShipmentDetails($ShipmentDetails)
    {
        $this->ShipmentDetails = $ShipmentDetails;
        return $this;
    }

    /**
     * @return ShipperType
     */
    public function getShipper()
    {
        return $this->Shipper;
    }

    /**
     * @param ShipperType $Shipper
     * @return Shipment
     */
    public function setShipper($Shipper)
    {
        $this->Shipper = $Shipper;
        return $this;
    }

    /**
     * @return ReceiverType
     */
    public function getReceiver()
    {
        return $this->Receiver;
    }

    /**
     * @param ReceiverType $Receiver
     * @return Shipment
     */
    public function setReceiver($Receiver)
    {
        $this->Receiver = $Receiver;
        return $this;
    }

    /**
     * @return ShipperType
     */
    public function getReturnReceiver()
    {
        return $this->ReturnReceiver;
    }

    /**
     * @param ShipperType $ReturnReceiver
     * @return Shipment
     */
    public function setReturnReceiver($ReturnReceiver)
    {
        $this->ReturnReceiver = $ReturnReceiver;
        return $this;
    }

    /**
     * @return ExportDocumentType
     */
    public function getExportDocument()
    {
        return $this->ExportDocument;
    }

    /**
     * @param ExportDocumentType $ExportDocument
     * @return Shipment
     */
    public function setExportDocument($ExportDocument)
    {
        $this->ExportDocument = $ExportDocument;
        return $this;
    }

}
