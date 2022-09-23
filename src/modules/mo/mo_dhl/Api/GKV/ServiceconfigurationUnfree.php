<?php

namespace Mediaopt\DHL\Api\GKV;

class ServiceconfigurationUnfree
{

    /**
     * @var bool $active
     */
    protected $active = null;

    /**
     * @var string $PaymentType
     */
    protected $PaymentType = null;

    /**
     * @var string $CustomerNumber
     */
    protected $CustomerNumber = null;

    /**
     * @param bool $active
     * @param string $PaymentType
     * @param string $CustomerNumber
     */
    public function __construct($active, $PaymentType, $CustomerNumber)
    {
        $this->active = $active;
        $this->PaymentType = $PaymentType;
        $this->CustomerNumber = $CustomerNumber;
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
     * @return ServiceconfigurationUnfree
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->PaymentType;
    }

    /**
     * @param string $PaymentType
     * @return ServiceconfigurationUnfree
     */
    public function setPaymentType($PaymentType)
    {
        $this->PaymentType = $PaymentType;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerNumber()
    {
        return $this->CustomerNumber;
    }

    /**
     * @param string $CustomerNumber
     * @return ServiceconfigurationUnfree
     */
    public function setCustomerNumber($CustomerNumber)
    {
        $this->CustomerNumber = $CustomerNumber;
        return $this;
    }

}
