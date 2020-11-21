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

        $compare = [
            'http://schema.org/Monday' => 1,
            'http://schema.org/Tuesday' => 2,
            'http://schema.org/Wednesday' => 3,
            'http://schema.org/Thursday' => 4,
            'http://schema.org/Friday' => 5,
            'http://schema.org/Saturday' => 6,
            'http://schema.org/Sunday' => 7,
        ];

        foreach ($timeInfos as $dayInfo) {
            if (isset($compare[$dayInfo->dayOfWeek])) {
                if ($dayInfo->closes === '23:59:59') {
                    $dayInfo->closes = '24:00';
                }
                $timetable->enter(
                    new PeriodOfTime(Time::fromString($dayInfo->opens), Time::fromString($dayInfo->closes), 0),
                    $compare[$dayInfo->dayOfWeek]
                );
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

    /**
    * @param Timetable $timeInfos
    * @return array
    */
    public function buildGrouped(Timetable $timeInfos): array
    {
        $groups = [];
        foreach ($timeInfos->toArray() as $day => $openPeriods) {
            $key = implode(', ', $openPeriods);
            isset($groups[$key]) ? $groups[$key][] = $day : $groups[$key] = [$day];
        }

        $properGroups = [];
        foreach ($groups as $openPeriods => $group) {
            $properGroups[$this->getDaysGroupsName($group)] = $openPeriods;
        }

        return $properGroups;
    }

    /**
     * @param array $days
     * @return string
     */
    public function getDaysGroupsName(array $days)
    {
        if (count($days) < 3) {
            return implode(', ', $days);
        }

        $namePieces = [];
        $period = [];
        foreach ($days as $key => $day) {
            if (empty($period)) {
                $period[] = $day;
            } else {
                if ($day === $period[count($period) - 1] + 1) {
                    $period[] = $day;
                } else {
                    if (count($period) > 2) {
                        $namePieces[] = $period[0] . ' - ' . $period[count($period) - 1];
                    } else {
                        $namePieces = array_merge($namePieces, $period);
                    }
                    $period = [$day];
                }

            }
        }

        if (count($period) > 1) {
            $namePieces[] = $period[0] . ' - ' . $period[count($period) - 1];
        } else {
            $namePieces[] = $period[0];
        }

        return implode(', ', $namePieces);
    }
}
