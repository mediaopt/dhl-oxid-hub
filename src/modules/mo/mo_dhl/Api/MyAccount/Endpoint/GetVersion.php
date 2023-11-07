<?php

namespace Mediaopt\DHL\Api\MyAccount\Endpoint;

class GetVersion extends \Mediaopt\DHL\Api\MyAccount\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\MyAccount\Runtime\Client\Endpoint
{
    protected $accept;
    /**
     * Returns the current version of the API as major.minor.patch. If a valid access token is provided, it will also return more details (semantic version number, revision, environment) of the backend layer. The function can be used for healthcheck; it does support content negotiation and can also be called from a browser.
     *
     * @param array $accept Accept content header application/json|text/html
     */
    public function __construct(array $accept = array())
    {
        $this->accept = $accept;
    }
    use \Mediaopt\DHL\Api\MyAccount\Runtime\Client\EndpointTrait;
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
        return array('Accept' => array('application/json'));
    }
    /**
     * {@inheritdoc}
     *
     * @throws \Mediaopt\DHL\Api\MyAccount\Exception\GetVersionUnauthorizedException
     *
     * @return null|\Mediaopt\DHL\Api\MyAccount\Model\ApiVersionResponse
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (is_null($contentType) === false && (200 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponse', 'json');
        }
        if (401 === $status) {
            throw new \Mediaopt\DHL\Api\MyAccount\Exception\GetVersionUnauthorizedException($response);
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('security_auth');
    }
}