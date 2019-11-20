<?php

namespace Mediaopt\DHL\Api\GKV;

class ServiceconfigurationAdditionalInsurance
{

    /**
     * @var bool $active
     */
    protected $active = null;

    /**
     * @var float $insuranceAmount
     */
    protected $insuranceAmount = null;

    /**
     * @param bool  $active
     * @param float $insuranceAmount
     */
    public function __construct($active, $insuranceAmount)
    {
        $this->active = $active;
        $this->insuranceAmount = $insuranceAmount;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return ServiceconfigurationAdditionalInsurance
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return float
     */
    public function getInsuranceAmount()
    {
        return $this->insuranceAmount;
    }

    /**
     * @param float $insuranceAmount
     * @return ServiceconfigurationAdditionalInsurance
     */
    public function setInsuranceAmount($insuranceAmount)
    {
        $this->insuranceAmount = $insuranceAmount;
        return $this;
    }

}
