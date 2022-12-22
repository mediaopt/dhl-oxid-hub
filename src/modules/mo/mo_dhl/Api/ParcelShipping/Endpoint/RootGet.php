<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Endpoint;

class RootGet extends \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\Endpoint
{
    protected $accept;
    /**
     * Returns the current version of the API as major.minor.patch. This functions exists for historic reasons. Furthermore, it will also return more details (semantic version number, revision, environment) of the API layer.
     *
     * @param array $accept Accept content header application/json|application/problem+json
     */
    public function __construct(array $accept = array())
    {
        $this->accept = $accept;
    }
    use \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\EndpointTrait;
    public function getMethod() : string
    {
        return 'GET';
    }
    public function getUri() : string
    {
        return '/v2';
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
    /**
     * {@inheritdoc}
     *
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetUnauthorizedException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetTooManyRequestsException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\ApiVersionResponse
     */
    protected function transformResponseBody(string $body, int $status, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        if (200 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ApiVersionResponse', 'json');
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ApiVersionResponse', 'json');
            }
        }
        if (401 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (429 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('ApiKey');
    }
}