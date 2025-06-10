<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Endpoint;

class GetManifests extends \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\Endpoint
{
    protected $accept;
    /**
    * Return the manifest document for the specific date (abbreviated ISO8601 format YYYY-MM-DD). If no date is provided, the manifest for today will be returned. The manifest PDF document will list the shipments for your EKP, separated by billing numbers. Potentially, the document is large and response time will reflect this. <br />Additionally, the response contains a mapping of billing numbers to sheet numbers of the manifest and a mapping of shipment numbers to sheet numbers.<br />The call can be repeated as often as needed. Should a date be provided which is too old or lies within the future, HTTP 400 is returned.
    *
    * @param array $queryParameters {
    *     @var string $billingNumber Customer billingNumber number.
    *     @var string $date 
    *     @var string $includeDocs Legacy name **labelResponseType**. Shipping labels and further shipment documents can be:
    * __include__: included as base64 encoded data in the response (default)
    * __URL__: provided as URL reference.
    Default is include the base64 encoded labels.
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
        return 'GET';
    }
    public function getUri() : string
    {
        return '/manifests';
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
        $optionsResolver->setDefined(array('billingNumber', 'date', 'includeDocs'));
        $optionsResolver->setRequired(array());
        $optionsResolver->setDefaults(array('includeDocs' => 'include'));
        $optionsResolver->addAllowedTypes('billingNumber', array('string'));
        $optionsResolver->addAllowedTypes('date', array('string'));
        $optionsResolver->addAllowedTypes('includeDocs', array('string'));
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
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsBadRequestException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsUnauthorizedException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsNotFoundException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsTooManyRequestsException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsInternalServerErrorException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\SingleManifestResponse
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
        if (200 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\SingleManifestResponse', 'json');
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\SingleManifestResponse', 'json');
            }
        }
        if (is_null($contentType) === false && (400 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsBadRequestException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json'), $response);
        }
        if (is_null($contentType) === false && (401 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'), $response);
        }
        if (is_null($contentType) === false && (404 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsNotFoundException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'), $response);
        }
        if (is_null($contentType) === false && (429 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'), $response);
        }
        if (is_null($contentType) === false && (500 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'), $response);
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('ApiKey', 'BasicAuth', 'OAuth2');
    }
}