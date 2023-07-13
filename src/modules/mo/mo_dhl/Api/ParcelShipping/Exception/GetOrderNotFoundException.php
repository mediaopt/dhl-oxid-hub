<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Exception;

class GetOrderNotFoundException extends NotFoundException
{
    /**
     * @var \Mediaopt\DHL\Api\ParcelShipping\Model\RequestStatus
     */
    private $requestStatus;
    public function __construct(\Mediaopt\DHL\Api\ParcelShipping\Model\RequestStatus $requestStatus)
    {
        parent::__construct('Not Found');
        $this->requestStatus = $requestStatus;
    }
    public function getRequestStatus() : \Mediaopt\DHL\Api\ParcelShipping\Model\RequestStatus
    {
        return $this->requestStatus;
    }
}