<?php

namespace Mediaopt\DHL\Api\Authentication;

class Client extends \Mediaopt\DHL\Api\Authentication\Runtime\Client\Client
{
    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return null|\Mediaopt\DHL\Api\Authentication\Model\GetResponse200|\Psr\Http\Message\ResponseInterface
     */
    public function get(string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\Authentication\Endpoint\Get(), $fetch);
    }
    /**
    * The client makes a request to the token endpoint by adding the following parameters 
    using the application/x-www-form-urlencoded format with a character
    encoding of UTF-8 in the HTTP request entity-body:
    
    * grant_type __REQUIRED__. Must be set to "password" or "refresh_token".
    
    * client_id __REQUIRED__ (aka client_id (api key))
    
    * client_secret __REQUIRED__ (aka client_secret)
    
    Depending on the grant_type, __additional parameters__ must be provided:
    
    <h3>grant_type=password</h3>
    
    This currently is the only grant type supported.
    
    * username __REQUIRED__. The resource owner username. Aka username for business customer portal
    
    * password __REQUIRED__. The resource owner password. Aka password for business customer portal
    
    *
    * @param \Mediaopt\DHL\Api\Authentication\Model\TokenPostBody $requestBody 
    * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
    * @throws \Mediaopt\DHL\Api\Authentication\Exception\DispenseTokenBadRequestException
    * @throws \Mediaopt\DHL\Api\Authentication\Exception\DispenseTokenUnauthorizedException
    * @throws \Mediaopt\DHL\Api\Authentication\Exception\DispenseTokenForbiddenException
    *
    * @return null|\Mediaopt\DHL\Api\Authentication\Model\TokenResponse|\Psr\Http\Message\ResponseInterface
    */
    public function dispenseToken(\Mediaopt\DHL\Api\Authentication\Model\TokenPostBody $requestBody, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\Authentication\Endpoint\DispenseToken($requestBody), $fetch);
    }
    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     * @throws \Mediaopt\DHL\Api\Authentication\Exception\HelloBadRequestException
     * @throws \Mediaopt\DHL\Api\Authentication\Exception\HelloUnauthorizedException
     * @throws \Mediaopt\DHL\Api\Authentication\Exception\HelloForbiddenException
     *
     * @return null|\Mediaopt\DHL\Api\Authentication\Model\TokenResponse|\Psr\Http\Message\ResponseInterface
     */
    public function hello(string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \Mediaopt\DHL\Api\Authentication\Endpoint\Hello(), $fetch);
    }
    public static function create($httpClient = null, array $additionalPlugins = array(), array $additionalNormalizers = array())
    {
        if (null === $httpClient) {
            $httpClient = \Http\Discovery\Psr18ClientDiscovery::find();
            $plugins = array();
            $uri = \Http\Discovery\Psr17FactoryDiscovery::findUrlFactory()->createUri('https://api-eu.dhl.com/parcel/de/account/auth/ropc/v1');
            $plugins[] = new \Http\Client\Common\Plugin\AddHostPlugin($uri);
            $plugins[] = new \Http\Client\Common\Plugin\AddPathPlugin($uri);
            if (count($additionalPlugins) > 0) {
                $plugins = array_merge($plugins, $additionalPlugins);
            }
            $httpClient = new \Http\Client\Common\PluginClient($httpClient, $plugins);
        }
        $requestFactory = \Http\Discovery\Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = \Http\Discovery\Psr17FactoryDiscovery::findStreamFactory();
        $normalizers = array(new \Symfony\Component\Serializer\Normalizer\ArrayDenormalizer(), new \Mediaopt\DHL\Api\Authentication\Normalizer\JaneObjectNormalizer());
        if (count($additionalNormalizers) > 0) {
            $normalizers = array_merge($normalizers, $additionalNormalizers);
        }
        $serializer = new \Symfony\Component\Serializer\Serializer($normalizers, array(new \Symfony\Component\Serializer\Encoder\JsonEncoder(new \Symfony\Component\Serializer\Encoder\JsonEncode(), new \Symfony\Component\Serializer\Encoder\JsonDecode(array('json_decode_associative' => true)))));
        return new static($httpClient, $requestFactory, $serializer, $streamFactory);
    }
}