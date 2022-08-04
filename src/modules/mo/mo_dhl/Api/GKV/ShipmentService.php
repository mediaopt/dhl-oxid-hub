<?php

namespace Mediaopt\DHL\Api\GKV;

class ShipmentService
{

    /**
     * @var ServiceconfigurationISR $IndividualSenderRequirement
     */
    protected $IndividualSenderRequirement = null;

    /**
     * @var Serviceconfiguration $PackagingReturn
     */
    protected $PackagingReturn = null;

    /**
     * @var ServiceconfigurationEndorsement $Endorsement
     */
    protected $Endorsement = null;

    /**
     * @var ServiceconfigurationVisualAgeCheck $VisualCheckOfAge
     */
    protected $VisualCheckOfAge = null;

    /**
     * @var ServiceconfigurationDetails $PreferredLocation
     */
    protected $PreferredLocation = null;

    /**
     * @var ServiceconfigurationDetails $PreferredNeighbour
     */
    protected $PreferredNeighbour = null;

    /**
     * @var ServiceconfigurationDetails $PreferredDay
     */
    protected $PreferredDay = null;

    /**
     * @var Serviceconfiguration $NoNeighbourDelivery
     */
    protected $NoNeighbourDelivery = null;

    /**
     * @var Serviceconfiguration $NamedPersonOnly
     */
    protected $NamedPersonOnly = null;

    /**
     * @var Serviceconfiguration $ReturnReceipt
     */
    protected $ReturnReceipt = null;

    /**
     * @var Serviceconfiguration $Premium
     */
    protected $Premium = null;

    /**
     * @var ServiceconfigurationCashOnDelivery $CashOnDelivery
     */
    protected $CashOnDelivery = null;

    /**
     * @var PDDP $PDDP
     */
    protected $PDDP = null;

    /**
     * @var ServiceconfigurationAdditionalInsurance $AdditionalInsurance
     */
    protected $AdditionalInsurance = null;

    /**
     * @var Serviceconfiguration $BulkyGoods
     */
    protected $BulkyGoods = null;

    /**
     * @var ServiceconfigurationIC $IdentCheck
     */
    protected $IdentCheck = null;

    /**
     * @var ServiceconfigurationDetailsOptional $ParcelOutletRouting
     */
    protected $ParcelOutletRouting = null;


    public function __construct()
    {

    }

    /**
     * @return ServiceconfigurationISR
     */
    public function getIndividualSenderRequirement()
    {
        return $this->IndividualSenderRequirement;
    }

    /**
     * @param ServiceconfigurationISR $IndividualSenderRequirement
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setIndividualSenderRequirement($IndividualSenderRequirement)
    {
        $this->IndividualSenderRequirement = $IndividualSenderRequirement;
        return $this;
    }

    /**
     * @return Serviceconfiguration
     */
    public function getPackagingReturn()
    {
        return $this->PackagingReturn;
    }

    /**
     * @param Serviceconfiguration $PackagingReturn
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setPackagingReturn($PackagingReturn)
    {
        $this->PackagingReturn = $PackagingReturn;
        return $this;
    }

    /**
     * @return ServiceconfigurationEndorsement
     */
    public function getEndorsement()
    {
        return $this->Endorsement;
    }

    /**
     * @param ServiceconfigurationEndorsement $Endorsement
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setEndorsement($Endorsement)
    {
        $this->Endorsement = $Endorsement;
        return $this;
    }

    /**
     * @return ServiceconfigurationVisualAgeCheck
     */
    public function getVisualCheckOfAge()
    {
        return $this->VisualCheckOfAge;
    }

    /**
     * @param ServiceconfigurationVisualAgeCheck $VisualCheckOfAge
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setVisualCheckOfAge($VisualCheckOfAge)
    {
        $this->VisualCheckOfAge = $VisualCheckOfAge;
        return $this;
    }

    /**
     * @return ServiceconfigurationDetails
     */
    public function getPreferredLocation()
    {
        return $this->PreferredLocation;
    }

    /**
     * @param ServiceconfigurationDetails $PreferredLocation
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setPreferredLocation($PreferredLocation)
    {
        $this->PreferredLocation = $PreferredLocation;
        return $this;
    }

    /**
     * @return ServiceconfigurationDetails
     */
    public function getPreferredNeighbour()
    {
        return $this->PreferredNeighbour;
    }

