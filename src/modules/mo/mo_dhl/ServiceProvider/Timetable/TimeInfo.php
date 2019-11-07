<?php

namespace Mediaopt\DHL\ServiceProvider\Timetable;

/**
 * This class represents the time information of a service provider.
 *
 * @author derksen mediaopt GmbH
 * @package Mediaopt\DHL\ServiceProvider\Timetable
 */
class TimeInfo
{

    const OPENING_HOURS = 0;

    /**
     * @var int
     */
    protected $type;

    /**
     * @param int $type
     */
    public function __construct($type)
    {
        $this->setType($type);
    }

    /**
     * @param int $type
     * @return \Mediaopt\DHL\ServiceProvider\Timetable\TimeInfo
     */
    protected function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @see $type
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

}
