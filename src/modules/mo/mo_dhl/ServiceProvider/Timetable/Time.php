<?php

namespace Mediaopt\DHL\ServiceProvider\Timetable;

/**
 * This class is essentially a point in time that is used to express information about that point in time or a period
 * of time.
 *
 * @author Mediaopt GmbH
 * @package Mediaopt\DHL\ServiceProvider\Timetable
 */
class Time
{

    /**
     * @var int
     */
    protected $hour;

    /**
     * @var int
     */
    protected $minute;

    /**
     * @param int $hour
     * @param int $minute
     * @throws \DomainException
     */
    public function __construct($hour, $minute)
    {
        if ($hour < 0 || $hour > 24) {
            throw new \DomainException('Hour must not be less than zero or greater than 24 (except 24:00).');
        }
        $this->hour = (int) $hour;

        if ($minute < 0 || $minute > 59) {
            throw new \DomainException('Minute must not be less than zero or greater than 59.');
        }
        $this->minute = (int) $minute;

        if($hour === 24 && $minute !== 0) {
            throw new \DomainException('Any minute after 24:00 is not allowed.');
        }
    }

    /**
     * @param string $time hour and minute separated by a colon
     * @return Time
     * @throws \DomainException
     */
    public static function fromString($time)
    {
        list($hour, $minute) = explode(':', $time, 2);
        return new self($hour, $minute);
    }

    /**
     * @param Time $time
     * @return int negative iff $this < $time, positive iff $this > $time and 0 otherwise
     */
    public function compareTo(Time $time)
    {
        $hourDiff = $this->hour - $time->hour;
        if ($hourDiff !== 0) {
            return $hourDiff;
        }

        return $this->minute - $time->minute;
    }

    /**
     * @see $hour
     * @return int
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @see $minute
     * @return int
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->hour . ':' . sprintf('%02d', $this->minute);
    }

}
