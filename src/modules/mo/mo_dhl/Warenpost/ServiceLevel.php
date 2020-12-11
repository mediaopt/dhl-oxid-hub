<?php

namespace Mediaopt\DHL\Warenpost;

/**
 * The service level that is used for the shipment of this item.
 * There are restrictions for use of service level:
 * REGISTERED is only available with product GMR and SalesChannel DPI, //todo what is SalesChannel?
 * STANDARD is only available with products GMM and GMP,
 * PRIORITY is only available with products GPT, GPP and GMP.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
class ServiceLevel
{
    /**
     * @var string
     */
    const REGISTERED = 'REGISTERED';

    /**
     * @var string
     */
    const STANDARD = 'STANDARD';

    /**
     * @var string
     */
    const PRIORITY = 'PRIORITY';

    /**
     * Array containing all service levels.
     *
     * @var string[]
     */
    public static $SERVICE_LEVELS = [
        self::REGISTERED,
        self::STANDARD,
        self::PRIORITY,
    ];
}
