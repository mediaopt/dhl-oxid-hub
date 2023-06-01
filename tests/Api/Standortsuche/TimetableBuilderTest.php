<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 Mediaopt GmbH
 */

namespace sdk\Standortsuche;


use Mediaopt\DHL\Api\Standortsuche\TimetableBuilder;
use Mediaopt\DHL\ServiceProvider\Timetable\PeriodOfTime;
use Mediaopt\DHL\ServiceProvider\Timetable\Time;
use Mediaopt\DHL\ServiceProvider\Timetable\TimeInfo;
use Mediaopt\DHL\ServiceProvider\Timetable\Timetable;
use PhpUnit\Framework\TestCase;

class TimetableBuilderTest extends TestCase
{

    public function buildSample1()
    {
        $sixAmToSevenPm = new PeriodOfTime(new Time(6, 0), new Time(19, 0), TimeInfo::OPENING_HOURS);
        $eightAmToFourPm = new PeriodOfTime(new Time(8, 0), new Time(16, 0), TimeInfo::OPENING_HOURS);
        $eightAmToTwoPm = new PeriodOfTime(new Time(8, 0), new Time(14, 0), TimeInfo::OPENING_HOURS);
        $timetable = new Timetable();
        $timetable->enter($sixAmToSevenPm, Timetable::MONDAY);
        $timetable->enter($sixAmToSevenPm, Timetable::TUESDAY);
        $timetable->enter($sixAmToSevenPm, Timetable::WEDNESDAY);
        $timetable->enter($sixAmToSevenPm, Timetable::THURSDAY);
        $timetable->enter($sixAmToSevenPm, Timetable::FRIDAY);
        $timetable->enter($eightAmToFourPm, Timetable::SATURDAY);
        $timetable->enter($eightAmToTwoPm, Timetable::SUNDAY);
        return $timetable;
    }

    public function buildSample2()
    {
        $allDayLong = new PeriodOfTime(new Time(0, 0), new Time(24, 0), TimeInfo::OPENING_HOURS);
        $timetable = new Timetable();
        $timetable->enter($allDayLong, Timetable::MONDAY);
        $timetable->enter($allDayLong, Timetable::TUESDAY);
        $timetable->enter($allDayLong, Timetable::WEDNESDAY);
        $timetable->enter($allDayLong, Timetable::THURSDAY);
        $timetable->enter($allDayLong, Timetable::FRIDAY);
        $timetable->enter($allDayLong, Timetable::SATURDAY);
        $timetable->enter($allDayLong, Timetable::SUNDAY);
        return $timetable;
    }

