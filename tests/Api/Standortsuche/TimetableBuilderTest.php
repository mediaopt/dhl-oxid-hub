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


class TimetableBuilderTest extends \PHPUnit_Framework_TestCase
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
        $json = '[{"type":"tt_openinghour_rows","content":"3"},{"type":"tt_openinghour_cols","content":"2"},{"type":"tt_openinghour_00","content":"mo-fr"},{"type":"tt_openinghour_01","content":"06:00 - 19:00"},{"type":"tt_openinghour_10","content":"sa"},{"type":"tt_openinghour_11","content":"08:00 - 16:00"},{"type":"tt_openinghour_20","content":"su"},{"type":"tt_openinghour_21","content":"08:00 - 14:00"},{"type":"tt_timestamp","content":"29668888744299732"}]';
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
        $json = '[{"type":"tt_openinghour_rows","content":"3"},{"type":"tt_openinghour_cols","content":"2"},{"type":"tt_openinghour_00","content":"mo-fr"},{"type":"tt_openinghour_01","content":"00:00 - 24:00"},{"type":"tt_openinghour_10","content":"sa"},{"type":"tt_openinghour_11","content":"00:00 - 24:00"},{"type":"tt_openinghour_20","content":"su"},{"type":"tt_openinghour_21","content":"00:00 - 04:00|08:00 - 24:00"},{"type":"tt_timestamp","content":"29670850859239880"}]';
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

}
