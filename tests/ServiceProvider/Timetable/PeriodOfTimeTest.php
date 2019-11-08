<?php

use Mediaopt\DHL\ServiceProvider\Timetable\PeriodOfTime;
use Mediaopt\DHL\ServiceProvider\Timetable\Time;
use Mediaopt\DHL\ServiceProvider\Timetable\TimeInfo;

class PeriodOfTimeTest extends PHPUnit_Framework_TestCase
{

    public function testConstruction()
    {
        $periodOfTime = new PeriodOfTime(Time::fromString('9:00'), Time::fromString('18:00'), TimeInfo::OPENING_HOURS);
        $this->assertEquals('9:00', $periodOfTime->getBegin());
        $this->assertEquals('18:00', $periodOfTime->getEnd());
        $this->assertEquals('9:00-18:00', $periodOfTime);
    }

}
