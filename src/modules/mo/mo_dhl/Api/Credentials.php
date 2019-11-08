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
 * @author Mediaopt GmbH
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
     * @param string      $endpoint
     * @param string      $username
     * @param string      $password
     * @param string|null $ekp
     */
    public function __construct($endpoint, $username, $password, $ekp = null)
    {
        $this->endpoint = $endpoint;
        $this->username = $username;
        $this->password = $password;
        $this->ekp = $ekp;
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
     * @param string      $username
     * @param string      $password
     * @param string|null $ekp
     * @return self
     */
    public static function createSandboxEndpoint($username, $password, $ekp)
    {
        return new static('https://cig.dhl.de/services/sandbox/rest', $username, $password, $ekp);
    }

    /**
     * @param string      $username
     * @param string      $password
     * @param string|null $ekp
     * @return self
     */
    public static function createProductionEndpoint($username, $password, $ekp)
    {
        return new static('https://cig.dhl.de/services/production/rest', $username, $password, $ekp);
    }
}
