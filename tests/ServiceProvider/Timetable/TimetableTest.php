<?php

use Mediaopt\DHL\ServiceProvider\Timetable\PeriodOfTime;
use Mediaopt\DHL\ServiceProvider\Timetable\PointInTime;
use Mediaopt\DHL\ServiceProvider\Timetable\Time;
use Mediaopt\DHL\ServiceProvider\Timetable\TimeInfo;
use Mediaopt\DHL\ServiceProvider\Timetable\Timetable;
use PhpUnit\Framework\TestCase;

class TimetableTest extends TestCase
{

    protected function generateRandomlyFilledTimetable()
    {
        $timetable = new Timetable();
        for ($i = 0; $i < 100; $i++) {
            $day = mt_rand(1, 7);

            if (mt_rand(0, 1) === 0) {
                $timeInfo = new PeriodOfTime(
                    new Time(mt_rand(0, 11), mt_rand(0, 59)),
                    new Time(mt_rand(12, 23), mt_rand(0, 59)),
                    TimeInfo::OPENING_HOURS
                );
            } else {
                $timeInfo = new PointInTime(new Time(mt_rand(12, 23), mt_rand(0, 59)), 2);
            }

            $timetable->enter($timeInfo, $day);
        }
        return $timetable;
    }

    public function testEmptyTimetable()
    {
        $timetable = new Timetable();
        $this->assertEquals(array_fill(1, 7, []), $timetable->toArray());
    }

    public function testEnterWithDayZero()
    {
        $this->expectException(DomainException::class);
        $timetable = new Timetable();
        $timetable->enter(new PointInTime(new Time(mt_rand(0, 23), mt_rand(0, 59)), 2), 0);
    }

    public function testEnterWithNegativeDay()
    {
        $this->expectException(DomainException::class);
        $timetable = new Timetable();
        $timetable->enter(
            new PointInTime(new Time(mt_rand(0, 23), mt_rand(0, 59)), 2), -mt_rand(1, 7)
        );
    }

    public function testEnterWithDayBeingTooLarge()
    {
        $this->expectException(DomainException::class);
        $timetable = new Timetable();
        $timetable->enter(
            new PointInTime(new Time(mt_rand(0, 23), mt_rand(0, 59)), 2), mt_rand(8, 14)
        );
    }

    public function testFilter()
    {
        $timetable = $this->generateRandomlyFilledTimetable();

        $entryCountsOriginally = array_map('count', getProperty($timetable, 'timetable'));
        $entryCounts = array_fill(1, 7, 0);

        foreach ([TimeInfo::OPENING_HOURS, 2] as $type) {
            $filteredTimetable = $timetable->filter($type);
            foreach (getProperty($filteredTimetable, 'timetable') as $day => $entries) {
                $entryCounts[$day] += count($entries);
                foreach ($entries as $timeInfo) {
                    /** @var TimeInfo $timeInfo */
                    $this->assertEquals($type, $timeInfo->getType());
                }
            }
        }

        $this->assertEquals($entryCountsOriginally, $entryCounts);
    }

    /**
     * @param string $string
     * @return Time[]
     */
    protected function fromString($string)
    {
        if (strpos($string, '-') === false) {
            return [Time::fromString($string), Time::fromString($string)];
        }

        $periodOfTime = PeriodOfTime::fromString($string, TimeInfo::OPENING_HOURS);
        return [$periodOfTime->getBegin(), $periodOfTime->getEnd()];
    }

