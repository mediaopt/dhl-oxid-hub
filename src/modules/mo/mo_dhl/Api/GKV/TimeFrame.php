<?php

namespace Mediaopt\DHL\Api\GKV;

class TimeFrame
{

    /**
     * @var string $from
     */
    protected $from = null;

    /**
     * @var string $until
     */
    protected $until = null;

    /**
     * @param string $from
     * @param string $until
     */
    public function __construct($from, $until)
    {
        $this->from = $from;
        $this->until = $until;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     * @return TimeFrame
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function getUntil()
    {
        return $this->until;
    }

    /**
     * @param string $until
     * @return TimeFrame
     */
    public function setUntil($until)
    {
        $this->until = $until;
        return $this;
    }

}
