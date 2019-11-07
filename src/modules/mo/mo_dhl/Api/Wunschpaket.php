<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 derksen mediaopt GmbH
 */

namespace Mediaopt\DHL\Api;

use GuzzleHttp\ClientInterface;
use Mediaopt\DHL\Exception\WebserviceException;
use Psr\Log\LoggerInterface;

/**
 * @author  derksen mediaopt GmbH
 * @version ${VERSION}, ${REVISION}
 * @package Mediaopt\DHL
 */
class Wunschpaket extends Base
{
    /**
     * The number of working days it takes to deliver a good.
     *
     * @var int
     */
    const DELIVERY_DAYS = 2;

    /**
     * Numbers of days to return to the user as preferred days.
     *
     * @var int
     */
    const WUNSCHTAG_COUNT = 5;

    /**
     * @var string
     */
    const WUNSCHORT = 'Wunschort';

    /**
     * @var string
     */
    const WUNSCHNACHBAR = 'Wunschnachbar';

    /**
     * @var int
     */
    protected $preparationDays = 0;

    /**
     * The assumed format is H:i.
     *
     * @var string
     */
    protected $cutOffTime = '12:00';

    /**
     * List of days on which the merchant will not pass a package to DHL (format: D).
     *
     * @var string[]
     */
    protected $excludedDaysForHandingOver = [];

    /**
     * @param string|int $preferredTime
     * @return string
     */
    public static function formatPreferredTime($preferredTime)
    {
        if (strlen($preferredTime) !== 8 || !ctype_digit($preferredTime)) {
            return $preferredTime;
        }
        $chunks = str_split((string)$preferredTime, 2);
        return "{$chunks[0]}:{$chunks[1]}-{$chunks[2]}:{$chunks[3]}";
    }

    /**
     * @param ClientInterface $client
     * @param Credentials     $credentials
     * @param LoggerInterface $logger
     * @throws \RuntimeException
     */
    public function __construct(Credentials $credentials, LoggerInterface $logger, ClientInterface $client)
    {
        if ((string)$credentials->getEkp() === '') {
            throw new \RuntimeException('The Parcel Management API requires an EKP.');
        }
        parent::__construct($credentials, $logger, $client);
    }

    /**
     * @return int
     */
    public function getPreparationDays()
    {
        return $this->preparationDays;
    }

    /**
     * @param int $preparationDays
     * @return Wunschpaket
     */
    public function setPreparationDays($preparationDays)
    {
        $this->preparationDays = max(0, (int)$preparationDays);
        return $this;
    }

    /**
     * @return string
     */
    public function getCutOffTime()
    {
        return $this->cutOffTime;
    }

    /**
     * @param string $cutOffTime
     * @return Wunschpaket
     * @throws \DomainException
     */
    public function setCutOffTime($cutOffTime)
    {
        list($hour, $minute) = explode(':', $cutOffTime, 3);
        /** @noinspection NotOptimalIfConditionsInspection */
        if (!ctype_digit($hour) || (int)$hour < 0 || (int)$hour > 24) {
            throw new \DomainException('Hour is not a digit sequence or out of range.');
        }
        /** @noinspection NotOptimalIfConditionsInspection */
        if (!ctype_digit($minute) || (int)$minute < 0 || (int)$minute > 59) {
            throw new \DomainException('Minute is not a digit sequence or out of range.');
        }
        $this->cutOffTime = "$hour:$minute";
        return $this;
    }

    /**
     * @return string[]
     */
    public function getExcludedDaysForHandingOver()
    {
        return $this->excludedDaysForHandingOver;
    }

    /**
     * @param string[] $excludedDaysForHandingOver
     * @return Wunschpaket
     */
    public function setExcludedDaysForHandingOver($excludedDaysForHandingOver)
    {
        $validDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        foreach ($excludedDaysForHandingOver as $day) {
            if (!in_array($day, $validDays, true)) {
                throw new \DomainException("'$day' is not a valid day.");
            }
        }
        $this->excludedDaysForHandingOver = $excludedDaysForHandingOver;
        return $this;
    }

