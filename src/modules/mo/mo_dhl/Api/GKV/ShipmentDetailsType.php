<?php

namespace Mediaopt\DHL\Api\GKV;

use Mediaopt\DHL\Shipment\BillingNumber;

class ShipmentDetailsType
{

    /**
     * @var ShipmentItemType $ShipmentItem
     */
    protected $ShipmentItem = null;

    /**
     * @var ShipmentService $Service
     */
    protected $Service = null;

    /**
     * @var ShipmentNotificationType $Notification
     */
    protected $Notification = null;

    /**
     * @var BankType $BankData
     */
    protected $BankData = null;

    /**
     * @var string $product
     */
    protected $product = null;

    /**
     * @var BillingNumber $accountNumber
     */
    protected $accountNumber = null;

    /**
     * @var string $customerReference
     */
    protected $customerReference = null;

    /**
     * @var string $shipmentDate
     */
    protected $shipmentDate = null;

    /**
     * @var string $costCentre
     */
    protected $costCentre = null;

    /**
     * @var string $returnShipmentAccountNumber
     */
    protected $returnShipmentAccountNumber = null;

    /**
     * @var string $returnShipmentReference
     */
    protected $returnShipmentReference = null;

    /**
     * @param string           $product
     * @param BillingNumber    $accountNumber
     * @param string           $shipmentDate
     * @param ShipmentItemType $ShipmentItem
     */
    public function __construct($product, $accountNumber, $shipmentDate, $ShipmentItem)
    {
        $this->product = $product;
        $this->accountNumber = $accountNumber;
        $this->shipmentDate = $shipmentDate;
        $this->ShipmentItem = $ShipmentItem;
    }

    /**
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param string $product
     * @return ShipmentDetailsType
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return BillingNumber
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @param BillingNumber $accountNumber
     * @return ShipmentDetailsType
     */
    public function setAccountNumber(BillingNumber $accountNumber)
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerReference()
    {
        return $this->customerReference;
    }

    /**
     * @param string $customerReference
     * @return ShipmentDetailsType
     */
    public function setCustomerReference($customerReference)
    {
        $this->customerReference = $customerReference;
        return $this;
    }

    /**
     * @return string
     */
    public function getShipmentDate()
    {
        return $this->shipmentDate;
    }

    /**
     * @param string $shipmentDate
     * @return ShipmentDetailsType
     */
    public function setShipmentDate($shipmentDate)
    {
        $this->shipmentDate = $shipmentDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getCostCentre()
    {
        return $this->costCentre;
    }

    /**
     * @param string $costCentre
     * @return ShipmentDetailsType
     */
    public function setCostCentre($costCentre)
    {
        $this->costCentre = $costCentre;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnShipmentAccountNumber()
    {
        return $this->returnShipmentAccountNumber;
    }

    /**
     * @param string $returnShipmentAccountNumber
     * @return ShipmentDetailsType
     */
    public function setReturnShipmentAccountNumber($returnShipmentAccountNumber)
    {
        $this->returnShipmentAccountNumber = $returnShipmentAccountNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnShipmentReference()
    {
        return $this->returnShipmentReference;
    }

    /**
     * @param string $returnShipmentReference
     * @return ShipmentDetailsType
     */
    public function setReturnShipmentReference($returnShipmentReference)
    {
        $this->returnShipmentReference = $returnShipmentReference;
        return $this;
    }

    /**
     * @return ShipmentItemType
     */
    public function getShipmentItem()
    {
        return $this->ShipmentItem;
    }

    /**
     * @param ShipmentItemType $ShipmentItem
     * @return \Mediaopt\DHL\Api\GKV\ShipmentDetailsType
     */
    public function setShipmentItem($ShipmentItem)
    {
        $this->ShipmentItem = $ShipmentItem;
        return $this;
    }

    /**
     * @return ShipmentService
     */
    public function getService()
    {
        return $this->Service;
    }

    /**
     * @param ShipmentService $Service
     * @return \Mediaopt\DHL\Api\GKV\ShipmentDetailsType
     */
    public function setService($Service)
    {
        $this->Service = $Service;
        return $this;
    }

    /**
     * @return ShipmentNotificationType
     */
    public function getNotification()
    {
        return $this->Notification;
    }

    /**
     * @param ShipmentNotificationType $Notification
     * @return \Mediaopt\DHL\Api\GKV\ShipmentDetailsType
     */
    public function setNotification($Notification)
    {
        $this->Notification = $Notification;
        return $this;
    }

    /**
     * @return BankType
     */
    public function getBankData()
    {
        return $this->BankData;
    }

    /**
     * @param BankType $BankData
     * @return \Mediaopt\DHL\Api\GKV\ShipmentDetailsType
     */
    public function setBankData($BankData)
    {
        $this->BankData = $BankData;
        return $this;
    }
}
