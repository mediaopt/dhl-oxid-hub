<?php

namespace Mediaopt\DHL\Api\GKV;

class ShipmentDetailsTypeType extends ShipmentDetailsType
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
     * @param string           $product
     * @param string    $accountNumber
     * @param string     $shipmentDate
     * @param ShipmentItemType $ShipmentItem
     */
    public function __construct($product, $accountNumber, $shipmentDate, $ShipmentItem)
    {
        parent::__construct($product, $accountNumber, $shipmentDate);
        $this->ShipmentItem = $ShipmentItem;
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
     * @return ShipmentDetailsTypeType
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
     * @return ShipmentDetailsTypeType
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
     * @return ShipmentDetailsTypeType
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
     * @return ShipmentDetailsTypeType
     */
    public function setBankData($BankData)
    {
        $this->BankData = $BankData;
        return $this;
    }

}
