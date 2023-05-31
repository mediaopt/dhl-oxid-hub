<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Exception;

class GetOrderTooManyRequestsException extends TooManyRequestsException
{
    /**
     * @var \Mediaopt\DHL\Api\ParcelShipping\Model\RequestStatus
     */
    private $requestStatus;
    public function __construct(\Mediaopt\DHL\Api\ParcelShipping\Model\RequestStatus $requestStatus)
    {
        parent::__construct('Too Many Requests');
        $this->requestStatus = $requestStatus;
    }
    public function getRequestStatus() : \Mediaopt\DHL\Api\ParcelShipping\Model\RequestStatus
    {
        return $this->requestStatus;
    }
}