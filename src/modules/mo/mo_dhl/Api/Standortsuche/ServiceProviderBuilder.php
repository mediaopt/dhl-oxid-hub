<?php

namespace Mediaopt\DHL\Api\Standortsuche;

use Mediaopt\DHL\Address\Address;
use Mediaopt\DHL\Exception\ServiceProviderException;
use Mediaopt\DHL\ServiceProvider\BasicServiceProvider;
use Mediaopt\DHL\ServiceProvider\Coordinates;
use Mediaopt\DHL\ServiceProvider\Filiale;
use Mediaopt\DHL\ServiceProvider\Location;
use Mediaopt\DHL\ServiceProvider\Packstation;
use Mediaopt\DHL\ServiceProvider\Paketshop;
use Mediaopt\DHL\ServiceProvider\ServiceInformation;
use Mediaopt\DHL\ServiceProvider\ServiceType;
use Mediaopt\DHL\ServiceProvider\Timetable\Timetable;

/**
 * This class provides functionality to build a service provider.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL\Standortsuche
 */
class ServiceProviderBuilder
{

    /**
     * Mapping from the API service types to internal service types.
     *
     * @var string[]
     */
    public static $API_SERVICE_TYPE_MAPPING = [
        'ageVerification'    => ServiceType::AGE_VERIFICATION,
        'cashService'        => ServiceType::CASH_SERVICE,
        'COD'                => ServiceType::COD,
        'ecoFriendly'        => ServiceType::ECO_FRIENDLY,
        'franking'           => ServiceType::FRANKING,
        'handicappedAccess'  => ServiceType::HANDICAPPED_ACCESS,
        'hasXLPostfach'      => ServiceType::HAS_XL_POSTFACH,
        'mailbox'            => ServiceType::MAILBOX,
        'packingMaterial'    => ServiceType::PACKING_MATERIAL,
        'parcelacceptance'   => ServiceType::PARCEL_ACCEPTANCE,
        'parcelpickup'       => ServiceType::PARCEL_PICKUP,
        'parking'            => ServiceType::PARKING,
        'PINService'         => ServiceType::PIN_SERVICE,
        'pickupByDHLExpress' => ServiceType::PICKUP_BY_DHLEXPRESS,
        'printAvailability'  => ServiceType::PRINT_AVAILABILITY,
        'secureShipment'     => ServiceType::SECURE_SHIPMENT,
        'shopServices'       => ServiceType::SHOP_SERVICES,
    ];

    public const DHL_COUNTRIES_LIST = [
         'AT' => 'Austria',
         'BE' => 'Belgium',
         'BG' => 'Bulgaria',
         'CZ' => 'Czechia',
         'DE' => 'Germany',
         'DK' => 'Denmark',
         'EE' => 'Estonia',
         'ES' => 'Spain',
         'FI' => 'Finland',
         'FR' => 'France',
         'GB' => 'United Kingdom of Great Britain and Northern Ireland',
         'GR' => 'Greece',
         'HR' => 'Croatia',
         'HU' => 'Hungary',
         'IE' => 'Ireland',
         'LT' => 'Lithuania',
         'LU' => 'Luxembourg',
         'LV' => 'Latvia',
         'NL' => 'Netherlands',
         'NO' => 'Norway',
         'PL' => 'Poland',
         'PT' => 'Portugal',
         'RO' => 'Romania',
         'SE' => 'Sweden',
         'SI' => 'Slovenia',
         'SK' => 'Slovakia',
         'UA' => 'Ukraine',
    ];

    /**
     * @var TimetableBuilder
     */
    protected $timetableBuilder;

    /**
     * @param TimetableBuilder|null $timetableBuilder
     */
    public function __construct(TimetableBuilder $timetableBuilder = null)
    {
        $this->timetableBuilder = $timetableBuilder ?: new TimetableBuilder();
    }

    /**
     * @return TimetableBuilder
     */
    public function getTimetableBuilder()
    {
        return $this->timetableBuilder;
    }

    /**
     * @param \stdClass $object
     * @return BasicServiceProvider
     * @throws ServiceProviderException
     */
    public function build(\stdClass $object)
    {
        assert(property_exists($object, 'shopType'));

        switch ($object->shopType) {
            case 'packStation':
                return $this->buildPackstation($object);
            case 'postOffice':
                return $this->buildPostfiliale($object);
            case 'parcelShop':
                return $this->buildPaketshop($object);
        }

        $message = "Cannot build a service provider from object with unknown shopType '{$object->shopType}'";
        throw new ServiceProviderException($message, ServiceProviderException::UNKNOWN_PROVIDER_TYPE);
    }

