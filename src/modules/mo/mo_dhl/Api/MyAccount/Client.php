<?php

namespace Mediaopt\DHL\Api\MyAccount;

class Client extends \Mediaopt\DHL\Api\MyAccount\Runtime\Client\Client
{
    /**
     * Returns the current version of the API as major.minor.patch. If a valid access token is provided, it will also return more details (semantic version number, revision, environment) of the backend layer. The function can be used for healthcheck; it does support content negotiation and can also be called from a browser.
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @param array $accept Accept content header application/json|text/html
     * @throws \Mediaopt\DHL\Api\MyAccount\Exception\GetVersionUnauthorizedException
     *
     * @return null|\Mediaopt\DHL\Api\MyAccount\Model\ApiVersionResponse|\Psr\Http\Message\ResponseInterface
     */
    public function getVersion(string $fetch = self::FETCH_OBJECT, array $accept = array())
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\MyAccount\Endpoint\GetVersion($accept), $fetch);
    }
    /**
     * 
     *
     * @param array $queryParameters {
     *     @var string $lang language for localized texts
     * }
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @throws \Mediaopt\DHL\Api\MyAccount\Exception\GetMyAggregatedUserDataBadRequestException
     * @throws \Mediaopt\DHL\Api\MyAccount\Exception\GetMyAggregatedUserDataUnauthorizedException
     *
     * @return null|\Mediaopt\DHL\Api\MyAccount\Model\AggregatedUserDataResponse|\Psr\Http\Message\ResponseInterface
     */
    public function getMyAggregatedUserData(array $queryParameters = array(), string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\MyAccount\Endpoint\GetMyAggregatedUserData($queryParameters), $fetch);
    }
    public static function create($httpClient = null, array $additionalPlugins = array(), array $additionalNormalizers = array())
    {
        if (null === $httpClient) {
            $httpClient = \Http\Discovery\Psr18ClientDiscovery::find();
            $plugins = array();
            $uri = \Http\Discovery\Psr17FactoryDiscovery::findUrlFactory()->createUri('https://api-eu.dhl.com/parcel/de/account/myaccount/v1');
            $plugins[] = new \Http\Client\Common\Plugin\AddHostPlugin($uri);
            $plugins[] = new \Http\Client\Common\Plugin\AddPathPlugin($uri);
            if (count($additionalPlugins) > 0) {
                $plugins = array_merge($plugins, $additionalPlugins);
            }
            $httpClient = new \Http\Client\Common\PluginClient($httpClient, $plugins);
        }
        $requestFactory = \Http\Discovery\Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = \Http\Discovery\Psr17FactoryDiscovery::findStreamFactory();
        $normalizers = array(new \Symfony\Component\Serializer\Normalizer\ArrayDenormalizer(), new \Mediaopt\DHL\Api\MyAccount\Normalizer\JaneObjectNormalizer());
        if (count($additionalNormalizers) > 0) {
            $normalizers = array_merge($normalizers, $additionalNormalizers);
        }
        $serializer = new \Symfony\Component\Serializer\Serializer($normalizers, array(new \Symfony\Component\Serializer\Encoder\JsonEncoder(new \Symfony\Component\Serializer\Encoder\JsonEncode(), new \Symfony\Component\Serializer\Encoder\JsonDecode(array('json_decode_associative' => true)))));
        return new static($httpClient, $requestFactory, $serializer, $streamFactory);
    }
}