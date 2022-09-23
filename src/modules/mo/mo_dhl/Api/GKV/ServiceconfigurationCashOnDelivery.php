<?php

namespace Mediaopt\DHL\Api\GKV;

class ServiceconfigurationCashOnDelivery
{

    /**
     * @var bool $active
     */
    protected $active = null;

    /**
     * @var float $codAmount
     */
    protected $codAmount = null;

    /**
     * @param bool  $active
     * @param float $codAmount
     */
    public function __construct($active, $codAmount)
    {
        $this->active = $active;
        $this->codAmount = $codAmount;
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
     * @return ServiceconfigurationCashOnDelivery
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return float
     */
    public function getCodAmount()
    {
        return $this->codAmount;
    }

    /**
     * @param float $codAmount
     * @return ServiceconfigurationCashOnDelivery
     */
    public function setCodAmount($codAmount)
    {
        $this->codAmount = $codAmount;
        return $this;
    }

}
