<?php

namespace Mediaopt\DHL\Api\ParcelShipping;

class Client extends \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\Client
{
    /**
     * Returns the current version of the API as major.minor.patch. Furthermore, it will also return more details (semantic version number, revision, environment) of the API layer.
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @param array $accept Accept content header application/json|application/problem+json
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetUnauthorizedException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetTooManyRequestsException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetInternalServerErrorException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\ServiceInformation|\Psr\Http\Message\ResponseInterface
     */
    public function rootGet(string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\ParcelShipping\Endpoint\RootGet($accept), $fetch);
    }
    /**
     * Public download URL for shipment labels and documents. The URL is provided in the response of the POST /orders or GET /orders resources. The document is identified via the token query parameter. There is no additional authorization, the resource URL can be shared. Please protect the URL as needed. The call returns a PDF label.
     *
     * @param array $queryParameters {
     *     @var string $token Identifies PDF document and requested print settings for download.
     * }
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @param array $accept Accept content header application/pdf|application/problem+json
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelNotFoundException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelTooManyRequestsException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelInternalServerErrorException
     *
     * @return null|\Psr\Http\Message\ResponseInterface
     */
    public function getLabel(array $queryParameters = array(), string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\ParcelShipping\Endpoint\GetLabel($queryParameters, $accept), $fetch);
    }
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
    * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
    * @param array $accept Accept content header application/json|application/problem+json
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsBadRequestException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsUnauthorizedException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsNotFoundException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsTooManyRequestsException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetManifestsInternalServerErrorException
    *
    * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\SingleManifestResponse|\Psr\Http\Message\ResponseInterface
    */
    public function getManifests(array $queryParameters = array(), array $headerParameters = array(), string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\ParcelShipping\Endpoint\GetManifests($queryParameters, $headerParameters, $accept), $fetch);
    }
    /**
    * Shipments are normally ''closed out'' at a fixed time of the day (such as 6 pm, configured by EKP/account) for the date provided as shipDate in the create call.
    <br />This call allows forcing the closeout for sets of shipments earlier. This will also override the original shipDate. Afterwards, the shipment cannot be changed and the shipment labels cannot be queried anymore (however they may remain cached for limited duration).
    Once a shipment has been closed, then calling closeout for the same shipment will result in a warning. The same warning will also be returned if the automatic closeout happened prior to the call. It is however possible to add new shipments, they will be manifested as well and be part of the day's manifest.
    <br />Note on billing: The manifesting step has billing implications. Some products (Parcel International partially) are billed based on the shipment data available to DHL at the end of the day. All other products (including DHL Paket Standard) are billed based on production data. For more details, please contact your account representative.
    
    #### Request
    It's changing the status of the shipment, so parameters are provided in the body or as query parameter.
    * ''profile'' attribute (request body parameter) - defines the user group profile. A user group is permitted to specific billing numbers. Shipments are only closed out if they belong to a billing number that the user group profile is entitled to use. This attribute is mandatory. Please use the standard user group profile ''STANDARD_GRUPPENPROFIL'' if no dedicated user group profile is available.
    * ''billingNumber'' attribute (query parameter) - defines the billing number for which shipments shall be closed out. If a billing number is set, then only the shipments of that billing number are closed out. In that case no list of specific shipment numbers needs to be passed.
    * ''shipmentNumbers'' attribute (request body parameter) - lists the specific shipping numbers of the shipments that shall be closed out.
    If all shipments shall be closed, the query parameter ''all'' needs to be set to ''true''. In that case neither a billing number nor a list of shipment numbers need to be passed in the request.
    
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
    * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
    * @param array $accept Accept content header application/json|application/problem+json
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsPostBadRequestException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsPostUnauthorizedException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsPostTooManyRequestsException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsPostInternalServerErrorException
    *
    * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\MultipleManifestResponse|\Psr\Http\Message\ResponseInterface
    */
    public function manifestsPost(\Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentManifestingRequest $requestBody, array $queryParameters = array(), array $headerParameters = array(), string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\ParcelShipping\Endpoint\ManifestsPost($requestBody, $queryParameters, $headerParameters, $accept), $fetch);
    }
    /**
     * Delete one or more shipments created earlier. Deletion of shipments is only possible prior to them being manifested (closed out, 'Tagesabschluss'). The call will return HTTP 200 (single shipment) or 207 on success, with individual status elements for each shipment. Individual status elements are HTTP 200, 400. 400 will be returned when shipment does not exist (or was already deleted).
     *
     * @param array $queryParameters {
     *     @var string $profile Defines the user group profile. A user group is permitted to specific billing numbers. Shipments are only canceled if they belong to a billing number that the user group profile is entitled to use. This attribute is mandatory. Please use the standard user group profile 'STANDARD_GRUPPENPROFIL' if no dedicated user group profile is available.
     *     @var string $shipment Shipment number that shall be canceled. If multiple shipments shall be canceled, the parameter must be added multiple times. Up to 30 shipments can be canceled at once.
     * }
     * @param array $headerParameters {
     *     @var string $Accept-Language Control the APIs response language via locale abbreviation. English (en-US) and german (de-DE) are supported. If not specified, the default is english.
     * }
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @param array $accept Accept content header application/json|application/problem+json
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteBadRequestException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteUnauthorizedException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteTooManyRequestsException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersAccountDeleteInternalServerErrorException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\LabelDataResponse|\Psr\Http\Message\ResponseInterface
     */
    public function ordersAccountDelete(array $queryParameters = array(), array $headerParameters = array(), string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\ParcelShipping\Endpoint\OrdersAccountDelete($queryParameters, $headerParameters, $accept), $fetch);
    }
    /**
    * Returns documents for existing shipment(s). The call accepts multiple shipment numbers and will provide sets of documents for those. The **format (PDF,ZPL)** and **method of delivery (URL, encoded, data)** can be selected for **all** shipments and labels in that call. You cannot chose one format and delivery method for one label and different for another label within the same call. You can also specify if you want regular labels, return labels, cod labels, or customsDoc. Any combination is possible.
    
    The call returns for each shipment number the status indicator and the selected labels and documents. If a label type (for example a cod label) does not exist for a shipment, it will not be returned. This is not an error. If you were sending multiple shipments, you will get an HTTP 207 response (multistatus) with detailed status for each shipment. Other standard HTTP response codes (200, 400, 401, 429, 500) are possible as well. Labels can be either provided as part of the response (base64 encoded for PDF, text for ZPL) or via URL link for view and download (PDF). Note that the format settings per query parameters apply to the shipping label. Retoure label paper type can be specified separately since a different printer may be used here. If requesting labels to be returned as URL for separate download, the URLs provided can be shared.
    *
    * @param array $queryParameters {
    *     @var array $shipment This parameter identifies shipments. The parameter can be used multiple times in one request to get the labels and/or documents for up to 30 shipments maximum. Only documents and label for shipments that are not yet closed can be retrieved.
    *     @var string $docFormat **Defines** the **printable** document format to be used for label and manifest documents.
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
    *     @var string $includeDocs Legacy name **labelResponseType**. Shipping labels and further shipment documents can be:
    * __include__: included as base64 encoded data in the response (default)
    * __URL__: provided as URL reference.
    Default is include the base64 encoded labels.
    *     @var bool $combine If set, label and return label for one shipment will be printed as single PDF document with possibly multiple pages. Else, those two labels come as separate documents. The option does not affect customs documents and COD labels.
    * }
    * @param array $headerParameters {
    *     @var string $Accept-Language Control the APIs response language via locale abbreviation. English (en-US) and german (de-DE) are supported. If not specified, the default is english.
    * }
    * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
    * @param array $accept Accept content header application/json|application/problem+json
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetOrderBadRequestException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetOrderUnauthorizedException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetOrderNotFoundException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetOrderTooManyRequestsException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetOrderInternalServerErrorException
    *
    * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\LabelDataResponse|\Psr\Http\Message\ResponseInterface
    */
    public function getOrder(array $queryParameters = array(), array $headerParameters = array(), string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\ParcelShipping\Endpoint\GetOrder($queryParameters, $headerParameters, $accept), $fetch);
    }
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
    * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
    * @param array $accept Accept content header application/json|application/problem+json
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\CreateOrdersBadRequestException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\CreateOrdersUnauthorizedException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\CreateOrdersTooManyRequestsException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\CreateOrdersInternalServerErrorException
    *
    * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\LabelDataResponse|\Psr\Http\Message\ResponseInterface
    */
    public function createOrders(\Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentOrderRequest $requestBody, array $queryParameters = array(), array $headerParameters = array(), string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\ParcelShipping\Endpoint\CreateOrders($requestBody, $queryParameters, $headerParameters, $accept), $fetch);
    }
    public static function create($httpClient = null, array $additionalPlugins = array(), array $additionalNormalizers = array())
    {
        if (null === $httpClient) {
            $httpClient = \Http\Discovery\Psr18ClientDiscovery::find();
            $plugins = array();
            $uri = \Http\Discovery\Psr17FactoryDiscovery::findUriFactory()->createUri('https://api-eu.dhl.com/parcel/de/shipping/v2');
            $plugins[] = new \Http\Client\Common\Plugin\AddHostPlugin($uri);
            $plugins[] = new \Http\Client\Common\Plugin\AddPathPlugin($uri);
            if (count($additionalPlugins) > 0) {
                $plugins = array_merge($plugins, $additionalPlugins);
            }
            $httpClient = new \Http\Client\Common\PluginClient($httpClient, $plugins);
        }
        $requestFactory = \Http\Discovery\Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = \Http\Discovery\Psr17FactoryDiscovery::findStreamFactory();
        $normalizers = array(new \Symfony\Component\Serializer\Normalizer\ArrayDenormalizer(), new \Mediaopt\DHL\Api\ParcelShipping\Normalizer\JaneObjectNormalizer());
        if (count($additionalNormalizers) > 0) {
            $normalizers = array_merge($normalizers, $additionalNormalizers);
        }
        $serializer = new \Symfony\Component\Serializer\Serializer($normalizers, array(new \Symfony\Component\Serializer\Encoder\JsonEncoder(new \Symfony\Component\Serializer\Encoder\JsonEncode(), new \Symfony\Component\Serializer\Encoder\JsonDecode(array('json_decode_associative' => true)))));
        return new static($httpClient, $requestFactory, $serializer, $streamFactory);
    }
}