    /**
     * @param ServiceconfigurationDetails $PreferredNeighbour
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setPreferredNeighbour($PreferredNeighbour)
    {
        $this->PreferredNeighbour = $PreferredNeighbour;
        return $this;
    }

    /**
     * @return ServiceconfigurationDetails
     */
    public function getPreferredDay()
    {
        return $this->PreferredDay;
    }

    /**
     * @param ServiceconfigurationDetails $PreferredDay
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setPreferredDay($PreferredDay)
    {
        $this->PreferredDay = $PreferredDay;
        return $this;
    }

    /**
     * @return Serviceconfiguration
     */
    public function getNoNeighbourDelivery()
    {
        return $this->NoNeighbourDelivery;
    }

    /**
     * @param Serviceconfiguration $NoNeighbourDelivery
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setNoNeighbourDelivery($NoNeighbourDelivery)
    {
        $this->NoNeighbourDelivery = $NoNeighbourDelivery;
        return $this;
    }

    /**
     * @return Serviceconfiguration
     */
    public function getNamedPersonOnly()
    {
        return $this->NamedPersonOnly;
    }

    /**
     * @param Serviceconfiguration $NamedPersonOnly
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setNamedPersonOnly($NamedPersonOnly)
    {
        $this->NamedPersonOnly = $NamedPersonOnly;
        return $this;
    }

    /**
     * @return Serviceconfiguration
     */
    public function getReturnReceipt()
    {
        return $this->ReturnReceipt;
    }

    /**
     * @param Serviceconfiguration $ReturnReceipt
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setReturnReceipt($ReturnReceipt)
    {
        $this->ReturnReceipt = $ReturnReceipt;
        return $this;
    }

    /**
     * @return Serviceconfiguration
     */
    public function getPremium()
    {
        return $this->Premium;
    }

    /**
     * @param Serviceconfiguration $Premium
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setPremium($Premium)
    {
        $this->Premium = $Premium;
        return $this;
    }

    /**
     * @return ServiceconfigurationCashOnDelivery
     */
    public function getCashOnDelivery()
    {
        return $this->CashOnDelivery;
    }

    /**
     * @param ServiceconfigurationCashOnDelivery $CashOnDelivery
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setCashOnDelivery($CashOnDelivery)
    {
        $this->CashOnDelivery = $CashOnDelivery;
        return $this;
    }

    /**
     * @return PDDP
     */
    public function getPDDP()
    {
        return $this->PDDP;
    }

    /**
     * @param PDDP $PDDP
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setPDDP($PDDP)
    {
        $this->PDDP = $PDDP;
        return $this;
    }

    /**
     * @return ServiceconfigurationAdditionalInsurance
     */
    public function getAdditionalInsurance()
    {
        return $this->AdditionalInsurance;
    }

    /**
     * @param ServiceconfigurationAdditionalInsurance $AdditionalInsurance
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setAdditionalInsurance($AdditionalInsurance)
    {
        $this->AdditionalInsurance = $AdditionalInsurance;
        return $this;
    }

    /**
     * @return Serviceconfiguration
     */
    public function getBulkyGoods()
    {
        return $this->BulkyGoods;
    }

    /**
     * @param Serviceconfiguration $BulkyGoods
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setBulkyGoods($BulkyGoods)
    {
        $this->BulkyGoods = $BulkyGoods;
        return $this;
    }

    /**
     * @return ServiceconfigurationIC
     */
    public function getIdentCheck()
    {
        return $this->IdentCheck;
    }

    /**
     * @param ServiceconfigurationIC $IdentCheck
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setIdentCheck($IdentCheck)
    {
        $this->IdentCheck = $IdentCheck;
        return $this;
    }

    /**
     * @return ServiceconfigurationDetailsOptional
     */
    public function getParcelOutletRouting()
    {
        return $this->ParcelOutletRouting;
    }

    /**
     * @param ServiceconfigurationDetailsOptional $ParcelOutletRouting
     * @return \Mediaopt\DHL\Api\GKV\ShipmentService
     */
    public function setParcelOutletRouting($ParcelOutletRouting)
    {
        $this->ParcelOutletRouting = $ParcelOutletRouting;
        return $this;
    }

}