    /**
     * @return string[][]
     */
    protected function buildRequestOptions()
    {
        $options = parent::buildRequestOptions();
        $options['headers'] = ['X-EKP' => $this->getCredentials()->getEkp()];
        return $options;
    }

    /**
     * @return string
     */
    protected function getIdentifier()
    {
        return 'checkout';
    }

    /**
     * @param string         $zip
     * @param \DateTime|null $date
     * @return string
     */
    protected function buildAvailableServicesUrl($zip, \DateTime $date = null)
    {
        if ($date === null) {
            $date = new \DateTime('today');
        }
        return "$zip/availableServices?startDate={$date->format('Y-m-d')}";
    }

    /**
     * @param string         $zip
     * @param \DateTime|null $date if null, today is the default
     * @return string[]
     */
    public function getPreferredTimes($zip, \DateTime $date = null)
    {
        try {
            $services = $this->callApi($this->buildAvailableServicesUrl($zip, $date));
            if ($services->preferredTime->available === false) {
                return [];
            }

            $options = [];
            foreach ((array)$services->preferredTime->timeframes as $timeframe) {
                foreach (['start', 'end'] as $dayTimeProperty) {
                    if (strlen($timeframe->$dayTimeProperty) < 2) {
                        $timeframe->$dayTimeProperty = "0{$timeframe->$dayTimeProperty}";
                    }
                }
                $interval = "{$timeframe->start}-{$timeframe->end}";
                $options[preg_replace('/\D+/', '', $interval)] = $interval;
            }
            return $options;
        } catch (WebserviceException $exception) {
            // The exception is logged inside callApi.
            return [];
        }
    }

    /**
     * @param string    $zip
     * @param \DateTime $transferDay                         if null, the current time will be used
     * @param bool      $includeExcludedDays                 if true, this will also include days that are normally
     *                                                       excluded; it will never contain sundays
     * @return mixed[][] each element is a dictionary mapping 'datetime' to a \DateTime object and 'excluded' to a
     *                                                       boolean
     * @throws \DomainException
     */
    public function getPreferredDays($zip, \DateTime $transferDay = null, $includeExcludedDays = true)
    {
        try {
            $services = $this->callApi($this->buildAvailableServicesUrl($zip, $transferDay));
            if ($services->preferredDay->available === false) {
                return [];
            }
            $options = (array)$services->preferredDay->validDays;
            $day = $this->convertFromPreferredDay(reset($options));
            $days = [];
            for ($remaining = min(count($options), self::WUNSCHTAG_COUNT); $remaining > 0; $day->modify('+1 day')) {

                $isPreferredDay = $day->format('d.m.Y') === $this->convertFromPreferredDay(current($options))->format('d.m.Y');
                if (($isPreferredDay || $includeExcludedDays) && !$this->isSunday($day)) {
                    $days[$day->format('d.m.Y')] = [
                        'datetime' => clone $day,
                        'excluded' => !$isPreferredDay,
                    ];
                    $remaining--;
                }
                if ($isPreferredDay) {
                    next($options);
                }
            }
            return $days;
        } catch (WebserviceException $exception) {
            return [];
        }
    }

