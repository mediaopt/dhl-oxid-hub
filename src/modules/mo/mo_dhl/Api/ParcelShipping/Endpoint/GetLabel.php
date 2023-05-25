<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Endpoint;

class GetLabel extends \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\Endpoint
{
    protected $accept;
    /**
     * Public download URL for shipment labels and documents. The URL is provided in the response of the POST /orders or GET /orders resources. The document is identified via the token query parameter. There is no additional authorization, the resource URL can be shared. Please protect the URL as needed. The call returns a PDF label.
     *
     * @param array $queryParameters {
     *     @var string $token Identifies PDF document and requested print settings for download.
     * }
     * @param array $accept Accept content header application/pdf|application/json|application/problem+json
     */
    public function __construct(array $queryParameters = array(), array $accept = array())
    {
        $this->queryParameters = $queryParameters;
        $this->accept = $accept;
    }
    use \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\EndpointTrait;
    public function getMethod() : string
    {
        return 'GET';
    }
    public function getUri() : string
    {
        return '/labels';
    }
    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null) : array
    {
        return array(array(), null);
    }
    public function getExtraHeaders() : array
    {
        if (empty($this->accept)) {
            return array('Accept' => array('application/pdf', 'application/json', 'application/problem+json'));
        }
        return $this->accept;
    }
    protected function getQueryOptionsResolver() : \Symfony\Component\OptionsResolver\OptionsResolver
    {
        $optionsResolver = parent::getQueryOptionsResolver();
        $optionsResolver->setDefined(array('token'));
        $optionsResolver->setRequired(array('token'));
        $optionsResolver->setDefaults(array());
        $optionsResolver->addAllowedTypes('token', array('string'));
        return $optionsResolver;
    }
    /**
     * {@inheritdoc}
     *
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelNotFoundException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelTooManyRequestsException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelInternalServerErrorException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\LabelDataResponse
     */
    protected function transformResponseBody(string $body, int $status, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        if (is_null($contentType) === false && (200 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json');
        }
        if (is_null($contentType) === false && (404 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelNotFoundException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'));
        }
        if (is_null($contentType) === false && (429 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'));
        }
        if (is_null($contentType) === false && (500 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'));
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array();
    }
}