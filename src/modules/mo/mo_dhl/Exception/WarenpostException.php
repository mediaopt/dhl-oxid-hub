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

}
