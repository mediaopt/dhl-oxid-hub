<?php

namespace Mediaopt\DHL\Api;

use Mediaopt\DHL\Api\ProdWS\GetCatalogChangeInformationRequestType;
use Mediaopt\DHL\Api\ProdWS\GetCatalogChangeInformationResponse;
use Mediaopt\DHL\Api\ProdWS\GetCatalogListRequestType;
use Mediaopt\DHL\Api\ProdWS\GetCatalogListResponse;
use Mediaopt\DHL\Api\ProdWS\GetCatalogRequestType;
use Mediaopt\DHL\Api\ProdWS\GetCatalogResponse;
use Mediaopt\DHL\Api\ProdWS\GetChangedProductVersionsListRequestType;
use Mediaopt\DHL\Api\ProdWS\GetChangedProductVersionsListResponse;
use Mediaopt\DHL\Api\ProdWS\GetProductChangeInformationRequestType;
use Mediaopt\DHL\Api\ProdWS\GetProductChangeInformationResponse;
use Mediaopt\DHL\Api\ProdWS\GetProductListRequestType;
use Mediaopt\DHL\Api\ProdWS\GetProductListResponse;
use Mediaopt\DHL\Api\ProdWS\GetProductRequestType;
use Mediaopt\DHL\Api\ProdWS\GetProductResponse;
use Mediaopt\DHL\Api\ProdWS\GetProductVersionsListRequestType;
use Mediaopt\DHL\Api\ProdWS\GetProductVersionsListResponse;
use Mediaopt\DHL\Api\ProdWS\GetProductVersionsRequestType;
use Mediaopt\DHL\Api\ProdWS\GetProductVersionsResponse;
use Mediaopt\DHL\Api\ProdWS\RegisterEMailAdressRequestType;
use Mediaopt\DHL\Api\ProdWS\RegisterEMailAdressResponse;
use Mediaopt\DHL\Api\ProdWS\RegisterNotificationRequestType;
use Mediaopt\DHL\Api\ProdWS\RegisterNotificationResponse;
use Mediaopt\DHL\Api\ProdWS\SeekProductRequestType;
use Mediaopt\DHL\Api\ProdWS\SeekProductResponse;
use Mediaopt\DHL\Api\ProdWS\SeekProductVersionsRequestType;
use Mediaopt\DHL\Api\ProdWS\SeekProductVersionsResponse;
use Mediaopt\DHL\Exception\WebserviceException;
use Psr\Log\LoggerInterface;