    /**
     * @param string    $zip
     * @param \DateTime $date in case of a string: d.m.Y
     * @return bool
     */
    public function isValidPreferredDay($zip, \DateTime $date)
    {
        $plausibleTransferDay = clone $date;
        $plausibleTransferDay->modify('-5 days');
        foreach ($this->getPreferredDays($zip, $plausibleTransferDay, false) as $preferredDay) {
            /** @var \DateTime $preferredDayDateTime */
            $preferredDayDateTime = $preferredDay['datetime'];
            if ($preferredDayDateTime->format('d.m.Y') === $date->format('d.m.Y')) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param \DateTime $dateTime
     * @return bool
     */
    protected function isPublicHoliday(\DateTime $dateTime)
    {
        return in_array($dateTime->format('d.m.Y'), $this->generatePublicHolidays($dateTime), true);
    }

    /**
     * @param \DateTime $dateTime
     * @return string[]
     */
    protected function generatePublicHolidays(\DateTime $dateTime)
    {
        $year = $dateTime->format('Y');
        $easter = clone $dateTime;
        $easter->setDate($year, 3, 21);
        $easter->setTime(0, 0);
        $easter->modify('+' . \easter_days($year) . ' days');
        $goodFriday = clone $easter;
        $goodFriday->modify('-2 days');
        $easterMonday = clone $easter;
        $easterMonday->modify('+1 day');
        $ascensionDay = clone $easter;
        $ascensionDay->modify('+39 days');
        $whitmonday = clone $easter;
        $whitmonday->modify('+50 days');
        return [
            $goodFriday->format('d.m.Y'),
            $easterMonday->format('d.m.Y'),
            $ascensionDay->format('d.m.Y'),
            $whitmonday->format('d.m.Y'),
            '01.01.' . $year,
            '01.05.' . $year,
            '03.10.' . $year,
            '25.12.' . $year,
            '26.12.' . $year,
            '31.10.2017',
        ];
    }

    /**
     * @param string[]  $excludedDays list of days on which the merchant will not pass a package to DHL, format: D
     * @param \DateTime $dateTime
     * @return bool
     */
    protected function isValidDayForHandingOver(array $excludedDays, \DateTime $dateTime)
    {
        return !$this->isSunday($dateTime)
            && !in_array($dateTime->format('D'), $excludedDays, true)
            && !$this->isPublicHoliday($dateTime);
    }

    /**
     * Returns the day on which the package has to be transferred to DHL.
     *
     * @param \DateTime|null $date
     * @return \DateTime
     * @throws \DomainException
     */
    public function getTransferDay(\DateTime $date = null)
    {
        $excludedDays = $this->getExcludedDaysForHandingOver();
        if (count(array_intersect(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'], $excludedDays)) === 6) {
            throw new \DomainException('There are no options if every day is excluded.');
        }
        $day = $this->considerCutOffTime($this->considerPreparationDays($date ?: new \DateTime()));
        while (!$this->isValidDayForHandingOver($excludedDays, $day)) {
            $day->modify('+1 day');
        }
        return $day;
    }

    /**
     * @param \DateTime $startDay
     * @return \DateTime the first day that is not considered a preparation day
     */
    protected function considerPreparationDays(\DateTime $startDay)
    {
        $preparationDays = $this->getPreparationDays();
        if (max($preparationDays, 0) === 0) {
            return $startDay;
        }
        $day = $startDay;
        do {
            if ($this->isPreparationDay($day)) {
                $preparationDays--;
            }
            $day->modify('+1 day');
        } while ($preparationDays > 0);

        return $day;
    }

    /**
     * @param \DateTime $dateTime
     * @return \DateTime
     */
    protected function considerCutOffTime(\DateTime $dateTime)
    {
        $cutOffDateTime = clone $dateTime;
        $cutOffDateTime->modify($this->getCutOffTime());
        return $dateTime > $cutOffDateTime
            ? $dateTime->setTime(0, 0)->modify('+1 day')
            : $dateTime->setTime(0, 0);
    }

    /**
     * @param \DateTime $dateTime
     * @return bool
     */
    protected function isPreparationDay(\DateTime $dateTime)
    {
        return !$this->isSunday($dateTime) && !$this->isPublicHoliday($dateTime);
    }

    /**
     * @param \DateTime $dateTime
     * @return bool
     */
    protected function isSunday(\DateTime $dateTime)
    {
        return $dateTime->format('w') === '0';
    }

    /**
     * @param \stdClass $preferredDay
     * @return \DateTime
     */
    protected function convertFromPreferredDay(\stdClass $preferredDay)
    {
        return new \DateTime($preferredDay->start);
    }
}
