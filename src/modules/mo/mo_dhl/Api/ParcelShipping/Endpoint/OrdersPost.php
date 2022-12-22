<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Endpoint;

class OrdersPost extends \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\Endpoint
{
    protected $accept;
    /**
    *  Create one or more shipments and return corresponding shipment tracking numbers, labels, and documentation. Up to 30 shipments can be created in a single call. #### Validation  It is recommended to validate the request first prior to shipment creation by setting the `validate` query parameter to `true`.  This functionality supports both * JSON schema validation (against this API description). During development and test, it is recommended to do this validation. JSON schema is available for local validation (should be made available for download, until then, please ask) * Dry run against the DHL backend. If this succeeds, actual shipment creation will also succeed. ### Request You will need the chosen products, the desired product features (__services__), the corresponding billing numbers, and details about the packages you are planning to ship. Each shipment can have a dedicated shipper address. Please note that you can pick working samples for most products if you are using the try-out function. ### Response The call will return shipment numbers (which can be used for tracking) and the applicable labels for each shipment. If you were sending multiple shipments, you will get an `HTTP 207` response (multistatus) with detailed status for each shipment. Other standard HTTP response codes (401, 500, 400, 200, 429) are possible, too. Labels can be either provided as part of the response (base64 encoded for PDF, text for ZPL) or via URL link for view and download. Note that the format settings per query parameters apply to the shipping label. It _may_ also apply to other labels included, depending on the configuration of your account. Retoure label paper type can be specified separately since a different printer may be used here. If requesting labels to be returned as URL for separate download, the URLs provided can be shared and provide a very fast download experience. Further, it is possible to obtain only the data (routing information, barcode type, and shipmentnumber/trackingnumber per label.)
    *
    * @param \Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentOrderRequest $requestBody 
    * @param array $queryParameters {
    *     @var bool $validate If provided and set to `true`, the input document will be: * validated against JSON schema (/orders/ endpoint) at the API layer. On errors, HTTP 400 and details will be returned. * validated against the DHL backend: In that case, no state changes are happening, no data is stored, shipments neither deleted nor created, no labels being returned. The call will return a status (200, 400) for each shipment element.
    *     @var bool $mustEncode Legacy name **printOnlyIfCodable**. If *true* Labels will only be created if neither hard nor soft validation errors exist for this shipment. Else, labels will be created even if soft validation errors exist.
    *     @var string $includeDocs Legacy name **labelresponsetype**. Shipping labels and further shipment documents can be:
    * __include__: included as base64 encoded data in the response
    * __URL__: provided as URL reference.
    * __data__: return only the data relevant for label creation. This option is not supported for the GET call, only for POST (create). This option may require certification and may not be available automatically. Talk to DHL should you consider using this option to build your own labels.
    default is include the base64 encoded labels.
    *     @var string $docFormat *Defines* the **printable** document `format` to be used for label and manifest documents.
    *     @var string $printFormat *Defines* size of the print medium for the shipping label. Pick from a number of supported options.
    *     @var string $retourePrintFormat *Defines* size of the print medium for the return/retoure label. Pick from a number of supported options. If not provided, default from user profile will be used (not necessarily being the label paper)
    *     @var bool $combine If set, label and return label for one shipment will be printed as single PDF document with possibly multiple pages. Else, those two labels come as separate documents. The option does not affect customs documents and COD labels.
    * }
    * @param array $headerParameters {
    *     @var string $Accept-Language Control the APIs response language via locale abbreviation. English (en-US) and german (de-DE) are supported. If not specified, the default is english.
    * }
    * @param array $accept Accept content header application/json|application/problem+json
    */
    public function __construct(\Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentOrderRequest $requestBody, array $queryParameters = array(), array $headerParameters = array(), array $accept = array())
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
        return '/v2/orders';
    }
    public function getBody(\Symfony\Component\Serializer\SerializerInterface $serializer, $streamFactory = null) : array
    {
        if ($this->body instanceof \Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentOrderRequest) {
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
        $optionsResolver->setDefined(array('validate', 'mustEncode', 'includeDocs', 'docFormat', 'printFormat', 'retourePrintFormat', 'combine'));
        $optionsResolver->setRequired(array());
        $optionsResolver->setDefaults(array('validate' => false, 'mustEncode' => false, 'includeDocs' => 'include', 'docFormat' => 'PDF', 'combine' => true));
        $optionsResolver->addAllowedTypes('validate', array('bool'));
        $optionsResolver->addAllowedTypes('mustEncode', array('bool'));
        $optionsResolver->addAllowedTypes('includeDocs', array('string'));
        $optionsResolver->addAllowedTypes('docFormat', array('string'));
        $optionsResolver->addAllowedTypes('printFormat', array('string'));
        $optionsResolver->addAllowedTypes('retourePrintFormat', array('string'));
        $optionsResolver->addAllowedTypes('combine', array('bool'));
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
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostBadRequestException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostUnauthorizedException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostTooManyRequestsException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostInternalServerErrorException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostGatewayTimeoutException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\LabelDataResponse
     */
    protected function transformResponseBody(string $body, int $status, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        if (200 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json');
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json');
            }
        }
        if (207 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json');
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                return $serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json');
            }
        }
        if (400 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostBadRequestException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostBadRequestException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (401 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (429 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (500 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (504 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostGatewayTimeoutException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostGatewayTimeoutException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('ApiKey', 'BasicAuth');
    }
}