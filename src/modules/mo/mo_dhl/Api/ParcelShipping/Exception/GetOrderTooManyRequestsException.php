<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Exception;

class GetOrderTooManyRequestsException extends TooManyRequestsException
{
    /**
     * @var \Mediaopt\DHL\Api\ParcelShipping\Model\RequestStatus
     */
    private $requestStatus;
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $response;
    public function __construct(\Mediaopt\DHL\Api\ParcelShipping\Model\RequestStatus $requestStatus, \Psr\Http\Message\ResponseInterface $response)
    {
        parent::__construct('Too Many Requests');
        $this->requestStatus = $requestStatus;
        $this->response = $response;
    }
    public function getRequestStatus() : \Mediaopt\DHL\Api\ParcelShipping\Model\RequestStatus
    {
        return $this->requestStatus;
    }
    public function getResponse() : \Psr\Http\Message\ResponseInterface
    {
        return $this->response;
    }
}