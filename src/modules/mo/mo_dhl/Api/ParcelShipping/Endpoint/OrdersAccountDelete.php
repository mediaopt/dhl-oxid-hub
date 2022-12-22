<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Endpoint;

class OrdersAccountDelete extends \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\Endpoint
{
    protected $accept;
    /**
     * Delete one or more shipments created earlier. Deletion of shipments is only possible prior to them being manifested (closed out, 'Tagesabschluss')  The call will return HTTP 200 (single shipment) or 207 on success, with individual status elements for each shipment. Individual status elements are HTTP 200, 400. 400 will be returned when shipment does not exist (or was already deleted). 
     *
     * @param array $queryParameters {
     *     @var string $shipment This parameter provides an existing shipment ID. If multiple shipments need to be specified (for DELETE and GET calls) you need to provide the parameter multiple times.
     * }
     * @param array $headerParameters {
     *     @var string $Accept-Language Control the APIs response language via locale abbreviation. English (en-US) and german (de-DE) are supported. If not specified, the default is english.
     * }
     * @param array $accept Accept content header application/json|application/problem+json
     */
    public function __construct(array $queryParameters = array(), array $headerParameters = array(), array $accept = array())
    {
        $this->queryParameters = $queryParameters;
        $this->headerParameters = $headerParameters;
        $this->accept = $accept;
    }
    use \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\EndpointTrait;
    public function getMethod() : string
    {
        return 'DELETE';
    }
    public function getUri() : string
    {
        return '/v2/orders';
    }
    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null) : array
    {
        return array(array(), null);
    }
    public function getExtraHeaders() : array
    {
        if (empty($this->accept)) {
            return array('Accept' => array('application/json', 'application/problem+json'));
        }
        return $this->accept;
    }
    protected function getQueryOptionsResolver() : \Symfony\Component\OptionsResolver\OptionsResolver
    {
        $optionsResolver = parent::getQueryOptionsResolver();
        $optionsResolver->setDefined(array('shipment'));
        $optionsResolver->setRequired(array('shipment'));
        $optionsResolver->setDefaults(array());
        $optionsResolver->addAllowedTypes('shipment', array('string'));
        return $optionsResolver;
    }
    protected function getHeadersOptionsResolver() : \Symfony\Component\OptionsResolver\OptionsResolver
    {
        $optionsResolver = parent::getHeadersOptionsResolver();
        $optionsResolver->setDefined(array('Accept-Language'));
        $optionsResolver->setRequired(array());
        $optionsResolver->setDefaults(array());
        $optionsResolver->addAllowedTypes('Accept-Language', array('string'));
        return $optionsResolver;
    }
    /**
     * {@inheritdoc}
     *
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteBadRequestException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteUnauthorizedException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteTooManyRequestsException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteInternalServerErrorException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\LabelDataResponse
     */
    protected function transformResponseBody(string $body, int $status, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        if (207 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json');
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json');
            }
        }
        if (400 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteBadRequestException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteBadRequestException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (401 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (429 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (500 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('ApiKey', 'BasicAuth');
    }
}