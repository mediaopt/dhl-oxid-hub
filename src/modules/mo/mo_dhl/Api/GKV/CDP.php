<?php

namespace Mediaopt\DHL\Api\GKV;

class CDP
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
     * @return CDP
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

}
