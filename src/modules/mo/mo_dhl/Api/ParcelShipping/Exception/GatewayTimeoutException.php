<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Exception;

class GatewayTimeoutException extends \RuntimeException implements ServerException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 504);
    }
}