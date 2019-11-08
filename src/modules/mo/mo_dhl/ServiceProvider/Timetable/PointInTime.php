<?php

namespace Mediaopt\DHL\ServiceProvider\Timetable;

/**
 * This class represents information about a point in time (e.g. 16:05).
 *
 * @author Mediaopt GmbH
 * @package Mediaopt\DHL\ServiceProvider\Timetable
 */
class PointInTime extends TimeInfo
{

    /**
     * @var Time
     */
    protected $pointInTime;

    /**
     * @param Time $pointInTime
     * @param int $type
     */
    public function __construct(Time $pointInTime, $type)
    {
        parent::__construct($type);
        $this->pointInTime = $pointInTime;
    }

    /**
     * @return Time
     */
    public function getPointInTime()
    {
        return $this->pointInTime;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->pointInTime;
    }

}
