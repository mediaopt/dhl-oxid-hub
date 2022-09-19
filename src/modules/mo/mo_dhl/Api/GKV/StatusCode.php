<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Api\GKV;


/**
 * @author Mediaopt GmbH
 */
class StatusCode
{

    /**
     * @var int
     */
    const GKV_STATUS_OK = 0;

    /**
     * @var int
     */
    const GKV_STATUS_SERVICE_UNAVAILABLE = 500;

    /**
     * @var int
     */
    const GKV_STATUS_GENERAL_ERROR = 1000;

    /**
     * @var int
     */
    const GKV_STATUS_AUTHENTICATION_ERROR = 1001;

    /**
     * @var int
     */
    const GKV_STATUS_HARD_VALIDATION_ERROR = 1101;

    /**
     * @var int
     */
    const GKV_STATUS_UNKNOWN_SHIPMENT = 2000;
}
