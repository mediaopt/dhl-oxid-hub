<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Endpoint;

class RootGet extends \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\Endpoint
{
    protected $accept;
    /**
     * Returns the current version of the API as major.minor.patch. Furthermore, it will also return more details (semantic version number, revision, environment) of the API layer.
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
        return '/';
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
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetInternalServerErrorException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\ServiceInformation
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (is_null($contentType) === false && (200 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ServiceInformation', 'json');
        }
        if (is_null($contentType) === false && (401 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'), $response);
        }
        if (is_null($contentType) === false && (429 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'), $response);
        }
        if (is_null($contentType) === false && (500 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'), $response);
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('ApiKey', 'BasicAuth', 'OAuth2');
    }
}