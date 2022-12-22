<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Endpoint;

class ManifestsAccountGet extends \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\Endpoint
{
    protected $billingNumber;
    protected $accept;
    /**
     * Return the manifest document for the specific date (abbreviated ISO8601 format YYYY-MM-DD). If no date is provided, the manifest for today will be returned. Data will always be returned base64 encoded in the response. Currently, only a default paper format and PDF as docFormat are supported. The PDF document will list the shipments for your billingNumber (EKP), separated by billing numbers. Potentially, the document is large and response time will reflect this. The call can be repeated as often as needed. Should a date be provided which is too old or lies within the future, HTTP 400 is returned.
     *
     * @param string $billingNumber Customer billingNumber number.
     * @param array $queryParameters {
     *     @var string $date 
     *     @var string $docFormat *Defines* the **printable** document `format` to be used for label and manifest documents.
     *     @var string $paperType *Defines* size of the print medium for the shipping label. Pick from a number of supported options.
     *     @var string $includeDocs Legacy name **labelresponsetype**. Shipping labels and further shipment documents can be:  * __include__: included as base64 encoded data in the response  * __URL__: provided as URL reference.  * __data__: return only the data relevant for label creation. This option is not supported for the GET call, only for POST (create). This option may require certification and may not be available automatically. Talk to DHL should you consider using this option to build your own labels.  default is include the base64 encoded labels.
     * }
     * @param array $headerParameters {
     *     @var string $Accept-Language Control the APIs response language via locale abbreviation. English (en-US) and german (de-DE) are supported. If not specified, the default is english.
     * }
     * @param array $accept Accept content header application/json|application/problem+json
     */
    public function __construct(string $billingNumber, array $queryParameters = array(), array $headerParameters = array(), array $accept = array())
    {
        $this->billingNumber = $billingNumber;
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
        return str_replace(array('{billingNumber}'), array($this->billingNumber), '/v2/manifests');
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
        $optionsResolver->setDefined(array('date', 'docFormat', 'paperType', 'includeDocs'));
        $optionsResolver->setRequired(array());
        $optionsResolver->setDefaults(array('docFormat' => 'PDF', 'paperType' => '910-300-600', 'includeDocs' => 'include'));
        $optionsResolver->addAllowedTypes('date', array('string'));
        $optionsResolver->addAllowedTypes('docFormat', array('string'));
        $optionsResolver->addAllowedTypes('paperType', array('string'));
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
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetBadRequestException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetUnauthorizedException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetNotFoundException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetTooManyRequestsException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetInternalServerErrorException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetGatewayTimeoutException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\GetManifestResponse200
     */
    protected function transformResponseBody(string $body, int $status, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        if (200 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\GetManifestResponse200', 'json');
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\GetManifestResponse200', 'json');
            }
        }
        if (400 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetBadRequestException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetBadRequestException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (401 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (404 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetNotFoundException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetNotFoundException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (429 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (500 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (504 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetGatewayTimeoutException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetGatewayTimeoutException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('ApiKey', 'BasicAuth');
    }
}