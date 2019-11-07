<?php

namespace Mediaopt\DHL\ServiceProvider\Timetable;

/**
 * This class contains information like opening hours, closing time about a service provider.
 *
 * @author derksen mediaopt GmbH
 * @package Mediaopt\DHL\ServiceProvider\Timetable
 */
class Timetable
{

    /**
     * @var int
     */
    const MONDAY = 1;

    /**
     * @var int
     */
    const TUESDAY = 2;

    /**
     * @var int
     */
    const WEDNESDAY = 3;

    /**
     * @var int
     */
    const THURSDAY = 4;

    /**
     * @var int
     */
    const FRIDAY = 5;

    /**
     * @var int
     */
    const SATURDAY = 6;

    /**
     * @var int
     */
    const SUNDAY = 7;

    /**
     * This is a list of TimeInfo objects for each day (1 to 7).
     *
     * @var TimeInfo[][]
     */
    protected $timetable;

    /**
     * Initializes the timetable with zero information.
     */
    public function __construct()
    {
        $this->timetable = array_fill(1, 7, []);
    }

    /**
     * @param TimeInfo $timeInfo1
     * @param TimeInfo $timeInfo2
     * @return int
     * @throws \DomainException
     */
    protected function compareTimeInfo(TimeInfo $timeInfo1, TimeInfo $timeInfo2)
    {
        if ($timeInfo1 instanceof PointInTime) {
            return $this->comparePointInTime($timeInfo1, $timeInfo2);
        }
        if ($timeInfo1 instanceof PeriodOfTime) {
            return $this->comparePeriodOfTime($timeInfo1, $timeInfo2);
        }
        throw new \DomainException('Left argument of comparison fails to be a PointInTime or PeriodOfTime.');
    }

    /**
     * @param PointInTime $timeInfo1
     * @param TimeInfo $timeInfo2
     * @return int
     * @throws \DomainException
     */
    protected function comparePointInTime(PointInTime $timeInfo1, TimeInfo $timeInfo2)
    {
        if ($timeInfo2 instanceof PointInTime) {
            return $timeInfo1->getPointInTime()->compareTo($timeInfo2->getPointInTime());
        }
        if ($timeInfo2 instanceof PeriodOfTime) {
            return $timeInfo1->getPointInTime()->compareTo($timeInfo2->getBegin()) ?: -1;
        }
        throw new \DomainException('Right argument of comparison fails to be a PointInTime or PeriodOfTime.');
    }

    /**
     * @param PeriodOfTime $timeInfo1
     * @param TimeInfo $timeInfo2
     * @return int
     * @throws \DomainException
     */
    protected function comparePeriodOfTime(PeriodOfTime $timeInfo1, TimeInfo $timeInfo2)
    {
        if ($timeInfo2 instanceof PointInTime) {
            return $timeInfo1->getBegin()->compareTo($timeInfo2->getPointInTime()) ?: 1;
        }
        if ($timeInfo2 instanceof PeriodOfTime) {
            $difference = $timeInfo1->getBegin()->compareTo($timeInfo2->getBegin());
            return $difference === 0 ? $timeInfo1->getEnd()->compareTo($timeInfo2->getEnd()) : $difference;
        }

        throw new \DomainException('Right argument of comparison fails to be a PointInTime or PeriodOfTime.');
    }

    /**
     * @param TimeInfo[] $entries
     * @return TimeInfo[]
     */
    protected function sort($entries)
    {
        usort($entries, [$this, 'compareTimeInfo']);
        return $entries;
    }

    /**
     * @param TimeInfo $timeInfo
     * @param int $day natural number in [1;7]
     * @return \Mediaopt\DHL\ServiceProvider\Timetable\Timetable
     * @throws \DomainException
     */
    public function enter(TimeInfo $timeInfo, $day)
    {
        if ($day < 1 || $day > 7) {
            throw new \DomainException('Day must not be less than one or greater than seven.');
        }

        $this->timetable[$day][] = $timeInfo;
        return $this;
    }

    /**
     * @param int $type
     * @return Timetable new timetable that contains only the time information of the given type
     */
    public function filter($type)
    {
        $timetable = new Timetable();
        foreach ($this->timetable as $day => $entries) {
            foreach ($entries as $timeInfo) {
                if ($timeInfo->getType() === $type) {
                    $timetable->enter($timeInfo, $day);
                }
            }
        }
        return $timetable;
    }

    /**
     * @return string[][]
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->timetable as $day => $entries) {
            $array[$day] = [];
            foreach ($this->sort($entries) as $timeInfo) {
                $array[$day][] = (string)$timeInfo;
            }
        }
        return $array;
    }

}
