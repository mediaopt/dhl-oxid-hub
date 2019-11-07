<?php

namespace Mediaopt\DHL\Api;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Mediaopt\DHL\Exception\WebserviceException;
use Psr\Log\LoggerInterface;

/**
 * @author  derksen mediaopt GmbH
 * @package Mediaopt\DHL
 */
abstract class Base
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Credentials
     */
    protected $credentials;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var \stdClass[]
     */
    protected $memoizations = [];

    /**
     * @param ClientInterface $client
     * @param Credentials     $credentials
     * @param LoggerInterface $logger
     */
    public function __construct(Credentials $credentials, LoggerInterface $logger, ClientInterface $client)
    {
        $this->client = $client;
        $this->credentials = $credentials;
        $this->logger = $logger;
    }

    /**
     * @param string $relativeUrl
     *
     * @return \stdClass
     * @throws WebserviceException
     */
    protected function callApi($relativeUrl)
    {
        if (array_key_exists($relativeUrl, $this->memoizations)) {
            return $this->memoizations[$relativeUrl];
        }

        $url = $this->buildUrl($relativeUrl);
        $requestOptions = $this->buildRequestOptions();
        $this->getLogger()->debug(__METHOD__ . " - API call with $url", ['options' => $requestOptions]);
        try {
            $response = $this->getClient()->get($url, $requestOptions);
            $body = $response->getBody();
            $payload = $body !== null ? $body->getContents() : '';
            if ($payload === '') {
                $message = __METHOD__ . " - The API call to $url returned an empty body";
                $this->getLogger()->error($message, ['response' => $response]);
                throw new WebserviceException('API returned an empty body.');
            }
            $decoded = json_decode($payload);
            if (!($decoded instanceof \stdClass)) {
                $message = __METHOD__ . " - The API call to $url returned an unexpected value";
                $this->getLogger()->error($message, ['response' => $response, 'payload' => $payload]);
                throw new WebserviceException('API returned an unexpected value.');
            }
            $this->memoizations[$relativeUrl] = $decoded;
            return $decoded;
        } catch (RequestException $exception) {
            $message = __METHOD__ . " - The API call to $url failed due to {$exception->getMessage()}";
            $this->getLogger()->error($message, ['exception' => $exception]);
            throw new WebserviceException('Failed API call.', 0, $exception);
        }
    }

    /**
     * @param string $relativeUrl
     * @return string
     */
    protected function buildUrl($relativeUrl)
    {
        return "{$this->getCredentials()->getEndpoint()}/{$this->getIdentifier()}/$relativeUrl";
    }

    /**
     * @return Credentials
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @return string identifier of the API (used for constructing the correct URL)
     */
    abstract protected function getIdentifier();

    /**
     * @return array
     */
    protected function buildRequestOptions()
    {
        $credentials = $this->getCredentials();
        return ['auth' => [$credentials->getUsername(), $credentials->getPassword()]];
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }
}
