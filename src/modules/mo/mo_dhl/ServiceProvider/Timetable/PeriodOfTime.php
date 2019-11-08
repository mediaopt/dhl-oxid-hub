<?php

namespace Mediaopt\DHL\ServiceProvider\Timetable;

/**
 * This class represents information about a period of time (e.g., 9:00-17:00).
 *
 * @author Mediaopt GmbH
 * @package Mediaopt\DHL\ServiceProvider\Timetable
 */
class PeriodOfTime extends TimeInfo
{

    /**
     * @var Time
     */
    protected $begin;

    /**
     * @var Time
     */
    protected $end;

    /**
     * @param \Mediaopt\DHL\ServiceProvider\Timetable\Time $begin
     * @param \Mediaopt\DHL\ServiceProvider\Timetable\Time $end
     * @param int $type
     */
    public function __construct(Time $begin, Time $end, $type = TimeInfo::OPENING_HOURS)
    {
        parent::__construct($type);
        $this->begin = $begin;
        $this->end = $end;
    }

    /**
     * @param string $period two times separated by a hyphen
     * @param int $type
     * @return PeriodOfTime
     * @throws \DomainException
     */
    public static function fromString($period, $type = TimeInfo::OPENING_HOURS)
    {
        list($begin, $end) = explode('-', $period, 2);
        return new self(Time::fromString($begin), Time::fromString($end), $type);
    }

    /**
     * @see $begin
     * @return Time
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * @see $end
     * @return Time
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->begin}-{$this->end}";
    }
}
