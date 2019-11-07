<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 derksen mediaopt GmbH
 */

namespace Mediaopt\DHL\Api;

use GuzzleHttp\ClientInterface;
use Mediaopt\DHL\Address\Address;
use Mediaopt\DHL\Api\Standortsuche\ServiceProviderBuilder;
use Mediaopt\DHL\Exception\ServiceProviderException;
use Mediaopt\DHL\Exception\WebserviceException;
use Mediaopt\DHL\ServiceProvider\BasicServiceProvider;
use Mediaopt\DHL\ServiceProvider\Coordinates;
use Mediaopt\DHL\ServiceProvider\ServiceProviderList;
use Mediaopt\DHL\ServiceProvider\ServiceType;
use Psr\Log\LoggerInterface;

/**
 * Class that calls the Standortsuche Europa API.
 *
 * @author  derksen mediaopt GmbH
 * @version ${VERSION}, ${REVISION}
 * @package Mediaopt\DHL
 */
class Standortsuche extends Base
{
    /**
     * Maximum distance (in meters) of service providers in Germany that are allowed to be returned.
     */
    const MAXIMUM_DISTANCE_GERMANY = 15000;

    /**
     * Maximum distance (in meters) of service providers abroad that are allowed to be returned.
     */
    const MAXIMUM_DISTANCE_ABROAD = 25000;

    /**
     * @var ServiceProviderBuilder
     */
    protected $serviceProviderBuilder;

    /**
     * @param Credentials            $credentials
     * @param LoggerInterface        $logger
     * @param ClientInterface        $client
     * @param ServiceProviderBuilder $serviceProviderBuilder
     */
    public function __construct(
        Credentials $credentials,
        LoggerInterface $logger,
        ClientInterface $client,
        ServiceProviderBuilder $serviceProviderBuilder = null
    ) {
        parent::__construct($credentials, $logger, $client);
        $this->serviceProviderBuilder = $serviceProviderBuilder ?: new ServiceProviderBuilder();
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return 'parcelshopfinderrest';
    }

    /**
     * @param ServiceType $serviceType
     * @param Coordinates $coordinates
     * @return ServiceProviderList
     * @throws WebserviceException
     */
    public function getParcellocationByServiceTypeAndCoordinate(ServiceType $serviceType, Coordinates $coordinates)
    {
        $parameters = $serviceType->getName() . '/' . $coordinates->getLatitude() . '/' . $coordinates->getLongitude();
        return $this->extractServiceProviders($this->callApi('parcellocationByCoordinate/' . $parameters));
    }

    /**
     * @param \stdClass $object
     * @return ServiceProviderList
     */
    protected function extractServiceProviders(\stdClass $object)
    {
        $serviceProviders = array_map([$this, 'buildServiceProvider'], $object->psfParcellocationList);
        return new ServiceProviderList(array_filter($serviceProviders, [$this, 'isServiceProviderAllowed']));
    }

    /**
     * @param \stdClass $rawServiceProvider
     * @return BasicServiceProvider|null
     */
    protected function buildServiceProvider(\stdClass $rawServiceProvider)
    {
        try {
            return $this->getServiceProviderBuilder()->build($rawServiceProvider);
        } catch (ServiceProviderException $exception) {
            $message = "Service provider could not be processed due exception: {$exception->getMessage()}";
            $this->getLogger()->error($message, ['exception' => $exception]);
            return null;
        }
    }

    /**
     * @return ServiceProviderBuilder
     */
    protected function getServiceProviderBuilder()
    {
        return $this->serviceProviderBuilder;
    }

    /**
     * @param Coordinates $coordinates
     * @return ServiceProviderList
     * @throws WebserviceException
     */
    public function getParcellocationByCoordinate(Coordinates $coordinates)
    {
        $parameters = $coordinates->getLatitude() . '/' . $coordinates->getLongitude();
        return $this->extractServiceProviders($this->callApi('parcellocationByCoordinate/' . $parameters));
    }

    /**
     * @param ServiceType    $serviceType
     * @param Address|string $address
     * @return ServiceProviderList
     * @throws WebserviceException
     */
    public function getParcellocationByAddressAndServiceType(ServiceType $serviceType, $address)
    {
        $addressString = $this->buildAddressString($address);
        if ($addressString === '') {
            return new ServiceProviderList([]);
        }
        $parameters = $serviceType->getName() . '/' . $addressString;
        return $this->extractServiceProviders($this->callApi('parcellocationByAddress/' . $parameters));
    }

    /**
     * Generates a string with basic sanitization from the supplied address.
     *
     * @param Address|string $address
     * @return string
     */
    protected function buildAddressString($address)
    {
        if (is_string($address)) {
            return $this->sanitizeAddressString($address);
        }

        $components = [];
        foreach (['zip', 'city', 'street', 'streetNo', 'country'] as $name) {
            $components[] = trim($address->{'get' . ucfirst($name)}());
        }
        return $this->sanitizeAddressString(implode(' ', array_filter($components)));
    }

    /**
     * @param Address|string $address
     * @return ServiceProviderList
     * @throws WebserviceException
     */
    public function getParcellocationByAddress($address)
    {
        $addressString = $this->buildAddressString($address);
        if ($addressString === '') {
            return new ServiceProviderList([]);
        }

        return $this->extractServiceProviders($this->callApi('parcellocationByAddress/' . $addressString));
    }

    /**
     * @param string $key
     * @return BasicServiceProvider
     * @throws WebserviceException
     */
    public function getParcellocationByPrimaryKeyPSF($key)
    {
        $serviceProvider = $this->buildServiceProvider($this->callApi('parcellocationByPrimaryKeyPSF/' . $key));
        if ($serviceProvider !== null) {
            return $serviceProvider;
        }
        throw new WebserviceException('NO_RESULT');
    }

    /**
     * @param BasicServiceProvider|null $potentialServiceProvider
     * @return bool
     */
    protected function isServiceProviderAllowed($potentialServiceProvider)
    {
        if ($potentialServiceProvider === null) {
            return false;
        }

        $maximumDistance = $potentialServiceProvider->getAddress()->getCountry() === 'de'
            ? self::MAXIMUM_DISTANCE_GERMANY
            : self::MAXIMUM_DISTANCE_ABROAD;
        return $potentialServiceProvider->getLocation()->getDistance() <= $maximumDistance;
    }

    /**
     * @param string $address
     * @return string
     */
    protected function sanitizeAddressString($address)
    {
        $forbiddenCharacters = ['/', '\\'];
        return trim(str_replace($forbiddenCharacters, '-', $address));
    }
}
