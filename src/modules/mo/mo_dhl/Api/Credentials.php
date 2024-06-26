<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Api;

/**
 * Encapsulates credentials for REST APIs of DHL.
 *
 * @author  Mediaopt GmbH
 * @version ${VERSION}, ${REVISION}
 * @package Mediaopt\DHL\Standortsuche
 */
class Credentials
{
    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string|null
     */
    protected $ekp;

    /**
     * @var array|null
     */
    protected $additionalFields;

    /**
     * @var bool
     */
    protected $isSandbox;

    /**
     * @param string      $endpoint
     * @param string      $username
     * @param string      $password
     * @param string|null $ekp
     * @param bool        $isSandbox
     * @param array       $additionalFields
     */
    public function __construct($endpoint, $username, $password, $ekp = null, $isSandbox = false, $additionalFields = [])
    {
        $this->endpoint = $endpoint;
        $this->username = $username;
        $this->password = $password;
        $this->ekp = $ekp;
        $this->isSandbox = $isSandbox;
        $this->additionalFields = $additionalFields;
    }

    /**
     * @return bool
     */
    public function isSandbox(): bool
    {
        return $this->isSandbox;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return null|string
     */
    public function getEkp()
    {
        return $this->ekp;
    }

    /**
     * @return null|array
     */
    public function getAdditionalFields()
    {
        return $this->additionalFields;
    }

    /**
     * @param string      $username
     * @param string      $password
     * @param string|null $ekp
     * @return self
     */
    public static function createSandboxRestEndpoint($username, $password, $ekp)
    {
        return new static('https://cig.dhl.de/services/sandbox/rest', $username, $password, $ekp, true);
    }

    /**
     * @param string      $username
     * @param string      $password
     * @param string|null $ekp
     * @return self
     */
    public static function createProductionRestEndpoint($username, $password, $ekp)
    {
        return new static('https://cig.dhl.de/services/production/rest', $username, $password, $ekp, false);
    }

    /**
     * @param string $keyName
     * @param string $password
     * @return self
     */
    public static function createStandortsucheEndpoint($keyName, $password)
    {
        return new static('https://api.dhl.com/location-finder/v1', $keyName, $password);
    }

    /**
     * @param string      $username
     * @param string      $password
     * @param string|null $ekp
     * @return self
     */
    public static function createSandboxSoapEndpoint($username, $password, $ekp)
    {
        return new static('https://cig.dhl.de/services/sandbox/soap', $username, $password, $ekp, true);
    }

    /**
     * @param string      $username
     * @param string      $password
     * @param string|null $ekp
     * @return self
     */
    public static function createProductionSoapEndpoint($username, $password, $ekp)
    {
        return new static('https://cig.dhl.de/services/production/soap', $username, $password, $ekp, false);
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $apiKey
     * @return static
     */
    public static function createSandboxParcelShippingCredentials($username, $password, $apiKey)
    {
        return new static('https://api-sandbox.dhl.com/parcel/de/shipping/v2', $username, $password, null, true, ['api-key' => $apiKey]);
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $apiKey
     * @return static
     */
    public static function createProductionParcelShippingCredentials($username, $password, $apiKey)
    {
        return new static('https://api-eu.dhl.com/parcel/de/shipping/v2', $username, $password, null, false, ['api-key' => $apiKey]);
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $apiKey
     * @return static
     */
    public static function createProductionAuthenticationCredentials($clientId, $clientSecret)
    {
        return new static('https://api-eu.dhl.com/parcel/de/account/auth/ropc/v1', $clientId, $clientSecret, null, false);
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $apiKey
     * @return static
     */
    public static function createSandboxAuthenticationCredentials($clientId, $clientSecret)
    {
        return new static('https://api-sandbox.dhl.com/parcel/de/account/auth/ropc/v1', $clientId, $clientSecret, null, true);
    }

    /**
     * @return static
     */
    public static function createProductionMyAccountCredentials()
    {
        return new static('https://api-eu.dhl.com/parcel/de/account/myaccount/v1', null, null, null, false);
    }

    /**
     * @return static
     */
    public static function createSandboxMyAccountCredentials()
    {
        return new static('https://api-sandbox.dhl.com/parcel/de/account/myaccount/v1', null, null, null, true);
    }

    /**
     * @param string $username
     * @param string $password
     * @return self
     */
    public static function createSandboxInternetmarkeEndpoint($username, $password)
    {
        return new static('https://internetmarke.deutschepost.de/OneClickForAppV3', $username, $password, null, true);
    }

    /**
     * @param string $username
     * @param string $password
     * @return self
     */
    public static function createProductionInternetmarkeEndpoint($username, $password)
    {
        return new static('https://internetmarke.deutschepost.de/OneClickForAppV3', $username, $password, null, false);
    }

    /**
     * @param string $username
     * @param string $password
     * @return self
     */
    public static function createProdWSEndpoint($username, $password)
    {
        return new static('https://prodws.deutschepost.de:8443/ProdWSProvider_1_1/prodws', $username, $password, null, false);
    }

    /**
     * @param string $username
     * @param string $password
     * @return static
     */
    public static function createCustomerCredentials($username, $password)
    {
        return new static('', $username, $password);
    }

    /**
     * @return string
     */
    public function getBasicAuth()
    {
        return base64_encode($this->getUsername() . ':' . $this->getPassword());
    }
}