    public function testToArray()
    {
        $timetable = $this->generateRandomlyFilledTimetable();

        $entryCountsOriginally = array_map('count', getProperty($timetable, 'timetable'));
        $entryCounts = array_fill(1, 7, 0);

        foreach ([TimeInfo::OPENING_HOURS, 2] as $type) {
            $filteredTimetable = $timetable->filter($type);
            foreach ($filteredTimetable->toArray() as $day => $entries) {
                $numberOfEntries = count($entries);
                $entryCounts[$day] += $numberOfEntries;
                for ($i = 0; $i + 1 < $numberOfEntries; $i++) {
                    /** @var Time $begin1 */
                    /** @var Time $end1 */
                    list($begin1, $end1) = $this->fromString($entries[$i]);
                    /** @var Time $begin2 */
                    /** @var Time $end2 */
                    list($begin2, $end2) = $this->fromString($entries[$i + 1]);

                    $difference = $begin1->compareTo($begin2);
                    $this->assertTrue($difference <= 0);
                    if ($difference === 0) {
                        $this->assertTrue($end1->compareTo($end2) <= 0);
                    }
                }
            }
        }

        $this->assertEquals($entryCountsOriginally, $entryCounts);
    }

    public function testSort()
    {
        $timetable = new Timetable();
        $timetable->enter(new PeriodOfTime(new Time(9, 0), new Time(18, 0), TimeInfo::OPENING_HOURS), 1);
        $timetable->enter(new PeriodOfTime(new Time(9, 0), new Time(14, 0), 1), 1);
        $timetable->enter(new PeriodOfTime(new Time(12, 0), new Time(18, 0), 3), 1);
        $timetable->enter(new PointInTime(new Time(9, 0), 4), 1);
        $timetable->enter(new PointInTime(new Time(18, 0), 4), 1);
        $timetable->enter(new PointInTime(new Time(18, 0), 6), 1);
        $expectedArray = array_fill(1, 7, []);
        $expectedArray[1] = ['9:00', '9:00-14:00', '9:00-18:00', '12:00-18:00', '18:00', '18:00'];
        $this->assertEquals($expectedArray, $timetable->toArray());
    }

    public function testSortWithPointInTimeAndInvalidArgument()
    {
        $caughtExceptions = 0;
        $timeInfos = [new PointInTime(new Time(9, 0), 1), new TimeInfo(2)];
        foreach (range(0, 49) as $round) {
            try {
                shuffle($timeInfos);
                $timetable = new Timetable();
                foreach ($timeInfos as $timeInfo) {
                    $timetable->enter($timeInfo, Timetable::MONDAY);
                }
                $timetable->toArray();
            } catch (DomainException $exception) {
                $caughtExceptions++;
            }
        }
        $this->assertEquals(50, $caughtExceptions);
    }

    public function testSortWithPeriodOfTimeAndInvalidArgument()
    {
        $caughtExceptions = 0;
        $timeInfos = [new PeriodOfTime(new Time(9, 0), new Time(14, 0), 1), new TimeInfo(2)];
        foreach (range(0, 49) as $round) {
            try {
                shuffle($timeInfos);
                $timetable = new Timetable();
                foreach ($timeInfos as $timeInfo) {
                    $timetable->enter($timeInfo, Timetable::MONDAY);
                }
                $timetable->toArray();
            } catch (DomainException $exception) {
                $caughtExceptions++;
            }
        }
        $this->assertEquals(50, $caughtExceptions);
    }

    public function testThatPointsInTimeAreSortedBeforePeriodsOfTime()
    {
        $timeInfos = [new PeriodOfTime(new Time(10, 0), new Time(12, 0)), new PointInTime(new Time(10, 0), 0)];
        foreach (range(0, 10) as $round) {
            shuffle($timeInfos);
            $timetable = new Timetable();
            foreach ($timeInfos as $timeInfo) {
                $timetable->enter($timeInfo, Timetable::MONDAY);
            }
            $this->assertEquals(
                [
                    Timetable::MONDAY => ['10:00', '10:00-12:00'],
                    Timetable::TUESDAY => [],
                    Timetable::WEDNESDAY => [],
                    Timetable::THURSDAY => [],
                    Timetable::FRIDAY => [],
                    Timetable::SATURDAY => [],
                    Timetable::SUNDAY => [],
                ],
                $timetable->toArray()
            );
        }
    }

}
