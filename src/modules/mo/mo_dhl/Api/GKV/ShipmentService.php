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
     * @var ServiceconfigurationDetailsPreferredLocation $PreferredLocation
     */
    protected $PreferredLocation = null;

    /**
     * @var ServiceconfigurationDetailsPreferredNeighbour $PreferredNeighbour
     */
    protected $PreferredNeighbour = null;

    /**
     * @var ServiceconfigurationDetailsPreferredDay $PreferredDay
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
     * @var CDP $CDP
     */
    protected $CDP = null;

    /**
     * @var Economy $Economy
     */
    protected $Economy = null;

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
     * @return ShipmentService
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
     * @return ShipmentService
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
     * @return ShipmentService
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
     * @return ShipmentService
     */
    public function setVisualCheckOfAge($VisualCheckOfAge)
    {
        $this->VisualCheckOfAge = $VisualCheckOfAge;
        return $this;
    }

    /**
     * @return ServiceconfigurationDetailsPreferredLocation
     */
    public function getPreferredLocation()
    {
        return $this->PreferredLocation;
    }

    /**
     * @param ServiceconfigurationDetailsPreferredLocation $PreferredLocation
     * @return ShipmentService
     */
    public function setPreferredLocation($PreferredLocation)
    {
        $this->PreferredLocation = $PreferredLocation;
        return $this;
    }

    /**
     * @return ServiceconfigurationDetailsPreferredNeighbour
     */
    public function getPreferredNeighbour()
    {
        return $this->PreferredNeighbour;
    }

    /**
     * @param ServiceconfigurationDetailsPreferredNeighbour $PreferredNeighbour
     * @return ShipmentService
     */
    public function setPreferredNeighbour($PreferredNeighbour)
    {
        $this->PreferredNeighbour = $PreferredNeighbour;
        return $this;
    }

    /**
     * @return ServiceconfigurationDetailsPreferredDay
     */
    public function getPreferredDay()
    {
        return $this->PreferredDay;
    }

    /**
     * @param ServiceconfigurationDetailsPreferredDay $PreferredDay
     * @return ShipmentService
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
     * @return ShipmentService
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
     * @return ShipmentService
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
     * @return ShipmentService
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
     * @return ShipmentService
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
     * @return ShipmentService
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
     * @return ShipmentService
     */
    public function setPDDP($PDDP)
    {
        $this->PDDP = $PDDP;
        return $this;
    }

    /**
     * @return CDP
     */
    public function getCDP()
    {
        return $this->CDP;
    }

    /**
     * @param CDP $CDP
     * @return ShipmentService
     */
    public function setCDP($CDP)
    {
        $this->CDP = $CDP;
        return $this;
    }

    /**
     * @return Economy
     */
    public function getEconomy()
    {
        return $this->Economy;
    }

    /**
     * @param Economy $Economy
     * @return ShipmentService
     */
    public function setEconomy($Economy)
    {
        $this->Economy = $Economy;
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
     * @return ShipmentService
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
     * @return ShipmentService
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
     * @return ShipmentService
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
     * @return ShipmentService
     */
    public function setParcelOutletRouting($ParcelOutletRouting)
    {
        $this->ParcelOutletRouting = $ParcelOutletRouting;
        return $this;
    }

}
