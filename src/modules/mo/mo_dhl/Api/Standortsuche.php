<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 Mediaopt GmbH
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
 * @author  Mediaopt GmbH
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
        return 'find-by-address';
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
     * Generates a string with basic sanitization from the supplied address.
     *
     * @param Address|string $address
     * @param string|null $postalCode
     * @return string
     */
    protected function buildAddressString($address, $postalCode = null)
    {
        if ($address instanceof Address) {
            $postalCode = $address->getZip();
            $address = $address->getStreet() . " " . $address->getStreetNo();
        }

        $urlOptions = [
            "countryCode=DE",
            "postalCode=$postalCode",
            "streetAddress=$address",
            'limit=50'
        ];

        return $this->sanitizeAddressString(implode('&', $urlOptions));
    }

    /**
     * @param Address|string $address
     * @param null $postalCode
     * @return ServiceProviderList
     * @throws WebserviceException
     */
    public function getParcellocationByAddress($address, $postalCode = null)
    {
        $addressString = $this->buildAddressString($address, $postalCode);
        if ($addressString === '') {
            return new ServiceProviderList([]);
        }
        $locations = $this->callApi($addressString);
        $oldAPIstandart = $this->convert($locations);

        return $this->extractServiceProviders($oldAPIstandart);
    }

    /**
     * @param BasicServiceProvider|null $potentialServiceProvider
     * @return bool
     */
    protected function isServiceProviderAllowed($potentialServiceProvider)
    {
        if ($potentialServiceProvider === null || $potentialServiceProvider->getAddress()->getCountry() !== 'de') {
            return false;
        }

        return $potentialServiceProvider->getLocation()->getDistance() <= self::MAXIMUM_DISTANCE_GERMANY;
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

    protected function buildRequestOptions()
    {
        $credentials = $this->getCredentials();
        return ['headers' => [$credentials->getUsername() => $credentials->getPassword()]];
    }

    /**
     * @param string $relativeUrl
     * @return string
     */
    protected function buildUrl($relativeUrl)
    {
        return "{$this->getCredentials()->getEndpoint()}/{$this->getIdentifier()}?$relativeUrl";
    }

    /**
     * @param $items
     * @return object
     */
    private function convert($items)
    {
        $newItems = [];
        foreach ($items->locations as $item) {
            $psfServicetypes = $this->buildPsfServicetypes($item->serviceTypes);
            if ($psfServicetypes === false) {
                $item->location->type = '';
            }

            $locationId = $item->location->ids[0]->locationId;

            $systemID = $locationId;
            $primaryKeyDeliverySystem = '';
            if (stripos('-', $locationId)) {
                [$systemID, $primaryKeyDeliverySystem] = explode('-', $locationId);
            }

            $newItems[] = (object)[
                'countryCode' => strtolower($item->place->address->countryCode),
                'zipCode' => $item->place->address->postalCode,
                'city' => $item->place->address->addressLocality,
                'district' => null,
                'additionalInfo' => null,
                'area' => null,
                'street' => $item->place->address->streetAddress,
                'houseNo' => '',
                'keyWord' => $item->location->keyword,
                'shopType' => $this->buildshopType($item->location->type),
                'shopName' => $item->name,
                'geoPosition' => (object)[
                    'latitude' => $item->place->geo->latitude,
                    'longitude' => $item->place->geo->longitude,
                    'distance' => $item->distance
                ],
                'primaryKeyDeliverySystem' => $primaryKeyDeliverySystem,
                'primaryKeyZipRegion' => $item->location->keywordId,
                'systemID' => $systemID,
                'primaryKeyPSF' => $item->location->ids[0]->locationId,
                'psfServicetypes' => $psfServicetypes,
                'openingHours' => $item->openingHours,
            ];
        }

        return (object)['psfParcellocationList' => $newItems];
    }

    /**
     * @param $array
     * @return array|false
     */
    private function buildPsfServicetypes(array $array)
    {
        $pickupAvaliable = false;
        $return = [];
        foreach ($array as $item) {
            switch ($item) {
                case 'parcel:pick-up':
                case 'parcel:pick-up-registered':
                case 'parcel:pick-up-unregistered':
                case 'express:pick-up':
                    $pickupAvaliable = true;
                    $return[] = 'parcelpickup';
                    break;
                case 'postident':
                    $return[] = 'postident';
                    break;
                case 'handicapped-access':
                    $return[] = 'handicappedAccess';
                    break;
                case 'cash-on-delivery':
                    $return[] = 'COD';
                    break;
                case 'parcel:drop-off':
                case 'express:drop-off':
                case 'parcel:drop-off-unregistered':
                    $return[] = 'parcelacceptance';
                    break;
                case 'parking':
                case 'franking' :
                    $return[] = $item;
                    break;
                case 'age-verification':
                    $return[] = 'ageVerification';
                    break;
                case 'packaging-material' :
                    $return[] = 'packingMaterial';
                    break;
                case 'cash-service' :
                    $return[] = 'cashService';
                    break;
                default:
                    break;
            }
        }
        return $pickupAvaliable ? $return : false;
    }

    /**
     * @param $type
     * @return string
     */
    private function buildshopType($type)
    {
        switch ($type) {
            case 'postoffice':
            case 'postbank':
                return 'postOffice';
            case 'servicepoint':
                return 'parcelShop';
            case 'locker':
                return 'packStation';
            default:
                return '';
        }
    }
}
