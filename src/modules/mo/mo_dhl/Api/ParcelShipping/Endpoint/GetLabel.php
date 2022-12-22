<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Endpoint;

class GetLabel extends \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\BaseEndpoint implements \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\Endpoint
{
    protected $accept;
    /**
    * Returns documents for existing shipment(s). The call accepts multiple shipment numbers and will provide sets of documents for those. The **format (PDF,ZPL)** and **method of delivery (URL, encoded, data)** can be selected for **all** shipments and labels in that call. You cannot chose one format and delivery method for one label and different for another label within the same call. You can also specify if you want regular labels, return labels, cod labels, or customsDoc. Any combination is possible.
    
    The call returns for each shipment number the status indicator and the selected labels and documents. If a label type (for example a cod label) does not exist for a shipment, it will not be returned. This is not an error. If you were sending multiple shipments, you will get an HTTP 207 response (multistatus) with detailed status for each shipment. Other standard HTTP response codes (200, 400, 401, 429, 500) are possible as well. Labels can be either provided as part of the response (base64 encoded for PDF, text for ZPL) or via URL link for view and download (PDF). Note that the format settings per query parameters apply to the shipping label. Retoure label paper type can be specified separately since a different printer may be used here. If requesting labels to be returned as URL for separate download, the URLs provided can be shared.
    *
    * @param array $queryParameters {
    *     @var string $shipment This parameter identifies shipments. The parameter can be used multiple times in one request to get the labels and/or documents for up to 30 shipments maximum. Only documents and label for shipments that are not yet closed can be retrieved.
    *     @var string $docFormat **Defines** the **printable** document `format` to be used for label and manifest documents.
    *     @var string $printFormat **Defines** the print medium for the shipping label. The different option vary from standard papersizes DIN A4 and DIN A5 to specific label print formats. 
    
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
    *     @var string $retourePrintFormat **Defines** the print medium for the return shipping label. This parameter is only usable, if you do not use **combined printing**. The different option vary from standard papersizes DIN A4 and DIN A5 to specific label print formats. 
    
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
    *     @var string $includeDocs Legacy name **labelresponsetype**. Shipping labels and further shipment documents can be:
    * __include__: included as base64 encoded data in the response
    * __URL__: provided as URL reference.
    * __data__: return only the data relevant for label creation. This option is not supported for the GET call, only for POST (create). This option may require certification and may not be available automatically. Talk to DHL should you consider using this option to build your own labels.
    default is include the base64 encoded labels.
    *     @var bool $combine If set, label and return label for one shipment will be printed as single PDF document with possibly multiple pages. Else, those two labels come as separate documents. The option does not affect customs documents and COD labels.
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
        return '/v2/orders';
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
        $optionsResolver->setDefined(array('shipment', 'docFormat', 'printFormat', 'retourePrintFormat', 'includeDocs', 'combine'));
        $optionsResolver->setRequired(array('shipment'));
        $optionsResolver->setDefaults(array('docFormat' => 'PDF', 'includeDocs' => 'include', 'combine' => true));
        $optionsResolver->addAllowedTypes('shipment', array('string'));
        $optionsResolver->addAllowedTypes('docFormat', array('string'));
        $optionsResolver->addAllowedTypes('printFormat', array('string'));
        $optionsResolver->addAllowedTypes('retourePrintFormat', array('string'));
        $optionsResolver->addAllowedTypes('includeDocs', array('string'));
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
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelBadRequestException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelUnauthorizedException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelNotFoundException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelTooManyRequestsException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelInternalServerErrorException
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
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelBadRequestException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelBadRequestException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (401 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelUnauthorizedException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (404 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelNotFoundException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelNotFoundException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (429 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelTooManyRequestsException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
        if (500 === $status) {
            if (mb_strpos($contentType, 'application/json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
            if (mb_strpos($contentType, 'application/problem+json') !== false) {
                throw new \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelInternalServerErrorException($serializer->deserialize($body, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ErrorResponse', 'json'));
            }
        }
    }
    public function getAuthenticationScopes() : array
    {
        return array('ApiKey', 'BasicAuth');
    }
}