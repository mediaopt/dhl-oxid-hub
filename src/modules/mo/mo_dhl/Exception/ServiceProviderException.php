<?php

namespace Mediaopt\DHL\Exception;

/**
 * An exception being thrown when dealing with service providers.
 *
 * @author Mediaopt GmbH
 * @package Mediaopt\DHL\Exception
 */
class ServiceProviderException extends \RuntimeException
{

    /**
     * @var int
     */
    const UNKNOWN_PROVIDER_TYPE = 1;

    /**
     * @var int
     */
    const UNKNOWN_SERVICE_TYPE = 2;

    /**
     * @var int
     */
    const UNKNOWN_API_SERVICE_TYPE = 3;

}
