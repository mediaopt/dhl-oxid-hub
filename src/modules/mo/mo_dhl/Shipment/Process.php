<?php

namespace Mediaopt\DHL\Shipment;

/**
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL\Export\Order
 */
class Process
{
    /**
     * @var string DHL Paket
     */
    const PAKET = 'PAKET';

    /**
     * @var string DHL Paket PRIO
     */
    const PAKET_PRIO = 'PAKET_PRIO';

    /**
     * @var string DHL Paket Taggleich
     */
    const PAKET_TAGGLEICH = 'PAKET_TAGGLEICH';

    /**
     * @var string DHL Retoure für DHL Paket
     */
    const RETOURE_FUER_PAKET = 'RETOURE_FUER_PAKET';

    /**
     * @var string DHL Retoure für DHL Paket Taggleich
     */
    const RETOURE_FUER_PAKET_TAGGLEICH = 'RETOURE_FUER_PAKET_TAGGLEICH';
    /**
     * @var string DHL Retoure für DHL Paket Austria
     */
    const RETOURE_FUER_PAKET_AT = 'RETOURE_FUER_PAKET_AT';
    /**
     * @var string DHL Retoure für DHL Paket Connect
     */
    const RETOURE_FUER_PAKET_CONNECT = 'RETOURE_FUER_PAKET_CONNECT';
    /**
     * @var string DHL Paket International
     */
    const PAKET_INTERNATIONAL = 'PAKET_INTERNATIONAL';

    /**
     * @var string DHL Europaket (B2B)
     */
    const EUROPAKET = 'EUROPAKET';

    /**
     * @var string DHL Paket Connect
     */
    const PAKET_CONNECT = 'PAKET_CONNECT';

    /**
     * @var string DHL Paket Austria
     */
    const PAKET_AT = 'PAKET_AT';

    /**
     * @var string DHL Paket Connect (Austria)
     */
    const PAKET_CONNECT_AT = 'PAKET_CONNECT_AT';

    /**
     * @var string DHL Paket International (Austria)
     */
    const PAKET_INTERNATIONAL_AT = 'PAKET_INTERNATIONAL_AT';

    /**
     * @var string Warenpost national
     */
    const WARENPOST = 'WARENPOST';

    /**
     * string Internetmarke
     */
    const INTERNETMARKE = 'INTERNETMARKE';

    /**
     * @var string Warenpost international
     */
    const WARENPOST_INTERNATIONAL = 'WARENPOST_INTERNATIONAL';

    /**
     * @var string
     */
    const SERVICE_PREFERRED_DAY = "SERVICE_PREFERRED_DAY";

    /**
     * @var string
     */
    const SERVICE_PREFERRED_NEIGHBOUR = "SERVICE_PREFERRED_NEIGHBOUR";

    /**
     * @var string
     */
    const SERVICE_PREFERRED_LOCATION = "SERVICE_PREFERRED_LOCATION";

    /**
     * @var string
     */
    const SERVICE_NOTIFICATION = "SERVICE_NOTIFICATION";

    /**
     * @var string
     */
    const SERVICE_GO_GREEN = "SERVICE_GO_GREEN";

    /**
     * @var string
     */
    const SERVICE_PARCEL_OUTLET_ROUTING = "SERVICE_PARCEL_OUTLET_ROUTING";

    /**
     * @var string
     */
    const SERVICE_DHL_RETOURE = "SERVICE_DHL_RETOURE";

    /**
     * @var string
     */
    const SERVICE_VISUAL_AGE_CHECK = "SERVICE_VISUAL_AGE_CHECK";

    /**
     * @var string
     */
    const SERVICE_ADDITIONAL_INSURANCE = "SERVICE_ADDITIONAL_INSURANCE";

    /**
     * @var string
     */
    const SERVICE_BULKY_GOOD = "SERVICE_BULKY_GOOD";

    /**
     * @var string
     */
    const SERVICE_CASH_ON_DELIVERY = "SERVICE_CASH_ON_DELIVERY";

    /**
     * @var string
     */
    const SERVICE_IDENT_CHECK = "SERVICE_IDENT_CHECK";

    /**
     * @var string
     */
    const SERVICE_PREMIUM = "SERVICE_PREMIUM";

    /**
     * @var string
     */
    const SERVICE_ENDORSEMENT = "SERVICE_ENDORSEMENT";

