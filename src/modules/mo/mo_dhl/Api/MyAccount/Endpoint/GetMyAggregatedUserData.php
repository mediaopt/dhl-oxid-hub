<?php

namespace Mediaopt\DHL\Api\MyAccount\Endpoint;

class GetMyAggregatedUserData extends \Mediaopt\DHL\Api\MyAccount\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\MyAccount\Runtime\Client\Endpoint
{
    /**
     * 
     *
     * @param array $queryParameters {
     *     @var string $lang language for localized texts
     * }
     */
    public function __construct(array $queryParameters = array())
    {
        $this->queryParameters = $queryParameters;
    }
    use \Mediaopt\DHL\Api\MyAccount\Runtime\Client\EndpointTrait;
    public function getMethod() : string
    {
        return 'GET';
    }
    public function getUri() : string
    {
        return '/user';
    }
    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null) : array
    {
        return array(array(), null);
    }
    public function getExtraHeaders() : array
    {
        return array('Accept' => array('application/json'));
    }
    protected function getQueryOptionsResolver() : \Symfony\Component\OptionsResolver\OptionsResolver
    {
        $optionsResolver = parent::getQueryOptionsResolver();
        $optionsResolver->setDefined(array('lang'));
        $optionsResolver->setRequired(array('lang'));
        $optionsResolver->setDefaults(array());
        $optionsResolver->addAllowedTypes('lang', array('string'));
        return $optionsResolver;
    }
    /**
     * {@inheritdoc}
     *
     * @throws \Mediaopt\DHL\Api\MyAccount\Exception\GetMyAggregatedUserDataBadRequestException
     * @throws \Mediaopt\DHL\Api\MyAccount\Exception\GetMyAggregatedUserDataUnauthorizedException
     *
     * @return null|\Mediaopt\DHL\Api\MyAccount\Model\AggregatedUserDataResponse
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (is_null($contentType) === false && (200 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\AggregatedUserDataResponse', 'json');
        }
        if (is_null($contentType) === false && (400 === $status && mb_strpos($contentType, 'application/json') !== false)) {
            throw new \Mediaopt\DHL\Api\MyAccount\Exception\GetMyAggregatedUserDataBadRequestException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\RequestStatus', 'json'), $response);
        }
        if (401 === $status) {
            throw new \Mediaopt\DHL\Api\MyAccount\Exception\GetMyAggregatedUserDataUnauthorizedException($response);
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('security_auth');
    }
}