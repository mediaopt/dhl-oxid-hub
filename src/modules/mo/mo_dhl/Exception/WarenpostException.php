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
    const API_VALIDATION_ERROR = 1;

    /**
     * @var int
     */
    const PAPERWORK_VALIDATION_ERROR = 2;

    /**
     * @var int
     */
    const CONTENT_VALIDATION_ERROR = 3;

    /**
     * @var int
     */
    const ITEM_DATA_VALIDATION_ERROR = 4;

    /**
     * @var int
     */
    const PRODUCT_VALIDATION_ERROR = 5;

}