    /**
     * @param \stdClass $packstation
     * @return Packstation
     */
    protected function buildPackstation(\stdClass $packstation)
    {
        return new Packstation(
            $packstation->primaryKeyPSF,
            $packstation->primaryKeyZipRegion,
            $this->extractAddress($packstation),
            $this->extractLocation($packstation),
            $this->extractServiceInformation($packstation)
        );
    }

    /**
     * @param \stdClass $postfiliale
     * @return Filiale
     */
    protected function buildPostfiliale(\stdClass $postfiliale)
    {
        return new Filiale(
            $postfiliale->primaryKeyPSF,
            $postfiliale->primaryKeyZipRegion,
            $postfiliale->shopName,
            $this->extractAddress($postfiliale),
            $this->extractLocation($postfiliale),
            $this->extractServiceInformation($postfiliale)
        );
    }

    /**
     * @param \stdClass $paketshop
     * @return Paketshop
     */
    protected function buildPaketshop(\stdClass $paketshop)
    {
        return new Paketshop(
            $paketshop->primaryKeyPSF,
            $paketshop->primaryKeyZipRegion,
            $paketshop->shopName,
            $this->extractAddress($paketshop),
            $this->extractLocation($paketshop),
            $this->extractServiceInformation($paketshop)
        );
    }

    /**
     * @param \stdClass $object
     * @return Address
     */
    protected function extractAddress(\stdClass $object)
    {
        return new Address(
            $object->street,
            $object->houseNo,
            $object->zipCode,
            $object->city,
            $object->district,
            $object->countryCode,
            $object->countryCode
        );
    }

    /**
     * @param \stdClass $object
     * @return Location
     */
    protected function extractLocation(\stdClass $object)
    {
        $coordinates = new Coordinates($object->geoPosition->latitude, $object->geoPosition->longitude);
        return new Location($coordinates, $object->geoPosition->distance);
    }

    /**
     * @param \stdClass $object
     * @return ServiceInformation
     */
    protected function extractServiceInformation(\stdClass $object)
    {
        return new ServiceInformation(
            $this->extractTimetable($object),
            $this->extractServiceTypes($object),
            $this->extractRemark($object)
        );
    }

    /**
     * @param \stdClass $object
     * @return string[]
     */
    protected function extractRemark(\stdClass $object)
    {
        if (!property_exists($object, 'psfWelcometexts')) {
            return [];
        }

        $remark = [];
        foreach ((array)$object->psfWelcometexts as $welcomeText) {
            if (empty($welcomeText->language) || empty($welcomeText->content)) {
                continue;
            }
            $remark[$welcomeText->language] = $this->unescapeRemark((string)$welcomeText->content);
        }
        return $remark;
    }

    /**
     * @param string $content
     * @return string
     */
    protected function unescapeRemark($content)
    {
        return str_replace('#br#', '<br>', $content);
    }

    /**
     * @param \stdClass $object
     * @return Timetable
     */
    protected function extractTimetable(\stdClass $object)
    {
        try {
            return $this->getTimetableBuilder()->build($object->openingHours);
        } catch (\DomainException $exception) {
            return new Timetable();
        }
    }

    /**
     * @param \stdClass $object
     * @return ServiceType[]
     */
    protected function extractServiceTypes(\stdClass $object)
    {
        if (!property_exists($object, 'psfServicetypes')) {
            return [];
        }

        $serviceTypes = [];
        foreach ((array)$object->psfServicetypes as $apiServiceType) {
            try {
                $serviceTypes[] = $this->buildServiceTypeFromApiServiceType((string)$apiServiceType);
            } catch (ServiceProviderException $exception) {
            }
        }
        return $serviceTypes;
    }

    /**
     * @param string $apiServiceType
     * @return ServiceType
     * @throws ServiceProviderException
     */
    protected function buildServiceTypeFromApiServiceType($apiServiceType)
    {
        if (!array_key_exists($apiServiceType, static::$API_SERVICE_TYPE_MAPPING)) {
            $message = __CLASS__ . '::' . __METHOD__ . " - Did not recognize API's service type `$apiServiceType'.";
            throw new ServiceProviderException($message, ServiceProviderException::UNKNOWN_API_SERVICE_TYPE);
        }
        return ServiceType::create(static::$API_SERVICE_TYPE_MAPPING[$apiServiceType]);
    }

}