    /**
     * @var string[]
     */
    const SUPPORTED_SERVICES = [
        self::PAKET => [
            self::SERVICE_PREFERRED_NEIGHBOUR,
            self::SERVICE_PREFERRED_LOCATION,
            self::SERVICE_NOTIFICATION,
            self::SERVICE_PREFERRED_DAY,
            self::SERVICE_GO_GREEN,
            self::SERVICE_PARCEL_OUTLET_ROUTING,
            self::SERVICE_DHL_RETOURE,
            self::SERVICE_VISUAL_AGE_CHECK,
            self::SERVICE_IDENT_CHECK,
            self::SERVICE_ADDITIONAL_INSURANCE,
            self::SERVICE_BULKY_GOOD,
            self::SERVICE_CASH_ON_DELIVERY,
        ],
        self::PAKET_PRIO => [
            self::SERVICE_PREFERRED_NEIGHBOUR,
            self::SERVICE_PREFERRED_LOCATION,
            self::SERVICE_NOTIFICATION,
            self::SERVICE_PREFERRED_DAY,
            self::SERVICE_GO_GREEN,
            self::SERVICE_PARCEL_OUTLET_ROUTING,
            self::SERVICE_DHL_RETOURE,
            self::SERVICE_VISUAL_AGE_CHECK,
            self::SERVICE_IDENT_CHECK,
            self::SERVICE_ADDITIONAL_INSURANCE,
            self::SERVICE_CASH_ON_DELIVERY,
        ],
        self::PAKET_INTERNATIONAL => [
            self::SERVICE_NOTIFICATION,
            self::SERVICE_GO_GREEN,
            self::SERVICE_ADDITIONAL_INSURANCE,
            self::SERVICE_BULKY_GOOD,
            self::SERVICE_PREMIUM,
            self::SERVICE_ENDORSEMENT,
        ],
        self::EUROPAKET => [
            self::SERVICE_NOTIFICATION,
            self::SERVICE_GO_GREEN,
            self::SERVICE_ADDITIONAL_INSURANCE,
        ],
        self::PAKET_CONNECT => [
            self::SERVICE_NOTIFICATION,
            self::SERVICE_GO_GREEN,
            self::SERVICE_DHL_RETOURE,
            self::SERVICE_ADDITIONAL_INSURANCE,
            self::SERVICE_BULKY_GOOD,
        ],
        self::WARENPOST => [
            self::SERVICE_PREFERRED_NEIGHBOUR,
            self::SERVICE_PREFERRED_LOCATION,
            self::SERVICE_NOTIFICATION,
            self::SERVICE_GO_GREEN,
            self::SERVICE_PARCEL_OUTLET_ROUTING,
            self::SERVICE_DHL_RETOURE,
        ],
        self::INTERNETMARKE => [
        ],
        self::WARENPOST_INTERNATIONAL => [
            self::SERVICE_GO_GREEN,
            self::SERVICE_PREMIUM,
        ]
    ];

    /**
     * @var string
     */
    protected $identifier;

    /**
     * @param string $identifier
     */
    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return Process
     * @throws \InvalidArgumentException
     */
    public static function build($identifier)
    {
        $constant = __CLASS__ . '::' . $identifier;
        if (!defined($constant) || constant($constant) !== $identifier) {
            throw new \InvalidArgumentException('Invalid process identifier');
        }

        return new self($identifier);
    }

    /**
     * @param string $identifier
     * @return Process
     * @throws \InvalidArgumentException
     */
    public static function buildForRetoure($identifier)
    {
        $constant = __CLASS__ . '::RETOURE_FUER_' . $identifier;
        if (!defined($constant) || constant($constant) !== 'RETOURE_FUER_' . $identifier) {
            throw new \InvalidArgumentException('Invalid process identifier');
        }


        return new self('RETOURE_FUER_' . $identifier);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        /** @var string[] $identifierToNumber */
        $identifierToNumber = [
            self::PAKET                        => '01',
            self::PAKET_PRIO                   => '01',
            self::PAKET_TAGGLEICH              => '06',
            self::PAKET_INTERNATIONAL          => '53',
            self::EUROPAKET                    => '54',
            self::PAKET_CONNECT                => '55',
            self::WARENPOST                    => '62',
            self::WARENPOST_INTERNATIONAL      => '66',
            self::PAKET_AT                     => '86',
            self::PAKET_CONNECT_AT             => '87',
            self::PAKET_INTERNATIONAL_AT       => '82',
            self::RETOURE_FUER_PAKET           => '07',
            self::RETOURE_FUER_PAKET_TAGGLEICH => '07',
            self::RETOURE_FUER_PAKET_CONNECT   => '85',
            self::RETOURE_FUER_PAKET_AT        => '85',
        ];

        return $identifierToNumber[$this->identifier];
    }

