<?php

namespace Mediaopt\DHL\Api\Warenpost;

/**
 * Pickup type used in pickup information.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
class PickupType
{
    /**
     * @var string
     */
    const CUSTOMER_DROP_OFF = 'CUSTOMER_DROP_OFF';

    /**
     * @var string
     */
    const SCHEDULED = 'SCHEDULED';

    /**
     * @var string
     */
    const DHL_GLOBAL_MAIL = 'DHL_GLOBAL_MAIl'; //todo check is last "l" should be lowercase

    /**
     * @var string
     */
    const DHL_EXPRESS = 'DHL_EXPRESS';

    /**
     * Array containing all pickup types.
     *
     * @var string[]
     */
    public static $PICKUP_TYPES = [
        self::CUSTOMER_DROP_OFF,
        self::SCHEDULED,
        self::DHL_GLOBAL_MAIL,
        self::DHL_EXPRESS,
    ];

    /**
     * Array containing DHL pickup types.
     *
     * @var string[]
     */
    public static $DHL_PICKUP_TYPES = [
        self::DHL_GLOBAL_MAIL,
        self::DHL_EXPRESS,
    ];
}
