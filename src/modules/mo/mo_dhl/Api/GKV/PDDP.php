<?php

namespace Mediaopt\DHL\Api\GKV;

class PDDP
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
     * @return PDDP
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

}
