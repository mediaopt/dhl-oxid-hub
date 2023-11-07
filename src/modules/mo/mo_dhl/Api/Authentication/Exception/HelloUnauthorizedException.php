<?php

namespace Mediaopt\DHL\Api\Authentication\Exception;

class HelloUnauthorizedException extends UnauthorizedException
{
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    private $response;
    public function __construct(\Psr\Http\Message\ResponseInterface $response = null)
    {
        parent::__construct('Unauthorized - The client could not be authenticated. There are multiple possible reasons for this. This includes bad or missing credentials. The error message should provide additional information.
');
        $this->response = $response;
    }
    public function getResponse() : ?\Psr\Http\Message\ResponseInterface
    {
        return $this->response;
    }
}