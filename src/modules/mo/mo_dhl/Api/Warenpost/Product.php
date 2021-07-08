<?php

namespace Mediaopt\DHL\Api\Warenpost;

use Mediaopt\DHL\Exception\WarenpostException;

/**
 * Product number in accordance with PPL.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
class Product
{
    use Validator;

    /**
     * @var string
     */
    const REGION_EU = 'EU';

    /**
     * @var string
     */
    const REGION_NON_EU = 'Non-EU';

    /**
     * @var string
     */
    const TRACKING_TYPE_UNTRACKED = 'Untracked';

    /**
     * @var string
     */
    const TRACKING_TYPE_TRACKED = 'Tracked';

    /**
     * @var string
     */
    const TRACKING_TYPE_SIGNATURE = 'Signature';

    /**
     * @var string
     */
    const PACKAGE_TYPE_XS = 'XS';

    /**
     * @var string
     */
    const PACKAGE_TYPE_S = 'S';

    /**
     * @var string
     */
    const PACKAGE_TYPE_L = 'L';

    /**
     * @var string
     */
    const PACKAGE_TYPE_M = 'M';

    /**
     * @var string
     */
    const PACKAGE_TYPE_KT = 'KT';

    /**
     * Array containing all target regions.
     *
     * @var string[]
     */
    public static $REGIONS = [
        self::REGION_EU,
        self::REGION_NON_EU,
    ];

    /**
     * Array containing all tracking types.
     *
     * @var string[]
     */
    public static $TRACKING_TYPES = [
        self::TRACKING_TYPE_UNTRACKED,
        self::TRACKING_TYPE_TRACKED,
        self::TRACKING_TYPE_SIGNATURE
    ];

    /**
     * Array containing all product sizes.
     *
     * @var string[]
     */
    public static $PACKAGE_TYPES = [
        self::PACKAGE_TYPE_XS,
        self::PACKAGE_TYPE_S,
        self::PACKAGE_TYPE_L,
        self::PACKAGE_TYPE_M,
        self::PACKAGE_TYPE_KT,
    ];

    /**
     * Array containing all products.
     *
     * @var string[]
     */
    public static $PRODUCTS = [
        self::REGION_EU => [
            self::TRACKING_TYPE_UNTRACKED => [
                self::PACKAGE_TYPE_XS => '10254',
                self::PACKAGE_TYPE_S => '10255',
                self::PACKAGE_TYPE_M => '10256',
                self::PACKAGE_TYPE_L => '10257',
                self::PACKAGE_TYPE_KT => '10270',
            ],
            self::TRACKING_TYPE_TRACKED => [
                self::PACKAGE_TYPE_XS => '10258',
                self::PACKAGE_TYPE_S => '10259',
                self::PACKAGE_TYPE_M => '10260',
                self::PACKAGE_TYPE_L => '10261',
                self::PACKAGE_TYPE_KT => '10271',
            ],
            self::TRACKING_TYPE_SIGNATURE => [
                self::PACKAGE_TYPE_XS => '10284',
                self::PACKAGE_TYPE_S => '10285',
                self::PACKAGE_TYPE_M => '10286',
                self::PACKAGE_TYPE_L => '10287',
                self::PACKAGE_TYPE_KT => '10292',
            ],
        ],
        self::REGION_NON_EU => [
            self::TRACKING_TYPE_UNTRACKED => [
                self::PACKAGE_TYPE_XS => '10246',
                self::PACKAGE_TYPE_S => '10247',
                self::PACKAGE_TYPE_M => '10248',
                self::PACKAGE_TYPE_L => '10249',
                self::PACKAGE_TYPE_KT => '10272',
            ],
            self::TRACKING_TYPE_TRACKED => [
                self::PACKAGE_TYPE_XS => '10250',
                self::PACKAGE_TYPE_S => '10251',
                self::PACKAGE_TYPE_M => '10252',
                self::PACKAGE_TYPE_L => '10253',
                self::PACKAGE_TYPE_KT => '10273',
            ],
            self::TRACKING_TYPE_SIGNATURE => [
                self::PACKAGE_TYPE_XS => '10280',
                self::PACKAGE_TYPE_S => '10281',
                self::PACKAGE_TYPE_M => '10282',
                self::PACKAGE_TYPE_L => '10283',
                self::PACKAGE_TYPE_KT => '10293',
            ],
        ]
    ];

    /**
     * @var string
     */
    protected $region;

    /**
     * @var string
     */
    protected $trackingType;

    /**
     * @var string
     */
    protected $size;

    /**
     * Product constructor.
     * @param string $region
     * @param string $trackingType
     * @param string $size
     */
    public function __construct(string $region, string $trackingType, string $size)
    {
        $this->region =$region;
        $this->trackingType = $trackingType;
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getProduct(): string
    {
        return self::$PRODUCTS[$this->region][$this->trackingType][$this->size];
    }

    /**
     * @return bool
     *
     * @throws WarenpostException
     */
    public function validate(): bool
    {
        $errorMessage = implode(' ,', array_merge(
            $this->isEnumFieldCorrect('region', $this->region, self::$REGIONS, true),
            $this->isEnumFieldCorrect('trackingType', $this->trackingType, self::$TRACKING_TYPES, true),
            $this->isEnumFieldCorrect('size', $this->size, self::$PACKAGE_TYPES, true)
        ));

        if (empty($errorMessage)) {
            return true;
        }

        $message = __CLASS__ . '::' . __METHOD__ . " " . $errorMessage;
        throw new WarenpostException($message, WarenpostException::PRODUCT_VALIDATION_ERROR);
    }
}
