<?php


namespace Mediaopt\DHL\Api;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;

class MyAccount
{
    /**
     * @param LoggerInterface $logger
     * @return Plugin
     */
    public static function getMyAccountLoggingPlugin(LoggerInterface $logger): Plugin
    {
        return new class($logger) implements Plugin {
            private $logger;

            public function __construct(LoggerInterface $logger)
            {
                $this->logger = $logger;
            }

            public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
            {
                $context = [
                    'method' => $request->getMethod(),
                    'url'    => (string)$request->getUri(),
                    'body'   => $request->getBody()->getContents(),
                ];
                $this->logger->debug('MyAccount Call', $context);
                return $next($request);
            }
        };
    }
}