    /**
     * @param string $service
     * @return string[]
     */
    public static function getProcessesSupportingService($service)
    {
        $services = array_filter(self::SUPPORTED_SERVICES, function($services) use ($service) {
            return in_array($service, $services);
        });
        return array_keys($services);
    }

    /**
     * @return bool
     */
    public function supportsPreferredNeighbour()
    {
        return in_array(self::SERVICE_PREFERRED_NEIGHBOUR, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsPreferredLocation()
    {
        return in_array(self::SERVICE_PREFERRED_LOCATION, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsNotification()
    {
        return in_array(self::SERVICE_NOTIFICATION, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsPreferredDay()
    {
        return in_array(self::SERVICE_PREFERRED_DAY, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsGoGreen()
    {
        return in_array(self::SERVICE_GO_GREEN, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsParcelOutletRouting()
    {
        return in_array(self::SERVICE_PARCEL_OUTLET_ROUTING, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsDHLRetoure()
    {
        return in_array(self::SERVICE_DHL_RETOURE, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsVisualAgeCheck() : bool
    {
        return in_array(self::SERVICE_VISUAL_AGE_CHECK, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsAdditionalInsurance() : bool
    {
        return in_array(self::SERVICE_ADDITIONAL_INSURANCE, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsIdentCheck() : bool
    {
        return in_array(self::SERVICE_IDENT_CHECK, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsBulkyGood() : bool
    {
        return in_array(self::SERVICE_BULKY_GOOD, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsCashOnDelivery() : bool
    {
        return in_array(self::SERVICE_CASH_ON_DELIVERY, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsPremium() : bool
    {
        return in_array(self::SERVICE_PREMIUM, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    public function supportsEndorsement() : bool
    {
        return in_array(self::SERVICE_ENDORSEMENT, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return string
     */
    public function getServiceIdentifier()
    {
        $identifierToService = [
            self::PAKET                        => 'V01PAK',
            self::PAKET_PRIO                   => 'V01PRIO',
            self::PAKET_TAGGLEICH              => 'V06PAK',
            self::PAKET_INTERNATIONAL          => 'V53WPAK',
            self::EUROPAKET                    => 'V54EPAK',
            self::PAKET_CONNECT                => 'V55PAK',
            self::WARENPOST                    => 'V62WP',
            self::WARENPOST_INTERNATIONAL      => 'V66WPI',
            self::PAKET_AT                     => 'V86PARCEL',
            self::PAKET_CONNECT_AT             => 'V87PARCEL',
            self::PAKET_INTERNATIONAL_AT       => 'V82PARCEL',
            self::RETOURE_FUER_PAKET           => 'V01PAK',
            self::RETOURE_FUER_PAKET_TAGGLEICH => 'V06PAK',
            self::RETOURE_FUER_PAKET_CONNECT   => 'V87PARCEL',
            self::RETOURE_FUER_PAKET_AT        => 'V86PARCEL',
        ];

        return $identifierToService[$this->identifier];
    }

    /**
     * @return bool
     */
    public function isInternational()
    {
        return in_array($this->identifier, [
            self::PAKET_INTERNATIONAL,
            self::PAKET_INTERNATIONAL_AT
        ]);
    }

    /**
     * @return bool
     */
    public function usesInternetMarke()
    {
        return $this->getIdentifier() === self::INTERNETMARKE;
    }

    /**
     * @return string[]
     */
    public static function getAvailableProcesses()
    {
        return [
            'PAKET'                  => 'DHL Paket',
            'PAKET_PRIO'             => 'DHL Paket PRIO',
            'PAKET_TAGGLEICH'        => 'DHL Paket Taggleich',
            'PAKET_INTERNATIONAL'    => 'DHL Paket International',
            'EUROPAKET'              => 'DHL Europaket (B2B)',
            'PAKET_CONNECT'          => 'DHL Paket Connect',
            'PAKET_AT'               => 'DHL Paket Austria',
            'PAKET_CONNECT_AT'       => 'DHL Paket Connect (Austria)',
            'PAKET_INTERNATIONAL_AT' => 'DHL Paket International (Austria)',
            'WARENPOST'              => 'Warenpost national',
            'INTERNETMARKE'          => 'Internetmarke',
            'WARENPOST_INTERNATIONAL'=> 'Warenpost International',
        ];
    }
}
