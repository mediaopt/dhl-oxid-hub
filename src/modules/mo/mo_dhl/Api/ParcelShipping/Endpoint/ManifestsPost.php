<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Endpoint;

class ManifestsPost extends \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\Endpoint
{
    protected $accept;
    /**
    * Shipments are normally ''closed out'' at a fixed time of the day (such as 6 pm, configured by EKP/account) for the date provided as shipDate in the create call. 
    <br />This call allows forcing the closeout for sets of shipments earlier. This will also override the original shipDate. Afterwards, the shipment cannot be changed and the shipment labels cannot be queried anymore (however they may remain cached for limited duration). 
    Calling closeout repeatedly for the same shipments will result in HTTP 400 for the second call. HTTP 400 will also be returned if the automatic closeout happened prior to the call. It is however possible to add new shipments, they will be manifested as well and be part of the day's manifest. 
    <br />Note on billing: The manifesting step has billing implications. Some products (Warenpost, Parcel International partially) are billed based on the shipment data available to DHL at the end of the day. All other products (including DHL Paket Standard) are billed based on production data. For more details, please contact your account representative. 
    
    #### Request
    It's changing the status of the shipment, so parameters are provided in the body. 
    * ''profile'' attribute - defines the user group profile. A user group is permitted to specific billing numbers. Shipments are only closed out if they belong to a billing number that the user group profile is entitled to use. This attribute is mandatory. Please use the standard user group profile ''STANDARD_GRUPPENPROFIL'' if no dedicated user group profile is available. 
    * ''billingNumber'' attribute - defines the billing number for which shipments shall be closed out. If a billing number is set, then only the shipments of that billing number are closed out. In that case no list of specific shipment numbers needs to be passed. 
    * ''shipmentNumbers'' attribute - lists the specific shipping numbers of the shipments that shall be closed out. 
    If all shipments shall be closed, the query parameter ''all'' needs to be set to ''true''. In that case neither a billing number nor a list of shipment numbers need to be passed in the request body. 
    
    #### Response 
    * Closing status for each shipment
    *
    * @param \Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentManifestingRequest $requestBody 
    * @param array $queryParameters {
    *     @var bool $all Specify if all applicable shipments shall be marked as being ready for shipping.
    * }
    * @param array $headerParameters {
    *     @var string $Accept-Language Control the APIs response language via locale abbreviation. English (en-US) and german (de-DE) are supported. If not specified, the default is english.
    * }
    * @param array $accept Accept content header application/json|application/problem+json
    */
    public function __construct(\Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentManifestingRequest $requestBody, array $queryParameters = array(), array $headerParameters = array(), array $accept = array())
    {
        $this->body = $requestBody;
        $this->queryParameters = $queryParameters;
        $this->headerParameters = $headerParameters;
        $this->accept = $accept;
    }
    use \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\EndpointTrait;
    public function getMethod() : string
    {
        return 'POST';
    }
    public function getUri() : string
    {
        return '/manifests';
    }
    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null) : array
    {
        if ($this->body instanceof \Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentManifestingRequest) {
            return array(array('Content-Type' => array('application/json')), $serializer->serialize($this->body, 'json'));
        }
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
        $optionsResolver->setDefined(array('all'));
        $optionsResolver->setRequired(array());
        $optionsResolver->setDefaults(array('all' => false));
        $optionsResolver->addAllowedTypes('all', array('bool'));
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
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsPostBadRequestException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsPostUnauthorizedException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsPostTooManyRequestsException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsPostInternalServerErrorException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\MultipleManifestResponse
     */
    protected function transformResponseBody(string $body, int $status, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        if (207 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\MultipleManifestResponse', 'json');
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\MultipleManifestResponse', 'json');
            }
        }
        if (is_null($contentType) === false && (400 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsPostBadRequestException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'));
        }
        if (is_null($contentType) === false && (401 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsPostUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'));
        }
        if (is_null($contentType) === false && (429 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsPostTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'));
        }
        if (is_null($contentType) === false && (500 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsPostInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'));
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('ApiKey', 'BasicAuth');
    }
}