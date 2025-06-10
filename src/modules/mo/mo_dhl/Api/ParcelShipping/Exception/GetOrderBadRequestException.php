<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Exception;

class GetOrderBadRequestException extends BadRequestException
{
    /**
     * @var \Mediaopt\DHL\Api\ParcelShipping\Model\LabelDataResponse
     */
    private $labelDataResponse;
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $response;
    public function __construct(\Mediaopt\DHL\Api\ParcelShipping\Model\LabelDataResponse $labelDataResponse, \Psr\Http\Message\ResponseInterface $response)
    {
        parent::__construct('Bad Request');
        $this->labelDataResponse = $labelDataResponse;
        $this->response = $response;
    }
    public function getLabelDataResponse() : \Mediaopt\DHL\Api\ParcelShipping\Model\LabelDataResponse
    {
        return $this->labelDataResponse;
    }
    public function getResponse() : \Psr\Http\Message\ResponseInterface
    {
        return $this->response;
    }
}