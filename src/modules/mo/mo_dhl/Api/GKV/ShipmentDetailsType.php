<?php

namespace Mediaopt\DHL\Api\GKV;

class ShipmentDetailsType
{

    /**
     * @var string $product
     */
    protected $product = null;

    /**
     * @var string $accountNumber
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
     * @param string $product
     * @param string $accountNumber
     * @param string $shipmentDate
     */
    public function __construct(string $product, $accountNumber, $shipmentDate)
    {
        $this->product = $product;
        $this->accountNumber = $accountNumber;
        $this->shipmentDate = $shipmentDate;
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
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @param string $accountNumber
     * @return ShipmentDetailsType
     */
    public function setAccountNumber($accountNumber)
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

}
