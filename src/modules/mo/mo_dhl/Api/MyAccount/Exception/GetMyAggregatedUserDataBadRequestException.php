<?php

namespace Mediaopt\DHL\Api\MyAccount\Exception;

class GetMyAggregatedUserDataBadRequestException extends BadRequestException
{
    /**
     * @var \Mediaopt\DHL\Api\MyAccount\Model\RequestStatus
     */
    private $requestStatus;
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $response;
    public function __construct(\Mediaopt\DHL\Api\MyAccount\Model\RequestStatus $requestStatus, \Psr\Http\Message\ResponseInterface $response)
    {
        parent::__construct('Invalid or unknown language');
        $this->requestStatus = $requestStatus;
        $this->response = $response;
    }
    public function getRequestStatus() : \Mediaopt\DHL\Api\MyAccount\Model\RequestStatus
    {
        return $this->requestStatus;
    }
    public function getResponse() : \Psr\Http\Message\ResponseInterface
    {
        return $this->response;
    }
}