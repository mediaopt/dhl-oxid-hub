<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Exception;

class OrdersAccountDeleteTooManyRequestsException extends TooManyRequestsException
{
    /**
     * @var \Mediaopt\DHL\Api\ParcelShipping\Model\ErrorResponse
     */
    private $errorResponse;
    public function __construct(\Mediaopt\DHL\Api\ParcelShipping\Model\ErrorResponse $errorResponse)
    {
        parent::__construct('JSON error per RFC 7807 (https://tools.ietf.org/html/rfc7807).');
        $this->errorResponse = $errorResponse;
    }
    public function getErrorResponse() : \Mediaopt\DHL\Api\ParcelShipping\Model\ErrorResponse
    {
        return $this->errorResponse;
    }
}