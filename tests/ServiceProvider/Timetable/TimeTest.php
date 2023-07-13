<?php

use Mediaopt\DHL\ServiceProvider\Timetable\Time;
use PhpUnit\Framework\TestCase;

class TimeTest extends TestCase
{

    protected function generateTime() {
        $hour = mt_rand(0, 24);
        $minute = $hour !== 24 ? mt_rand(0, 59) : 0;
        return [$hour, $minute];
    }

    public function testFromString()
    {
        for ($i = 0; $i < 100; $i++) {
            list($hour, $minute) = $this->generateTime();
            $time = Time::fromString($hour . ':' . sprintf("%02d", $minute));
            $this->assertEquals($hour, $time->getHour());
            $this->assertEquals($minute, $time->getMinute());
        }
    }

    public function testToString()
    {
        for ($i = 0; $i < 100; $i++) {
            list($hour, $minute) = $this->generateTime();
            $time = $hour . ':' . sprintf("%02d", $minute);
            $this->assertEquals($time, (string)Time::fromString($time));
        }
    }

    public function testCreationWithValidData()
    {
        for ($i = 0; $i < 100; $i++) {
            list($hour, $minute) = $this->generateTime();
            $time = new Time($hour, $minute);
            $this->assertEquals($hour, $time->getHour());
            $this->assertEquals($minute, $time->getMinute());
        }
    }

    public function testCreationWithNegativeMinute()
    {
        $this->expectException(DomainException::class);
        new Time(12, -mt_rand(1, 59));
    }

    public function testCreationWithTooLargePositiveMinute()
    {
        $this->expectException(DomainException::class);
        new Time(12, mt_rand(60, 120));
    }

    public function testCreationWithNegativeHour()
    {
        $this->expectException(DomainException::class);
        new Time(-1 * mt_rand(1, 24), 0);
    }

    public function testCreationWithTooLargePositiveHour()
    {
        $this->expectException(DomainException::class);
        new Time(mt_rand(25, 48), 0);
    }

    public function testCreationWithAtLeastOneMinuteAfter24()
    {
        $this->expectException(DomainException::class);
        new Time(24, mt_rand(1, 59));
    }

}
