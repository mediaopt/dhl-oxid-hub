<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 Mediaopt GmbH
 */

namespace Mediaopt\DHL\ServiceProvider;

use Mediaopt\DHL\Exception\ServiceProviderException;

/**
 * Class that summarizes all services types that are available.
 *
 * @author Mediaopt GmbH
 * @version ${VERSION}, ${REVISION}
 * @package ${NAMESPACE}
 */
class ServiceType
{

    /**
     * @var string
     */
    const AGE_VERIFICATION = 'AGE_VERIFICATION';

    /**
     * @var string
     */
    const BIRTHDAY_DISCOUNT = 'BIRTHDAY_DISCOUNT';

    /**
     * @var string
     */
    const CASH_SERVICE = 'CASH_SERVICE';

    /**
     * @var string
     */
    const COD = 'COD';

    /**
     * @var string
     */
    const DIRECT_DELIVERY_BY_DHLEXPRESS = 'DIRECT_DELIVERY_BY_DHLEXPRESS';

    /**
     * @var string
     */
    const ECO_FRIENDLY = 'ECO_FRIENDLY';

    /**
     * @var string
     */
    const FRANKING = 'FRANKING';

    /**
     * @var string
     */
    const HANDICAPPED_ACCESS = 'HANDICAPPED_ACCESS';

    /**
     * @var string
     */
    const HAS_XL_POSTFACH = 'HAS_XL_POSTFACH';

    /**
     * @var string
     */
    const MAILBOX = 'MAILBOX';

    /**
     * @var string
     */
    const PACKING_MATERIAL = 'PACKING_MATERIAL';

    /**
     * @var string
     */
    const PARCEL_ACCEPTANCE = 'PARCEL_ACCEPTANCE';

    /**
     * @var string
     */
    const PARCEL_PICKUP = 'PARCEL_PICKUP';

    /**
     * @var string
     */
    const PARKING = 'PARKING';

    /**
     * @var string
     */
    const PICKUP_BY_DHLEXPRESS = 'PICKUP_BY_DHLEXPRESS';

    /**
     * @var string
     */
    const PIN_SERVICE = 'PIN_SERVICE';

    /**
     * @var string
     */
    const PRINT_AVAILABILITY = 'PRINT_AVAILABILITY';

    /**
     * @var string
     */
    const SECURE_SHIPMENT = 'SECURE_SHIPMENT';

    /**
     * @var string
     */
    const SHOP_SERVICES = 'SHOP_SERVICES';

    /**
     * Array containing all service types.
     *
     * @var string[]
     */
    public static $SERVICE_TYPES = [
        self::AGE_VERIFICATION,
        self::BIRTHDAY_DISCOUNT,
        self::CASH_SERVICE,
        self::COD,
        self::DIRECT_DELIVERY_BY_DHLEXPRESS,
        self::ECO_FRIENDLY,
        self::FRANKING,
        self::HANDICAPPED_ACCESS,
        self::HAS_XL_POSTFACH,
        self::MAILBOX,
        self::PACKING_MATERIAL,
        self::PARCEL_ACCEPTANCE,
        self::PARCEL_PICKUP,
        self::PARKING,
        self::PICKUP_BY_DHLEXPRESS,
        self::PIN_SERVICE,
        self::PRINT_AVAILABILITY,
        self::SECURE_SHIPMENT,
        self::SHOP_SERVICES,
    ];

    /**
     * One element of static::$SERVICE_TYPES.
     *
     * @var string
     */
    protected $serviceTypeName = '';

    /**
     * @param string $serviceTypeName
     */
    protected function __construct($serviceTypeName)
    {
        $this->serviceTypeName = $serviceTypeName;
    }

    /**
     * @param string $serviceTypeName
     * @return $this
     * @throws ServiceProviderException
     */
    public static function create($serviceTypeName)
    {
        if (empty($serviceTypeName) || !in_array($serviceTypeName, static::$SERVICE_TYPES, true)) {
            $message = __CLASS__ . '::' . __METHOD__ . " - Cannot build a service type `$serviceTypeName'.";
            throw new ServiceProviderException($message, ServiceProviderException::UNKNOWN_SERVICE_TYPE);
        }
        return new static($serviceTypeName);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->serviceTypeName;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

}
