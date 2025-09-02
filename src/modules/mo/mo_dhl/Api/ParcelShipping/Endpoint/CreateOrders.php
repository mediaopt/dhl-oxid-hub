<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Endpoint;

class CreateOrders extends \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\Endpoint
{
    protected $accept;
    /**
    * This request is used to create one or more shipments and return corresponding shipment tracking numbers, labels, and documentation. Up to 30 shipments can be created in a single call.
    #### Request
    The selected products and corresponding billing numbers, as well as the desired services and package details are required to create a shipment. Each shipment can have a dedicated shipper address. The example request body contains sample values for most services.
    #### Response
    The request will return shipment tracking numbers and the applicable labels for each shipment. If multiple shipments have been included, an HTTP 207 response (multistatus) is returned and holds detailed status for each shipment. Other standard HTTP response codes (401, 500, 400, 200, 429) are possible, too. Labels can be either provided as part of the response (base64 encoded for PDF, text for ZPL) or via URL link for view and download. Note that the format settings per query parameters apply to the shipping label. It may also apply to other labels included, depending on the configuration of your account. Label paper for return shipments can be specified separately since a different printer may be used here. If requesting labels to be provided as URL for separate download, the URLs can be shared.
    #### Validation
    It is recommended to validate the request first prior to shipment creation by setting the `validate` query parameter to `true`. Especially, during development and test, it is recommended to perform this validation. This functionality supports both
    * JSON schema validation (against this API description). During development and test, it is recommended to do this validation. JSON schema is available for local validation
    * Dry run against the DHL backend
    
    If this succeeds, actual shipment creation will also succeed.
    *
    * @param \Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentOrderRequest $requestBody 
    * @param array $queryParameters {
    *     @var bool $validate If provided and set to `true`, the input document will be:
    * validated against JSON schema (/orders/ endpoint) at the API layer. In case of errors, HTTP 400 and details will be returned.
    * validated against the DHL backend.
    
    In that case, no state changes are happening, no data is stored, shipments neither deleted nor created, no labels being returned. The call will return a status (200, 400) for each shipment element.
    *     @var bool $mustEncode Legacy name **printOnlyIfCodable**. If set to *true*, labels will only be created if an address is encodable. This is only relevant for German consignee addresses. If set to false or left out, addresses, that are not encodable will be printed even though you receive a warning.
    *     @var string $includeDocs Legacy name **labelResponseType**. Shipping labels and further shipment documents can be:
    * __include__: included as base64 encoded data in the response (default)
    * __URL__: provided as URL reference.
    *     @var string $docFormat **Defines** the **printable** document format to be used for label and manifest documents.
    *     @var string $printFormat **Defines** the print medium for the shipping label. The different option vary from standard paper sizes DIN A4 and DIN A5 to specific label print formats.
    
    Specific laser print formats using DIN A5 blanks are:
    * 910-300-600(-oz) (105 x 205mm)
    * 910-300-300(-oz) (105 x 148mm)
    
    Specific laser print formats **not** using a DIN A5 blank:
    * 910-300-610 (105 x 208mm)
    * 100x70mm
    
    Specific thermal print formats:
    * 910-300-600 (103 x 199mm)
    * 910-300-400 (103 x 150mm)
    * 100x70mm
    
    Please use the different formats as follows. If you do not set the parameter the settings of DHL costumer portal account will be used as default.
    *     @var string $retourePrintFormat **Defines** the print medium for the return shipping label. This parameter is only usable, if you do not use **combined printing**. The different option vary from standard paper sizes DIN A4 and DIN A5 to specific label print formats.
    
    Specific laser print formats using DIN A5 blanks are:
    * 910-300-600(-oz) (105 x 205mm)
    * 910-300-300(-oz) (105 x 148mm)
    
    Specific laser print formats **not** using a DIN A5 blank:
    * 910-300-610 (105 x 208mm)
    * 100x70mm
    
    Specific thermal print formats:
    * 910-300-600 (103 x 199mm)
    * 910-300-400 (103 x 150mm)
    * 100x70mm
    
    Please use the different formats as follows. If you do not set the parameter the settings of DHL costumer portal account will be used as default.
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
        return '/orders';
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
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\CreateOrdersBadRequestException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\CreateOrdersUnauthorizedException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\CreateOrdersTooManyRequestsException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\CreateOrdersInternalServerErrorException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\LabelDataResponse
     */
    protected function transformResponseBody(\Psr\Http\Message\ResponseInterface $response, \Symfony\Component\Serializer\SerializerInterface $serializer, ?string $contentType = null)
    {
        $status = $response->getStatusCode();
        $body = (string) $response->getBody();
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
        if (is_null($contentType) === false && (400 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\CreateOrdersBadRequestException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse', 'json'), $response);
        }
        if (is_null($contentType) === false && (401 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\CreateOrdersUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'), $response);
        }
        if (is_null($contentType) === false && (429 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\CreateOrdersTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'), $response);
        }
        if (is_null($contentType) === false && (500 === $status && mb_strpos($contentType, 'application/problem+json') !== false)) {
            throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\CreateOrdersInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json'), $response);
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('ApiKey', 'BasicAuth', 'OAuth2');
    }
}