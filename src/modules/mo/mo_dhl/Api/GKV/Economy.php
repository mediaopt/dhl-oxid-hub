<?php

namespace Mediaopt\DHL\Api\GKV;

class Economy
{

    /**
     * @var bool $active
     */
    protected $active = null;

    /**
     * @param bool $active
     */
    public function __construct($active)
    {
        $this->active = $active;
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
     * @return Economy
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

}
