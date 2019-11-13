<?php

namespace Mediaopt\DHL\Api\GKV;

class ServiceconfigurationCashOnDelivery
{

    /**
     * @var bool $active
     */
    protected $active = null;

    /**
     * @var bool $addFee
     */
    protected $addFee = null;

    /**
     * @var float $codAmount
     */
    protected $codAmount = null;

    /**
     * @param bool  $active
     * @param bool  $addFee
     * @param float $codAmount
     */
    public function __construct($active, $addFee, $codAmount)
    {
        $this->active = $active;
        $this->addFee = $addFee;
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
     * @return bool
     */
    public function getAddFee()
    {
        return $this->addFee;
    }

    /**
     * @param bool $addFee
     * @return ServiceconfigurationCashOnDelivery
     */
    public function setAddFee($addFee)
    {
        $this->addFee = $addFee;
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
