<?php

namespace Mediaopt\DHL\Exception;

/**
 * An exception being thrown when dealing with Warenpost
 *
 * @author Mediaopt GmbH
 * @package Mediaopt\DHL\Exception
 */
class WarenpostException extends \RuntimeException
{

    /**
     * @var int
     */
    const AWB_VALIDATION_ERROR = 1;

    /**
     * @var int
     */
    const PAPERWORK_VALIDATION_ERROR = 2;

    /**
     * @var int
     */
    const CONTENT_VALIDATION_ERROR = 3;

}
