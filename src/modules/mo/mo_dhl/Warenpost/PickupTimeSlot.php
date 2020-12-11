<?php

namespace Mediaopt\DHL\Warenpost;

/**
 * Pickup timeslot used in pickup information.
 * Only necessary if pickupType set to DHL_GLOBAL_MAIl or DHL_EXPRESS.
 * The following values are avaliable
 *  - MORNING (timeslot from 08:00 to 12:00),
 *  - MIDDAY (timeslot from 12:00 to 15:00)
 *  - EVENING (timeslot from 15:00 to 19:00).
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
class PickupTimeSlot
{
    /**
     * @var string
     */
    const MORNING = 'MORNING';

    /**
     * @var string
     */
    const MIDDAY = 'MIDDAY';

    /**
     * @var string
     */
    const EVENING = 'EVENING';

    /**
     * Array containing all pickup time slots
     *
     * @var string[]
     */
    public static $SLOTS = [
        self::MORNING,
        self::MIDDAY,
        self::EVENING,
    ];
}
