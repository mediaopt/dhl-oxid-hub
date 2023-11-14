<?php

namespace Mediaopt\DHL\Api\MyAccount\Runtime\Client;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\SerializerInterface;
trait EndpointTrait
{
    protected abstract function transformResponseBody(ResponseInterface $response, SerializerInterface $serializer, ?string $contentType = null);
    public function parseResponse(ResponseInterface $response, SerializerInterface $serializer, string $fetchMode = Client::FETCH_OBJECT)
    {
        debug($response->getBody()->getContents());
        $contentType = $response->hasHeader('Content-Type') ? current($response->getHeader('Content-Type')) : null;
        return $this->transformResponseBody($response, $serializer, $contentType);
    }
}