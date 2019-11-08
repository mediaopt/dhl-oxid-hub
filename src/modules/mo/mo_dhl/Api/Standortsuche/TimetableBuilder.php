<?php

namespace Mediaopt\DHL\Api\Standortsuche;

use Mediaopt\DHL\ServiceProvider\Timetable\PeriodOfTime;
use Mediaopt\DHL\ServiceProvider\Timetable\Time;
use Mediaopt\DHL\ServiceProvider\Timetable\TimeInfo;
use Mediaopt\DHL\ServiceProvider\Timetable\Timetable;

/**
 * Class to build a timetable out of the response of the webservice.
 *
 * @package Mediaopt\DHL\Standortsuche
 */
class TimetableBuilder
{

    /**
     * @param string $day
     * @return int
     * @throws \DomainException
     */
    protected function fromDay($day)
    {
        $normalized = strtolower($day);
        $toIndex = array_flip(['mo', 'tu', 'we', 'th', 'fr', 'sa', 'su']);
        if (!array_key_exists($normalized, $toIndex)) {
            throw new \DomainException("Unknown day '$day'");
        }
        return $toIndex[$normalized] + 1;
    }

    /**
     * @param string $days
     * @return int[]
     * @throws \DomainException
     */
    protected function parseDaysExpression($days)
    {
        if (strpos($days, '-', true) === false) {
            return [$this->fromDay($days)];
        }
        list($startIndex, $endIndex) = array_map([$this, 'fromDay'], explode('-', $days, 2));
        assert($startIndex <= $endIndex);
        return range($startIndex, $endIndex);
    }

    /**
     * @param string $hours
     * @param int $type
     * @return TimeInfo[]
     * @throws \DomainException
     */
    protected function parseTimeExpression($hours, $type)
    {
        if ($hours === 'dash') {
            return [];
        }
        assert(strpos($hours, '-', true) !== false);

        $timePeriods = [];
        foreach (explode('|', $hours) as $expression) {
            list($startTime, $endTime) = array_map('trim', explode('-', $expression, 2));
            $timePeriods[] = new PeriodOfTime(Time::fromString($startTime), Time::fromString($endTime), $type);
        }
        return $timePeriods;
    }

    /**
     * @param \stdClass[] $timeInfos
     * @return Timetable
     * @throws \DomainException
     */
    public function build(array $timeInfos)
    {
        $timetable = new Timetable();
        foreach ($this->groupOpeningHours($timeInfos) as $group) {
            list($days, $hours) = $group;
            foreach ($this->parseDaysExpression($days) as $day) {
                foreach ($this->parseTimeExpression($hours, TimeInfo::OPENING_HOURS) as $timeInfo) {
                    $timetable->enter($timeInfo, $day);
                }
            }
        }
        return $timetable;
    }

    /**
     * This method groups the array of time information objects into its rows.
     *
     * This method considers entries starting with "tt_openinghour_" and ending with a numeric string. The last digit
     * of this numeric string is considered the column and the preceding digits are considered the row. We assume that
     * we always have two columns.
     *
     * @param \stdClass[] $timeInfos
     * @return string[][]
     */
    protected function groupOpeningHours(array $timeInfos)
    {
        $groups = [];
        foreach ($timeInfos as $timeInfo) {
            $type = substr($timeInfo->type, strrpos($timeInfo->type, '_') + 1);
            if ($timeInfo->type !== 'tt_openinghour_' . $type || !is_numeric($type)) {
                continue;
            }

            $group = (int)substr($type, 0, -1);
            if (!array_key_exists($group, $groups)) {
                $groups[$group] = [];
            }
            $groups[$group][(int)substr($type, -1)] = $timeInfo->content;
        }
        return $groups;
    }
}