class ProdWSService extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = [
        'accountProdReferenceType'                  => 'Mediaopt\\DHL\\Api\\ProdWS\\AccountProdReferenceType',
        'countryNegativList'                        => 'Mediaopt\\DHL\\Api\\ProdWS\\CountryNegativList',
        'shortProductIdentifierType'                => 'Mediaopt\\DHL\\Api\\ProdWS\\ShortProductIdentifierType',
        'extendedIdentifierType'                    => 'Mediaopt\\DHL\\Api\\ProdWS\\ExtendedIdentifierType',
        'externIdentifierType'                      => 'Mediaopt\\DHL\\Api\\ProdWS\\ExternIdentifierType',
        'currencyAmountType'                        => 'Mediaopt\\DHL\\Api\\ProdWS\\CurrencyAmountType',
        'unitPriceType'                             => 'Mediaopt\\DHL\\Api\\ProdWS\\UnitPriceType',
        'tempPriceList'                             => 'Mediaopt\\DHL\\Api\\ProdWS\\TempPriceList',
        'tempUnitPriceType'                         => 'Mediaopt\\DHL\\Api\\ProdWS\\TempUnitPriceType',
        'priceType'                                 => 'Mediaopt\\DHL\\Api\\ProdWS\\PriceType',
        'tempPriceType'                             => 'Mediaopt\\DHL\\Api\\ProdWS\\TempPriceType',
        'operandType'                               => 'Mediaopt\\DHL\\Api\\ProdWS\\OperandType',
        'priceFormulaType'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\PriceFormulaType',
        'formulaComponentType'                      => 'Mediaopt\\DHL\\Api\\ProdWS\\FormulaComponentType',
        'formulaExpressionType'                     => 'Mediaopt\\DHL\\Api\\ProdWS\\FormulaExpressionType',
        'priceOperandType'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\PriceOperandType',
        'priceDefinitionType'                       => 'Mediaopt\\DHL\\Api\\ProdWS\\PriceDefinitionType',
        'slidingPriceType'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\SlidingPriceType',
        'slidingPriceListType'                      => 'Mediaopt\\DHL\\Api\\ProdWS\\SlidingPriceListType',
        'timestampType'                             => 'Mediaopt\\DHL\\Api\\ProdWS\\TimestampType',
        'validityType'                              => 'Mediaopt\\DHL\\Api\\ProdWS\\ValidityType',
        'alphanumericValueType'                     => 'Mediaopt\\DHL\\Api\\ProdWS\\AlphanumericValueType',
        'currencyValueType'                         => 'Mediaopt\\DHL\\Api\\ProdWS\\CurrencyValueType',
        'dateValueType'                             => 'Mediaopt\\DHL\\Api\\ProdWS\\DateValueType',
        'dimensionType'                             => 'Mediaopt\\DHL\\Api\\ProdWS\\DimensionType',
        'numericValueType'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\NumericValueType',
        'weightType'                                => 'Mediaopt\\DHL\\Api\\ProdWS\\WeightType',
        'propertyValueType'                         => 'Mediaopt\\DHL\\Api\\ProdWS\\PropertyValueType',
        'documentReferenceType'                     => 'Mediaopt\\DHL\\Api\\ProdWS\\DocumentReferenceType',
        'specialDayType'                            => 'Mediaopt\\DHL\\Api\\ProdWS\\SpecialDayType',
        'region'                                    => 'Mediaopt\\DHL\\Api\\ProdWS\\Region',
        'propertyType'                              => 'Mediaopt\\DHL\\Api\\ProdWS\\PropertyType',
        'groupedPropertyType'                       => 'Mediaopt\\DHL\\Api\\ProdWS\\GroupedPropertyType',
        'propertyList'                              => 'Mediaopt\\DHL\\Api\\ProdWS\\PropertyList',
        'documentReferenceList'                     => 'Mediaopt\\DHL\\Api\\ProdWS\\DocumentReferenceList',
        'formatedTextList'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\FormatedTextList',
        'countrySpecificPropertyType'               => 'Mediaopt\\DHL\\Api\\ProdWS\\CountrySpecificPropertyType',
        'catalogValueType'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\CatalogValueType',
        'catalogType'                               => 'Mediaopt\\DHL\\Api\\ProdWS\\CatalogType',
        'catalogValueList'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\CatalogValueList',
        'textBlockType'                             => 'Mediaopt\\DHL\\Api\\ProdWS\\TextBlockType',
        'textRowType'                               => 'Mediaopt\\DHL\\Api\\ProdWS\\TextRowType',
        'formatedTextType'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\FormatedTextType',
        'nationalZipCodeListType'                   => 'Mediaopt\\DHL\\Api\\ProdWS\\NationalZipCodeListType',
        'nationalZipCodeGroupType'                  => 'Mediaopt\\DHL\\Api\\ProdWS\\NationalZipCodeGroupType',
        'nationalZipCodeArea'                       => 'Mediaopt\\DHL\\Api\\ProdWS\\NationalZipCodeArea',
        'nationalDestinationAreaType'               => 'Mediaopt\\DHL\\Api\\ProdWS\\NationalDestinationAreaType',
        'countryType'                               => 'Mediaopt\\DHL\\Api\\ProdWS\\CountryType',
        'countryGroupType'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\CountryGroupType',
        'chargeZoneType'                            => 'Mediaopt\\DHL\\Api\\ProdWS\\ChargeZoneType',
        'internationalDestinationAreaType'          => 'Mediaopt\\DHL\\Api\\ProdWS\\InternationalDestinationAreaType',
        'countryList'                               => 'Mediaopt\\DHL\\Api\\ProdWS\\CountryList',
        'countryGroupList'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\CountryGroupList',
        'chargeZoneList'                            => 'Mediaopt\\DHL\\Api\\ProdWS\\ChargeZoneList',
        'destinationAreaType'                       => 'Mediaopt\\DHL\\Api\\ProdWS\\DestinationAreaType',
        'basicProductType'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\BasicProductType',
        'dimensionList'                             => 'Mediaopt\\DHL\\Api\\ProdWS\\DimensionList',
        'groupedPropertyList'                       => 'Mediaopt\\DHL\\Api\\ProdWS\\GroupedPropertyList',
        'additionalProductType'                     => 'Mediaopt\\DHL\\Api\\ProdWS\\AdditionalProductType',
        'salesProductType'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\SalesProductType',
        'countrySpecificPropertyList'               => 'Mediaopt\\DHL\\Api\\ProdWS\\CountrySpecificPropertyList',
        'usageList'                                 => 'Mediaopt\\DHL\\Api\\ProdWS\\UsageList',
        'categoryList'                              => 'Mediaopt\\DHL\\Api\\ProdWS\\CategoryList',
        'stampTypeList'                             => 'Mediaopt\\DHL\\Api\\ProdWS\\StampTypeList',
        'referenceTextList'                         => 'Mediaopt\\DHL\\Api\\ProdWS\\ReferenceTextList',
        'accountProductReferenceList'               => 'Mediaopt\\DHL\\Api\\ProdWS\\AccountProductReferenceList',
        'accountServiceReferenceList'               => 'Mediaopt\\DHL\\Api\\ProdWS\\AccountServiceReferenceList',
        'specialServiceType'                        => 'Mediaopt\\DHL\\Api\\ProdWS\\SpecialServiceType',
        'serviceDayList'                            => 'Mediaopt\\DHL\\Api\\ProdWS\\ServiceDayList',
        'exclusionDayList'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\ExclusionDayList',
        'shortSalesProductType'                     => 'Mediaopt\\DHL\\Api\\ProdWS\\ShortSalesProductType',
        'priceDefinition'                           => 'Mediaopt\\DHL\\Api\\ProdWS\\PriceDefinition',
        'ExceptionDetailType'                       => 'Mediaopt\\DHL\\Api\\ProdWS\\ExceptionDetailType',
        'searchParameterType'                       => 'Mediaopt\\DHL\\Api\\ProdWS\\SearchParameterType',
        'productID'                                 => 'Mediaopt\\DHL\\Api\\ProdWS\\ProductID',
        'productName'                               => 'Mediaopt\\DHL\\Api\\ProdWS\\ProductName',
        'productPrice'                              => 'Mediaopt\\DHL\\Api\\ProdWS\\ProductPrice',
        'productValidity'                           => 'Mediaopt\\DHL\\Api\\ProdWS\\ProductValidity',
        'productDimensionList'                      => 'Mediaopt\\DHL\\Api\\ProdWS\\ProductDimensionList',
        'productDimension'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\ProductDimension',
        'dimension'                                 => 'Mediaopt\\DHL\\Api\\ProdWS\\Dimension',
        'productWeight'                             => 'Mediaopt\\DHL\\Api\\ProdWS\\ProductWeight',
        'productPropertyList'                       => 'Mediaopt\\DHL\\Api\\ProdWS\\ProductPropertyList',
        'property'                                  => 'Mediaopt\\DHL\\Api\\ProdWS\\Property',
        'productUsage'                              => 'Mediaopt\\DHL\\Api\\ProdWS\\ProductUsage',
        'productCategory'                           => 'Mediaopt\\DHL\\Api\\ProdWS\\ProductCategory',
        'productStampType'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\ProductStampType',
        'productGroup'                              => 'Mediaopt\\DHL\\Api\\ProdWS\\ProductGroup',
        'branch'                                    => 'Mediaopt\\DHL\\Api\\ProdWS\\Branch',
        'additionalProductList'                     => 'Mediaopt\\DHL\\Api\\ProdWS\\AdditionalProductList',
        'seekProductRequestType'                    => 'Mediaopt\\DHL\\Api\\ProdWS\\SeekProductRequestType',
        'searchParameterList'                       => 'Mediaopt\\DHL\\Api\\ProdWS\\SearchParameterList',
        'seekProductVersionsRequestType'            => 'Mediaopt\\DHL\\Api\\ProdWS\\SeekProductVersionsRequestType',
        'getProductRequestType'                     => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductRequestType',
        'getProductVersionsRequestType'             => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductVersionsRequestType',
        'getProductListRequestType'                 => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductListRequestType',
        'getProductVersionsListRequestType'         => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductVersionsListRequestType',
        'getChangedProductVersionsListRequestType'  => 'Mediaopt\\DHL\\Api\\ProdWS\\GetChangedProductVersionsListRequestType',
        'getProductChangeInformationRequestType'    => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductChangeInformationRequestType',
        'getCatalogChangeInformationRequestType'    => 'Mediaopt\\DHL\\Api\\ProdWS\\GetCatalogChangeInformationRequestType',
        'getCatalogRequestType'                     => 'Mediaopt\\DHL\\Api\\ProdWS\\GetCatalogRequestType',
        'getCatalogListRequestType'                 => 'Mediaopt\\DHL\\Api\\ProdWS\\GetCatalogListRequestType',
        'registerEMailAdressRequestType'            => 'Mediaopt\\DHL\\Api\\ProdWS\\RegisterEMailAdressRequestType',
        'subMandant'                                => 'Mediaopt\\DHL\\Api\\ProdWS\\SubMandant',
        'registerNotificationRequestType'           => 'Mediaopt\\DHL\\Api\\ProdWS\\RegisterNotificationRequestType',
        'seekProductResponseType'                   => 'Mediaopt\\DHL\\Api\\ProdWS\\SeekProductResponseType',
        'salesProduct'                              => 'Mediaopt\\DHL\\Api\\ProdWS\\SalesProduct',
        'seekProductVersionsResponseType'           => 'Mediaopt\\DHL\\Api\\ProdWS\\SeekProductVersionsResponseType',
        'getProductResponseType'                    => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductResponseType',
        'getProductVersionsResponseType'            => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductVersionsResponseType',
        'salesProductList'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\SalesProductList',
        'basicProductList'                          => 'Mediaopt\\DHL\\Api\\ProdWS\\BasicProductList',
        'specialServiceList'                        => 'Mediaopt\\DHL\\Api\\ProdWS\\SpecialServiceList',
        'shortSalesProductList'                     => 'Mediaopt\\DHL\\Api\\ProdWS\\ShortSalesProductList',
        'getProductListResponseType'                => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductListResponseType',
        'getProductVersionsListResponseType'        => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductVersionsListResponseType',
        'getChangedProductVersionsListResponseType' => 'Mediaopt\\DHL\\Api\\ProdWS\\GetChangedProductVersionsListResponseType',
        'getProductChangeInformationResponseType'   => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductChangeInformationResponseType',
        'getCatalogChangeInformationResponseType'   => 'Mediaopt\\DHL\\Api\\ProdWS\\GetCatalogChangeInformationResponseType',
        'getCatalogResponseType'                    => 'Mediaopt\\DHL\\Api\\ProdWS\\GetCatalogResponseType',
        'getCatalogListResponseType'                => 'Mediaopt\\DHL\\Api\\ProdWS\\GetCatalogListResponseType',
        'catalogList'                               => 'Mediaopt\\DHL\\Api\\ProdWS\\CatalogList',
        'registerEMailAdressResponseType'           => 'Mediaopt\\DHL\\Api\\ProdWS\\RegisterEMailAdressResponseType',
        'registerNotificationResponseType'          => 'Mediaopt\\DHL\\Api\\ProdWS\\RegisterNotificationResponseType',
        'seekProductResponse'                       => 'Mediaopt\\DHL\\Api\\ProdWS\\SeekProductResponse',
        'Exception'                                 => 'Mediaopt\\DHL\\Api\\ProdWS\\ExceptionCustom',
        'seekProductVersionsResponse'               => 'Mediaopt\\DHL\\Api\\ProdWS\\SeekProductVersionsResponse',
        'getProductResponse'                        => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductResponse',
        'getProductVersionsResponse'                => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductVersionsResponse',
        'getProductListResponse'                    => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductListResponse',
        'getProductVersionsListResponse'            => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductVersionsListResponse',
        'getChangedProductVersionsListResponse'     => 'Mediaopt\\DHL\\Api\\ProdWS\\GetChangedProductVersionsListResponse',
        'getProductChangeInformationResponse'       => 'Mediaopt\\DHL\\Api\\ProdWS\\GetProductChangeInformationResponse',
        'getCatalogChangeInformationResponse'       => 'Mediaopt\\DHL\\Api\\ProdWS\\GetCatalogChangeInformationResponse',
        'getCatalogResponse'                        => 'Mediaopt\\DHL\\Api\\ProdWS\\GetCatalogResponse',
        'getCatalogListResponse'                    => 'Mediaopt\\DHL\\Api\\ProdWS\\GetCatalogListResponse',
        'registerEMailAdressResponse'               => 'Mediaopt\\DHL\\Api\\ProdWS\\RegisterEMailAdressResponse',
        'registerNotificationResponse'              => 'Mediaopt\\DHL\\Api\\ProdWS\\RegisterNotificationResponse',
    ];

    /**
     * @var Credentials
     */
    protected $soapCredentials;

    /**
     * @var Credentials
     */
    protected $customerGKVCredentials;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Credentials     $credentials
     * @param Credentials     $customerGKVCredentials
     * @param LoggerInterface $logger
     */
    public function __construct(Credentials $credentials, Credentials $customerGKVCredentials, LoggerInterface $logger)
    {
        $this->soapCredentials = $credentials;
        $this->customerGKVCredentials = $customerGKVCredentials;
        $this->logger = $logger;
        $options = [
            'features'       => SOAP_SINGLE_ELEMENT_ARRAYS,
            'classmap'       => self::$classmap,
            'trace'          => 1,
        ];
        $wsdl = 'https://prodws.deutschepost.de:8443/ProdWSProvider_1_1/prodws?wsdl';
        parent::__construct($wsdl, $options);
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param string $functionName
     * @param mixed  $request
     * @return mixed
     */
    protected function callSoap($functionName, $request)
    {
        $this->addMandantIdIfNecessary($request);
        $this->getLogger()->debug(__METHOD__ . " - SOAP API call for function  $functionName", ['options' => $request]);
        try {
            return $this->__soapCall($functionName, [$request], null, $this->createAuthorizationHeader());
        } catch (\SoapFault $exception) {
            $message = __METHOD__ . " - The SOAP API call for function  $functionName failed due to {$exception->getMessage()}";
            $this->getLogger()->error($message, ['exception' => $exception]);
            throw new WebserviceException('Failed API call.', 0, $exception);
        }
    }

    /**
     * @return \SoapHeader
     */
    protected function createAuthorizationHeader() : \SoapHeader
    {
        $xsd = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
        $security = (object) [
            'UsernameToken' => new \SoapVar([
                'Username' => new \SoapVar('mediaopt', XSD_STRING,null, null, null, $xsd),
                'Password' => new \SoapVar('<ns2:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">B&amp;5%bk?dx7</ns2:Password>', XSD_ANYXML),
            ], SOAP_ENC_OBJECT, null, null, null, $xsd),
        ];
        return new \SoapHeader($xsd, 'Security', $security);
    }

    /**
     * @param SeekProductRequestType $parameter
     * @return SeekProductResponse
     */
    public function seekProduct(SeekProductRequestType $parameter)
    {
        return $this->callSoap('seekProduct', $parameter);
    }

    /**
     * @param SeekProductVersionsRequestType $parameter
     * @return SeekProductVersionsResponse
     */
    public function seekProductVersions(SeekProductVersionsRequestType $parameter)
    {
        return $this->callSoap('seekProductVersions', $parameter);
    }

    /**
     * @param GetProductRequestType $parameter
     * @return GetProductResponse
     */
    public function getProduct(GetProductRequestType $parameter)
    {
        return $this->callSoap('getProduct', $parameter);
    }

    /**
     * @param GetProductVersionsRequestType $parameter
     * @return GetProductVersionsResponse
     */
    public function getProductVersions(GetProductVersionsRequestType $parameter)
    {
        return $this->callSoap('getProductVersions', $parameter);
    }

    /**
     * @param GetProductListRequestType $parameter
     * @return GetProductListResponse
     */
    public function getProductList(GetProductListRequestType $parameter)
    {
        return $this->callSoap('getProductList', $parameter);
    }

    /**
     * @param GetProductVersionsListRequestType $parameter
     * @return GetProductVersionsListResponse
     */
    public function getProductVersionsList(GetProductVersionsListRequestType $parameter)
    {
        return $this->callSoap('getProductVersionsList', $parameter);
    }

    /**
     * @param GetChangedProductVersionsListRequestType $parameter
     * @return GetChangedProductVersionsListResponse
     */
    public function getChangedProductVersionsList(GetChangedProductVersionsListRequestType $parameter)
    {
        return $this->callSoap('getChangedProductVersionsList', $parameter);
    }

    /**
     * @param RegisterEMailAdressRequestType $parameter
     * @return RegisterEMailAdressResponse
     */
    public function registerEMailAdress(RegisterEMailAdressRequestType $parameter)
    {
        return $this->callSoap('registerEMailAdress', $parameter);
    }

    /**
     * @param RegisterNotificationRequestType $parameter
     * @return RegisterNotificationResponse
     */
    public function registerNotification(RegisterNotificationRequestType $parameter)
    {
        return $this->callSoap('registerNotification', $parameter);
    }

    /**
     * @param GetCatalogRequestType $parameter
     * @return GetCatalogResponse
     */
    public function getCatalog(GetCatalogRequestType $parameter)
    {
        return $this->callSoap('getCatalog', $parameter);
    }

    /**
     * @param GetCatalogListRequestType $parameter
     * @return GetCatalogListResponse
     */
    public function getCatalogList(GetCatalogListRequestType $parameter)
    {
        return $this->callSoap('getCatalogList', $parameter);
    }

    /**
     * @param GetProductChangeInformationRequestType $parameter
     * @return GetProductChangeInformationResponse
     */
    public function getProductChangeInformation(GetProductChangeInformationRequestType $parameter)
    {
        return $this->callSoap('getProductChangeInformation', $parameter);
    }

    /**
     * @param GetCatalogChangeInformationRequestType $parameter
     * @return GetCatalogChangeInformationResponse
     */
    public function getCatalogChangeInformation(GetCatalogChangeInformationRequestType $parameter)
    {
        return $this->callSoap('getCatalogChangeInformation', $parameter);
    }

    /**
     * @param $request
     */
    protected function addMandantIdIfNecessary(&$request)
    {
        if (method_exists($request, 'getMandantID') && method_exists($request, 'setMandantID') && !$request->getMandantID()) {
            $request->setMandantID($this->customerGKVCredentials->getUsername());
        }
    }
}
