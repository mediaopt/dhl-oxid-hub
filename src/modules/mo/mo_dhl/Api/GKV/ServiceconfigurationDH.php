<?php

namespace Mediaopt\DHL\Api\GKV;

class ServiceconfigurationDH
{

    /**
     * @var bool $active
     */
    protected $active = null;

    /**
     * @var string $Days
     */
    protected $Days = null;

    /**
     * @param bool $active
     * @param string $Days
     */
    public function __construct($active, $Days)
    {
        $this->active = $active;
        $this->Days = $Days;
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
     * @return ServiceconfigurationDH
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getDays()
    {
        return $this->Days;
    }

    /**
     * @param string $Days
     * @return ServiceconfigurationDH
     */
    public function setDays($Days)
    {
        $this->Days = $Days;
        return $this;
    }

}
