<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Endpoint;

class OrdersAccountDelete extends \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\Endpoint
{
    protected $accept;
    /**
     * Delete one or more shipments created earlier. Deletion of shipments is only possible prior to them being manifested (closed out, 'Tagesabschluss'). The call will return HTTP 200 (single shipment) or 207 on success, with individual status elements for each shipment. Individual status elements are HTTP 200, 400. 400 will be returned when shipment does not exist (or was already deleted).
     *
     * @param array $queryParameters {
     *     @var string $profile Defines the user group profile. A user group is permitted to specific billing numbers. Shipments are only canceled if they belong to a billing number that the user group profile is entitled to use. This attribute is mandatory. Please use the standard user group profile 'STANDARD_GRUPPENPROFIL' if no dedicated user group profile is available.
     *     @var string $shipment Shipment number that shall be canceled. If multiple shipments shall be canceled, the parameter must be added multiple times. Up to 30 shipments can be canceled at once.
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
        return '/orders';
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
        $optionsResolver->setDefined(array('profile', 'shipment'));
        $optionsResolver->setRequired(array('profile', 'shipment'));
        $optionsResolver->setDefaults(array());
        $optionsResolver->addAllowedTypes('profile', array('string'));
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
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json');
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json');
            }
        }
        if (207 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json');
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json');
            }
        }
        if (is_null($contentType) === false && (400 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteBadRequestException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json'), $response);
        }
        if (is_null($contentType) === false && (401 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'), $response);
        }
        if (is_null($contentType) === false && (429 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'), $response);
        }
        if (is_null($contentType) === false && (500 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'), $response);
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('ApiKey', 'BasicAuth', 'OAuth2');
    }
}