<?php

namespace Mediaopt\DHL\Api\Authentication\Endpoint;

class DispenseToken extends \Mediaopt\DHL\Api\Authentication\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\Authentication\Runtime\Client\Endpoint
{
    /**
    * The client makes a request to the token endpoint by adding the following parameters 
    using the application/x-www-form-urlencoded format with a character
    encoding of UTF-8 in the HTTP request entity-body:
    
    * grant_type __REQUIRED__. Must be set to "password" or "refresh_token".
    
    * client_id __REQUIRED__ (aka client_id (api key))
    
    * client_secret __REQUIRED__ (aka client_secret)
    
    Depending on the grant_type, __additional parameters__ must be provided:
    
    <h3>grant_type=password</h3>
    
    This currently is the only grant type supported.
    
    * username __REQUIRED__. The resource owner username. Aka username for business customer portal
    
    * password __REQUIRED__. The resource owner password. Aka password for business customer portal
    
    *
    * @param \Mediaopt\DHL\Api\Authentication\Model\TokenPostBody $requestBody 
    */
    public function __construct(\Mediaopt\DHL\Api\Authentication\Model\TokenPostBody $requestBody)
    {
        $this->body = $requestBody;
    }
    use \Mediaopt\DHL\Api\Authentication\Runtime\Client\EndpointTrait;
    public function getMethod() : string
    {
        return 'POST';
    }
    public function getUri() : string
    {
        return '/token';
    }
    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null) : array
    {
        if ($this->body instanceof \Mediaopt\DHL\Api\Authentication\Model\TokenPostBody) {
            return array(array('Content-Type' => array('application/x-www-form-urlencoded')), http_build_query($serializer->normalize($this->body, 'json')));
        }
        return array(array(), null);
    }
    public function getExtraHeaders() : array
    {
        return array('Accept' => array('application/json'));
    }
    /**
     * {@inheritdoc}
     *
     * @throws \Mediaopt\DHL\Api\Authentication\Exception\DispenseTokenBadRequestException
     * @throws \Mediaopt\DHL\Api\Authentication\Exception\DispenseTokenUnauthorizedException
     * @throws \Mediaopt\DHL\Api\Authentication\Exception\DispenseTokenForbiddenException
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
            throw new \Mediaopt\DHL\Api\Authentication\Exception\DispenseTokenBadRequestException($response);
        }
        if (401 === $status) {
            throw new \Mediaopt\DHL\Api\Authentication\Exception\DispenseTokenUnauthorizedException($response);
        }
        if (403 === $status) {
            throw new \Mediaopt\DHL\Api\Authentication\Exception\DispenseTokenForbiddenException($response);
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('bearerAuth', 'basicAuth', 'apiKey');
    }
}