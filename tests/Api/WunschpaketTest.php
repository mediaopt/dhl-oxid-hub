<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 derksen mediaopt GmbH
 */

namespace sdk;

use GuzzleHttp\Client;
use Mediaopt\DHL\Api\Credentials;
use Mediaopt\DHL\Api\Wunschpaket;
use Psr\Log\NullLogger;

class WunschpaketTest extends \PHPUnit_Framework_TestCase
{

    private $beforeChristmas;
    private $afterChristmas;

    /**
     * @param int $days
     * @return \Generator
     */
    protected function getDays($days = 365)
    {
        $day = new \DateTime();
        do {
            $gap = mt_rand(5, 50);
            $days -= $gap;
            $day->modify("+$gap days");
            yield $day;
        } while ($days > 0);
    }

    public function testWithCredentialsWithoutEkp()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageRegExp('/EKP/');
        $credentials = new Credentials('xxx', 'foo', 'bar');
        new Wunschpaket($credentials, new NullLogger(), new Client());
    }

    public function testSetCutOffTimeWithValidValues()
    {
        $wunschpaket = $this->buildWunschpaket();
        foreach (['01:23', '3:33', '17:59', '24:00'] as $value) {
            $this->assertEquals($wunschpaket->setCutOffTime($value)->getCutOffTime(), $value);
        }
    }

    public function testThatSetCutOffTimeWithTooPreciseValueIsTruncated()
    {
        $this->assertEquals('12:34', $this->buildWunschpaket()->setCutOffTime('12:34:56')->getCutOffTime());
    }

    public function testSetCutOffTimeWithOutOfRangeHour()
    {
        $this->expectException(\DomainException::class);
        $this->buildWunschpaket()->setCutOffTime('25:12');
    }

    public function testSetCutOffTimeWithNegativeHour()
    {
        $this->expectException(\DomainException::class);
        $this->buildWunschpaket()->setCutOffTime('-1:12');
    }

    public function testSetCutOffTimeWithOutOfRangeMinute()
    {
        $this->expectException(\DomainException::class);
        $this->buildWunschpaket()->setCutOffTime('12:60');
    }

    public function testSetCutOffTimeWithNegativeMinute()
    {
        $this->expectException(\DomainException::class);
        $this->buildWunschpaket()->setCutOffTime('12:-1');
    }

    public function testSetCutOffTimeWithImproperFormattedValue()
    {
        $this->expectException(\DomainException::class);
        $this->buildWunschpaket()->setCutOffTime('0x:1x');
    }

    public function testSetCutOffTimeWithTooPreciseValue()
    {
        $this->assertEquals('12:34', $this->buildWunschpaket()->setCutOffTime('12:34:56')->getCutOffTime());
    }

    public function testSetPreparationDays()
    {
        $wunschpaket = $this->buildWunschpaket();
        foreach (range(0, 100) as $numberOfDays) {
            $this->assertEquals($numberOfDays, $wunschpaket->setPreparationDays($numberOfDays)->getPreparationDays());
        }
    }

    public function testSetPreparationDaysWithNegativeDays()
    {
        $wunschpaket = $this->buildWunschpaket();
        foreach (range(-1, -100) as $numberOfDays) {
            $this->assertEquals(0, $wunschpaket->setPreparationDays($numberOfDays)->getPreparationDays());
        }
    }

    public function testSetExcludedDaysForHandingOver()
    {
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $wunschpaket = $this->buildWunschpaket();
        $numberOfDays = count($days);
        for ($sliceSize = 0; $sliceSize < $numberOfDays; $sliceSize++) {
            shuffle($days);
            $slice = array_slice($days, 0, $sliceSize);
            $this->assertEquals($slice, $wunschpaket->setExcludedDaysForHandingOver($slice)->getExcludedDaysForHandingOver());
        }
    }

    public function testSetExcludedDaysForHandingOverWithInvalidValue()
    {
        $this->expectException(\DomainException::class);
        $this->buildWunschpaket()->setExcludedDaysForHandingOver(['Sax']);
    }

    public function testThatInvalidPreferredTimeKeysAreJustReturned()
    {
        $this->assertEquals('abcdefgh', Wunschpaket::formatPreferredTime('abcdefgh'));
        $this->assertEquals('12OO14OO', Wunschpaket::formatPreferredTime('12OO14OO'));
        $this->assertEquals('16oo14oo', Wunschpaket::formatPreferredTime('16oo14oo'));
        $this->assertEquals('120014009', Wunschpaket::formatPreferredTime('120014009'));
        $this->assertEquals('9001000', Wunschpaket::formatPreferredTime('9001000'));
    }

    public function testGetPreferredTimeStructure()
    {
        $wunschpaket = $this->buildWunschpaket();
        foreach (['12045', '18181', '12489'] as $zip) {
            foreach ($wunschpaket->getPreferredTimes($zip) as $key => $time) {
                $this->assertEquals($key, preg_replace('/\D+/', '', $time));
                $this->assertEquals($time, Wunschpaket::formatPreferredTime($key), $key);
            }
        }
    }

    public function testGetPreferredTimesForInvalidZip()
    {
        $this->assertEquals([], $this->buildWunschpaket()->getPreferredTimes('9041'));
    }

    public function testGetPreferredTimeWhereNotAvailableDueToRegion()
    {
        $wunschpaket = $this->buildWunschpaket();
        $this->assertEmpty($wunschpaket->getPreferredTimes('25859'));
    }

    public function testGetPreferredTimeOnHolidays()
    {
        $wunschpaket = $this->buildWunschpaket();
        foreach (['03.10.', '01.01.', '01.05.', '25.12.', '26.12.'] as $dayAndMonth) {
            $date = new \DateTime($dayAndMonth . date('Y'));
            if ($date->getTimestamp() < time()) {
                $date->modify('+1 year');
            }
            $this->assertNotEmpty($wunschpaket->getPreferredTimes('12045', $date));
        }
    }

    public function testThatExcludedFlagMatchesNegationOfIsValidPreferredDay()
    {
        $wunschpaket = $this->buildWunschpaket();
        foreach ($this->getDays() as $day) {
            $preferredDays = $wunschpaket->getPreferredDays('12045', $wunschpaket->getTransferDay($day));
            foreach ($preferredDays as $preferredDay) {
                if ($this->isAroundChristmas($preferredDay['datetime'])) {
                    continue;
                }
                $this->assertEquals($preferredDay['excluded'], !$wunschpaket->isValidPreferredDay('12045', $preferredDay['datetime']));
            }
        }
    }

    public function testStructureOfGetPreferredDays()
    {
        $wunschpaket = $this->buildWunschpaket();
        foreach ($this->getDays() as $day) {
            $preferredDays = $wunschpaket->getPreferredDays('12045', $wunschpaket->getTransferDay($day));
            foreach ($preferredDays as $date => $preferredDay) {
                /** @var \DateTime $datetime */
                $datetime = $preferredDay['datetime'];
                $this->assertInstanceOf(\DateTime::class, $datetime);
                $this->assertInternalType('bool', $preferredDay['excluded']);
                $this->assertEquals($date, $datetime->format('d.m.Y'));
            }
        }
    }

    public function testGetPreferredDaysForInvalidZip()
    {
        $this->assertEquals([], $this->buildWunschpaket()->getPreferredDays('9041'));
    }

    public function testThatSundayIsNotAPreferredDay()
    {
        $wunschpaket = $this->buildWunschpaket();
        $sunday = new \DateTime('this Sunday');
        for ($i = 0; $i < 53; $i += mt_rand(1, 20)) {
            $this->assertFalse($wunschpaket->isValidPreferredDay('12045', $sunday));
            $sunday->modify('+7 days');
        }
    }

    public function testThatThereArePreferredDays()
    {
        $wunschpaket = $this->buildWunschpaket();
        foreach ($this->getDays() as $day) {
            $preferredDays = $wunschpaket->getPreferredDays('12045', $wunschpaket->getTransferDay($day), false);
            foreach ($preferredDays as $preferredDay) {
                if ($this->isAroundChristmas($preferredDay['datetime'])) {
                    continue;
                }
                $this->assertTrue($wunschpaket->isValidPreferredDay('12045', $preferredDay['datetime']));
            }
        }
    }

    public function testThatAHolidayIsNotAPreferredDay()
    {
        $wunschpaket = $this->buildWunschpaket();
        $this->assertFalse($wunschpaket->isValidPreferredDay('12045', new \DateTime('30.03.2018')));
        $this->assertFalse($wunschpaket->isValidPreferredDay('12045', new \DateTime('02.04.2018')));
        $this->assertFalse($wunschpaket->isValidPreferredDay('12045', new \DateTime('01.05.2018')));
        $this->assertFalse($wunschpaket->isValidPreferredDay('12045', new \DateTime('10.05.2018')));
        $this->assertFalse($wunschpaket->isValidPreferredDay('12045', new \DateTime('21.05.2018')));
        $this->assertFalse($wunschpaket->isValidPreferredDay('12045', new \DateTime('25.12.2018')));
        $this->assertFalse($wunschpaket->isValidPreferredDay('12045', new \DateTime('26.12.2018')));
    }

    public function testThatThereAreAlwaysAsManyPreferredDaysAsDefinedInTheCorrespondingClassConstant()
    {
        $wunschpaket = $this->buildWunschpaket();
        foreach ($this->getDays() as $day) {
            $this->assertCount(Wunschpaket::WUNSCHTAG_COUNT, $wunschpaket->getPreferredDays('12045', $day));
        }
    }

    public function testThatThereIsNoHolidayInThePreferredDaysWhenSaidSo()
    {
        $wunschpaket = $this->buildWunschpaket();
        $mondayBeforeEaster = \DateTime::createFromFormat('d.m.Y', '21.03.' . date('Y'));
        $mondayBeforeEaster->setTime(0, 0, 0);
        $mondayBeforeEaster->modify('+' . \easter_days(date('Y')) . ' days');
        $mondayBeforeEaster->modify('last Monday');
        $wunschpaket->setCutOffTime('16:00');
        foreach ($wunschpaket->getPreferredDays('12045', $mondayBeforeEaster, false) as $preferredDay) {
            $this->assertTrue($wunschpaket->isValidPreferredDay('12045', $preferredDay['datetime']));
        }
    }

    public function testThatThereIsAtLeastOneHolidayInThePreferredDaysWhenWeIncludeThem()
    {
        $wunschpaket = $this->buildWunschpaket();
        $mondayBeforeEaster = \DateTime::createFromFormat('d.m.Y', '21.03.' . date('Y'));
        $mondayBeforeEaster->setTime(0, 0, 0);
        $mondayBeforeEaster->modify('+' . \easter_days(date('Y')) . ' days');
        $mondayBeforeEaster->modify('last Monday');
        $wunschpaket->setCutOffTime('16:00');
        $holidays = 0;
        foreach ($wunschpaket->getPreferredDays('12045', $mondayBeforeEaster, true) as $date => $preferredDay) {
            if (!$wunschpaket->isValidPreferredDay('12045', $preferredDay['datetime'])) {
                $holidays++;
            }
        }
        $this->assertGreaterThan(0, $holidays);
    }

    public function testThatPreferredDaysNeverContainASunday()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket->setCutOffTime('16:00');
        $time = new \DateTime('Thursday');
        for ($i = 0; $i < 53; $i++) {
            foreach ($wunschpaket->getPreferredDays('12045', $time) as $preferredDay) {
                /** @var \DateTime $datetime */
                $datetime = $preferredDay['datetime'];
                $this->assertNotEquals('Sun', $datetime->format('D'));
            }
        }
    }

    public function testGetTransferDayWhenStartingBeforeTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket->setCutOffTime('12:00');
        $date = new \DateTime('14.08.2017 08:00 ' . date_default_timezone_get());
        $this->assertEquals('14.08.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    public function testGetTransferDayWhenStartingAfterTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket->setCutOffTime('12:00');
        $date = new \DateTime('14.08.2017 16:00 ' . date_default_timezone_get());
        $this->assertEquals('15.08.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    public function testGetTransferDayWhenStartingOnASundayBeforeTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket->setCutOffTime('12:00');
        $date = new \DateTime('13.08.2017 08:00 ' . date_default_timezone_get());
        $this->assertEquals('14.08.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    public function testGetTransferDayWhenStartingOnASundayAfterTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket->setCutOffTime('12:00');
        $date = new \DateTime('13.08.2017 16:00 ' . date_default_timezone_get());
        $this->assertEquals('14.08.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    public function testGetTransferDayWhenStartingOnAnExcludedDayBeforeTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket
            ->setCutOffTime('12:00')
            ->setExcludedDaysForHandingOver(['Tue']);
        $date = new \DateTime('15.08.2017 08:00 ' . date_default_timezone_get());
        $this->assertEquals('16.08.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    public function testGetTransferDayWhenStartingOnAnExcludedDayAfterTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket
            ->setCutOffTime('12:00')
            ->setExcludedDaysForHandingOver(['Tue']);
        $date = new \DateTime('15.08.2017 06:00 ' . date_default_timezone_get());
        $this->assertEquals('16.08.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    public function testGetTransferDayWhenStartingOnAPublicHolidayBeforeTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket->setCutOffTime('12:00');
        $date = new \DateTime('03.10.2017 08:00 ' . date_default_timezone_get());
        $this->assertEquals('04.10.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    public function testGetTransferDayWhenStartingOnAPublicHolidayAfterTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket->setCutOffTime('12:00');
        $date = new \DateTime('03.10.2017 16:00 ' . date_default_timezone_get());
        $this->assertEquals('04.10.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    public function testGetTransferDayRaisesAnExceptionIfEveryWorkingDayIsExcluded()
    {
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        /** @noinspection NonSecureShuffleUsageInspection */
        shuffle($days);
        $this->expectException(\DomainException::class);
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket
            ->setCutOffTime('12:00')
            ->setExcludedDaysForHandingOver($days);
        $date = new \DateTime('15.08.2017 16:00 ' . date_default_timezone_get());
        $wunschpaket->getTransferDay($date);
    }

    public function testGetTransferDayOnASaturdayBeforeTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket->setCutOffTime('12:00');
        $date = new \DateTime('26.08.2017 10:00 ' . date_default_timezone_get());
        $this->assertEquals('26.08.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    public function testGetTransferDayOnASaturdayAfterTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket->setCutOffTime('12:00');
        $date = new \DateTime('26.08.2017 16:00 ' . date_default_timezone_get());
        $this->assertEquals('28.08.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    public function testGetTransferDayOnADayBeforeAPublicHolidayBeforeTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket->setCutOffTime('12:00');
        $date = new \DateTime('02.10.2017 10:00 ' . date_default_timezone_get());
        $this->assertEquals('02.10.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    public function testGetTransferDayOnADayBeforeAPublicHolidayAfterTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket->setCutOffTime('12:00');
        $date = new \DateTime('02.10.2017 16:00 ' . date_default_timezone_get());
        $this->assertEquals('04.10.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    public function testGetTransferDayWithPreparationTimeBeforeTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket
            ->setCutOffTime('12:00')
            ->setPreparationDays(7);
        $date = new \DateTime('23.10.2017 10:00 ' . date_default_timezone_get());
        $this->assertEquals('01.11.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    public function testGetTransferDayWithPreparationTimeAfterTheCutOff()
    {
        $wunschpaket = $this->buildWunschpaket();
        $wunschpaket
            ->setCutOffTime('12:00')
            ->setPreparationDays(1);
        $date = new \DateTime('18.12.2017 20:00 ' . date_default_timezone_get());
        $this->assertEquals('20.12.2017', $wunschpaket->getTransferDay($date)->format('d.m.Y'));
    }

    /**
     * @return Wunschpaket
     */
    protected function buildWunschpaket()
    {
        return (new \TestConfigurator())->buildWunschpaket();
    }

    protected function isAroundChristmas($date)
    {
        if (!$this->beforeChristmas) {
            $this->beforeChristmas = new \DateTime('23.12.' . date('Y'));
            if ($this->beforeChristmas->getTimestamp() < time()) {
                $this->beforeChristmas->modify('+1 year');
            }
            $this->afterChristmas = clone $this->beforeChristmas;
            $this->afterChristmas->modify('+14 days');
        }
        $this->buildWunschpaket()->getLogger()->debug($this->beforeChristmas->format('Y.m.d'). ' - '. $this->afterChristmas->format('Y.m.d'));
        return $this->beforeChristmas <= $date && $date <= $this->afterChristmas;
    }
}
