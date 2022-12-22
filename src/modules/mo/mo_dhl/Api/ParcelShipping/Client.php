<?php

namespace Mediaopt\DHL\Api\ParcelShipping;

class Client extends \Mediaopt\DHL\Api\ParcelShipping\Runtime\Client\Client
{
    /**
     * Returns the current version of the API as major.minor.patch. This functions exists for historic reasons. Furthermore, it will also return more details (semantic version number, revision, environment) of the API layer.
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @param array $accept Accept content header application/json|application/problem+json
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetUnauthorizedException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\RootGetTooManyRequestsException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\ApiVersionResponse|\Psr\Http\Message\ResponseInterface
     */
    public function rootGet(string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\ParcelShipping\Endpoint\RootGet($accept), $fetch);
    }
    /**
     * Public Download URL for shipment labels and documents. The URL is provided in the response of the POST /orders or GET /orders resources. The document is identified via the token query parameter. There is no additional authorization, the resource URL can be shared. Please protect the URL as needed. The call returns a PDF label.
     *
     * @param array $queryParameters {
     *     @var string $token Identifies PDF document and requested print settings for download.
     * }
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @param array $accept Accept content header application/pdf|application/json
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\DownloadLabelNotFoundException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\DownloadLabelTooManyRequestsException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\DownloadLabelInternalServerErrorException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\LabelDataResponse|\Psr\Http\Message\ResponseInterface
     */
    public function downloadLabel(array $queryParameters = array(), string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\ParcelShipping\Endpoint\DownloadLabel($queryParameters, $accept), $fetch);
    }
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
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @param array $accept Accept content header application/json|application/problem+json
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetBadRequestException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetUnauthorizedException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetNotFoundException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetTooManyRequestsException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetInternalServerErrorException
     * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\ManifestsAccountGetGatewayTimeoutException
     *
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\GetManifestResponse200|\Psr\Http\Message\ResponseInterface
     */
    public function manifestsAccountGet(string $billingNumber, array $queryParameters = array(), array $headerParameters = array(), string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\ParcelShipping\Endpoint\ManifestsAccountGet($billingNumber, $queryParameters, $headerParameters, $accept), $fetch);
    }
    /**
     * Manifest. Mark end of day for referenced sets of shipments.  Shipments are normally 'closed out' at a fixed time of the day (such as 6 pm, configured by EKP/account) for the date provided as ShipmentDate in the create call. This call allows forcing the closeout for sets of shipments earlier. This will also override the original shipmentDate. Afterwards, the shipment cannot be changed and the shipment labels cannot be queried anymore (however they may remain cached for limited duration). Calling closeout repeatedly for the same shipments will result in HTTP 400 for the second call. HTTP 400 will also be returned if the automatic closeout happened prior to the call. It is however possible to add new shipments, they will be manifested as well and be part of the day's manifest. Note on billing: The manifesting step has billing implications. Some products (Warenpost, Parcel International partially) are billed based on the shipment data available to DHL at the end of the day. All other products (including DHL Paket Standard) are billed based on production data. For more details, please contact your account representative. ## Input It's changing the status of the shipment, so parameters are provided in the body. * 'profile' attribute - for future use, it currently has no effect. * list of shipment IDs (it is currently required to provide the shipments explicitly, there is no __manifest all__ functionality yet) ## Output * Status for each shipment
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
     * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\DoManifestResponse207|\Psr\Http\Message\ResponseInterface
     */
    public function manifestsPost(\Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentManifestingRequest $requestBody, array $queryParameters = array(), array $headerParameters = array(), string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\ParcelShipping\Endpoint\ManifestsPost($requestBody, $queryParameters, $headerParameters, $accept), $fetch);
    }
    /**
     * Delete one or more shipments created earlier. Deletion of shipments is only possible prior to them being manifested (closed out, 'Tagesabschluss')  The call will return HTTP 200 (single shipment) or 207 on success, with individual status elements for each shipment. Individual status elements are HTTP 200, 400. 400 will be returned when shipment does not exist (or was already deleted). 
     *
     * @param array $queryParameters {
     *     @var string $shipment This parameter provides an existing shipment ID. If multiple shipments need to be specified (for DELETE and GET calls) you need to provide the parameter multiple times.
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
    * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
    * @param array $accept Accept content header application/json|application/problem+json
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelBadRequestException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelUnauthorizedException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelNotFoundException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelTooManyRequestsException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\GetLabelInternalServerErrorException
    *
    * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\LabelDataResponse|\Psr\Http\Message\ResponseInterface
    */
    public function getLabel(array $queryParameters = array(), array $headerParameters = array(), string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\ParcelShipping\Endpoint\GetLabel($queryParameters, $headerParameters, $accept), $fetch);
    }
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
    * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
    * @param array $accept Accept content header application/json|application/problem+json
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostBadRequestException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostUnauthorizedException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostTooManyRequestsException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostInternalServerErrorException
    * @throws \Mediaopt\DHL\Api\ParcelShipping\Exception\OrdersPostGatewayTimeoutException
    *
    * @return null|\Mediaopt\DHL\Api\ParcelShipping\Model\LabelDataResponse|\Psr\Http\Message\ResponseInterface
    */
    public function ordersPost(\Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentOrderRequest $requestBody, array $queryParameters = array(), array $headerParameters = array(), string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\ParcelShipping\Endpoint\OrdersPost($requestBody, $queryParameters, $headerParameters, $accept), $fetch);
    }
    public static function create($httpClient = null, array $additionalPlugins = array(), array $additionalNormalizers = array())
    {
        if (null === $httpClient) {
            $httpClient = \Http\Discovery\Psr18ClientDiscovery::find();
            $plugins = array();
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