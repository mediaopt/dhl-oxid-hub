<?php

use Mediaopt\DHL\ServiceProvider\Timetable\TimeInfo;
use PhpUnit\Framework\TestCase;

class TimeInfoTest extends TestCase
{

    public function testConstructionWithRandomTypes()
    {
        for ($i = 0; $i < 50; $i++) {
            $type = mt_rand(0, 100);
            $timeInfo = new TimeInfo($type);
            $this->assertEquals($type, $timeInfo->getType());
        }
    }

}
