<?php

namespace Mediaopt\DHL\Api\Authentication\Endpoint;

class Hello extends \Mediaopt\DHL\Api\Authentication\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\Authentication\Runtime\Client\Endpoint
{
    use \Mediaopt\DHL\Api\Authentication\Runtime\Client\EndpointTrait;
    public function getMethod() : string
    {
        return 'GET';
    }
    public function getUri() : string
    {
        return '/hello';
    }
    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null) : array
    {
        return array(array(), null);
    }
    public function getExtraHeaders() : array
    {
        return array('Accept' => array('application/json'));
    }
    /**
     * {@inheritdoc}
     *
     * @throws \Mediaopt\DHL\Api\Authentication\Exception\HelloBadRequestException
     * @throws \Mediaopt\DHL\Api\Authentication\Exception\HelloUnauthorizedException
     * @throws \Mediaopt\DHL\Api\Authentication\Exception\HelloForbiddenException
     *
     * @return null|\Mediaopt\DHL\Api\Authentication\Model\TokenResponse
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (is_null($contentType) === false && (200 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\Authentication\\Model\\TokenResponse', 'json');
        }
        if (400 === $status) {
            throw new \Mediaopt\DHL\Api\Authentication\Exception\HelloBadRequestException($response);
        }
        if (401 === $status) {
            throw new \Mediaopt\DHL\Api\Authentication\Exception\HelloUnauthorizedException($response);
        }
        if (403 === $status) {
            throw new \Mediaopt\DHL\Api\Authentication\Exception\HelloForbiddenException($response);
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('bearerAuth', 'basicAuth', 'apiKey');
    }
}