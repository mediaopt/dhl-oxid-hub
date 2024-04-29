<?php


namespace Mediaopt\DHL\Api;

class Authentication
{
    const DEFAULT_GRANT_TYPE = 'password';

    /**
     * @param Authentication\Client $client
     * @param Credentials $credentials
     * @param Credentials $userPass
     * @return string
     */
    public static function getToken(Authentication\Client $client, Credentials $credentials, Credentials $userPass): string
    {
        $tokenPostBody = new Authentication\Model\TokenPostBody();
        $tokenPostBody->setClientId($credentials->getUsername());
        $tokenPostBody->setClientSecret($credentials->getPassword());
        $tokenPostBody->setUsername($userPass->getUsername());
        $tokenPostBody->setPassword($userPass->getPassword());
        $tokenPostBody->setGrantType(self::DEFAULT_GRANT_TYPE);

        $token = $client->dispenseToken($tokenPostBody);

        return $token->getAccessToken();
    }
}
