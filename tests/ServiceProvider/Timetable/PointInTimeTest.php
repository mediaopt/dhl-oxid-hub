<?php

use Mediaopt\DHL\ServiceProvider\Timetable\PointInTime;
use Mediaopt\DHL\ServiceProvider\Timetable\Time;
use Mediaopt\DHL\ServiceProvider\Timetable\TimeInfo;
use PhpUnit\Framework\TestCase;

class PointInTimeTest extends TestCase
{

    public function testConstruction()
    {
        $pointInTime = new PointInTime(Time::fromString('16:00'), TimeInfo::OPENING_HOURS);
        $this->assertEquals('16:00', $pointInTime->getPointInTime());
    }

}