    public function testSamplePostfilialeSample()
    {
        $json = '[
        {"opens":"06:00:00","closes":"19:00:00","dayOfWeek":"http://schema.org/Monday"},
        {"opens":"06:00:00","closes":"19:00:00","dayOfWeek":"http://schema.org/Tuesday"},
        {"opens":"06:00:00","closes":"19:00:00","dayOfWeek":"http://schema.org/Wednesday"},
        {"opens":"06:00:00","closes":"19:00:00","dayOfWeek":"http://schema.org/Thursday"},
        {"opens":"06:00:00","closes":"19:00:00","dayOfWeek":"http://schema.org/Friday"},
        {"opens":"08:00:00","closes":"16:00:00","dayOfWeek":"http://schema.org/Saturday"},
        {"opens":"08:00:00","closes":"14:00:00","dayOfWeek":"http://schema.org/Sunday"}]';
        $this->assertEquals(
            [
                Timetable::MONDAY    => ['6:00-19:00'],
                Timetable::TUESDAY   => ['6:00-19:00'],
                Timetable::WEDNESDAY => ['6:00-19:00'],
                Timetable::THURSDAY  => ['6:00-19:00'],
                Timetable::FRIDAY    => ['6:00-19:00'],
                Timetable::SATURDAY  => ['8:00-16:00'],
                Timetable::SUNDAY    => ['8:00-14:00'],
            ],
            (new TimetableBuilder())->build(json_decode($json))->toArray()
        );
    }

    public function testSamplePackstation()
    {
        $json = '[
        {"opens":"00:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Monday"},
        {"opens":"00:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Tuesday"},
        {"opens":"00:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Wednesday"},
        {"opens":"00:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Thursday"},
        {"opens":"00:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Friday"},
        {"opens":"00:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Saturday"},
        {"opens":"08:00:00","closes":"23:59:59","dayOfWeek":"http://schema.org/Sunday"},
        {"opens":"00:00:00","closes":"04:00:00","dayOfWeek":"http://schema.org/Sunday"}]';
        $this->assertEquals(
            [
                Timetable::MONDAY    => ['0:00-24:00'],
                Timetable::TUESDAY   => ['0:00-24:00'],
                Timetable::WEDNESDAY => ['0:00-24:00'],
                Timetable::THURSDAY  => ['0:00-24:00'],
                Timetable::FRIDAY    => ['0:00-24:00'],
                Timetable::SATURDAY  => ['0:00-24:00'],
                Timetable::SUNDAY    => ['0:00-4:00', '8:00-24:00'],
            ],
            (new TimetableBuilder())->build(json_decode($json))->toArray()
        );
    }

    public function testSamplePostfilialeGrouped()
    {
        $json = '[
        {"opens":"06:00:00","closes":"19:00:00","dayOfWeek":"http://schema.org/Monday"},
        {"opens":"13:00:00","closes":"16:00:00","dayOfWeek":"http://schema.org/Tuesday"},
        {"opens":"08:00:00","closes":"12:00:00","dayOfWeek":"http://schema.org/Tuesday"},
        {"opens":"06:00:00","closes":"19:00:00","dayOfWeek":"http://schema.org/Wednesday"},
        {"opens":"06:00:00","closes":"19:00:00","dayOfWeek":"http://schema.org/Thursday"},
        {"opens":"06:00:00","closes":"19:00:00","dayOfWeek":"http://schema.org/Friday"},
        {"opens":"08:00:00","closes":"12:00:00","dayOfWeek":"http://schema.org/Saturday"},
        {"opens":"13:00:00","closes":"16:00:00","dayOfWeek":"http://schema.org/Saturday"},
        {"opens":"08:00:00","closes":"14:00:00","dayOfWeek":"http://schema.org/Sunday"}]';

        $timeTableBuilder = new TimetableBuilder();

        $this->assertEquals(
            [
                1 => [
                    'dayGroup' => Timetable::MONDAY . ', ' . Timetable::WEDNESDAY . ' - ' . Timetable::FRIDAY,
                    'openPeriods' => '6:00-19:00'
                ],
                2 => [
                    'dayGroup' => Timetable::TUESDAY . ', ' . Timetable::SATURDAY,
                    'openPeriods' => '8:00-12:00, 13:00-16:00'
                ],
                3 => [
                    'dayGroup' => Timetable::SUNDAY,
                    'openPeriods' => '8:00-14:00'
                ],
            ],
            $timeTableBuilder->buildGrouped($timeTableBuilder->build(json_decode($json)))
        );
    }

    public function testDayOfWeeksCombine() {
        $inputList = [
            [
                'input' => [1, 3, 4, 5],
                'expected' => '1, 3 - 5'
            ],
            [
                'input' => [1, 2, 3, 4, 5, 6, 7],
                'expected' => '1 - 7'
            ],
            [
                'input' => [1, 2, 4, 5, 6],
                'expected' => '1, 2, 4 - 6'
            ],
            [
                'input' => [1, 2, 3, 5, 6, 7],
                'expected' => '1 - 3, 5 - 7'
            ],
            [
                'input' => [1, 2, 4, 5, 6, 7],
                'expected' => '1, 2, 4 - 7'
            ],
            [
                'input' => [1, 3, 5, 7],
                'expected' => '1, 3, 5, 7'
            ],
            [
                'input' => [1, 3],
                'expected' => '1, 3'
            ],
            [
                'input' => [1, 2, 3],
                'expected' => '1 - 3'
            ],
        ];

        foreach ($inputList as $item) {
            $this->assertEquals(
                $item['expected'],
                (new TimetableBuilder())->getDaysGroupsName($item['input'])
            );
        }
    }
}
