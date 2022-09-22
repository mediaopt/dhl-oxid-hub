<?php

namespace Mediaopt\DHL\Api\GKV;

class ServiceconfigurationType
{

    /**
     * @var bool $active
     */
    protected $active = null;

    /**
     * @var string $Type
     */
    protected $Type = null;

    /**
     * @param bool $active
     * @param string $Type
     */
    public function __construct($active, $Type)
    {
        $this->active = $active;
        $this->Type = $Type;
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
     * @return ServiceconfigurationType
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * @param string $Type
     * @return ServiceconfigurationType
     */
    public function setType($Type)
    {
        $this->Type = $Type;
        return $this;
    }

}
