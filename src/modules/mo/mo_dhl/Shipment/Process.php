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
     * @var string DHL Retoure für DHL Paket
     */
    const RETOURE_FUER_PAKET = 'RETOURE_FUER_PAKET';

    /**
     * @var string DHL Paket International
     */
    const PAKET_INTERNATIONAL = 'PAKET_INTERNATIONAL';

    /**
     * @var string DHL Europaket (B2B)
     */
    const EUROPAKET = 'EUROPAKET';

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
    const SERVICE_NO_NEIGHBOUR_DELIVERY = "SERVICE_NO_NEIGHBOUR_DELIVERY";

    /**
     * @var string
     */
    const SERVICE_NAMED_PERSON_ONLY = "SERVICE_NAMED_PERSON_ONLY";

    /**
     * @var string
     */
    const SERVICE_SIGNED_FOR_BY_RECIPIENT = "SERVICE_SIGNED_FOR_BY_RECIPIENT";

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
    const SERVICE_PDDP = "SERVICE_PDDP";

    /**
     * @var string
     */
    const SERVICE_PREMIUM = "SERVICE_PREMIUM";

    /**
     * @var string
     */
    const SERVICE_CDP = "SERVICE_CDP";

    /**
     * @var string
     */
    const SERVICE_ECONOMY = "SERVICE_ECONOMY";

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
            self::SERVICE_NO_NEIGHBOUR_DELIVERY,
            self::SERVICE_NAMED_PERSON_ONLY,
            self::SERVICE_SIGNED_FOR_BY_RECIPIENT,
        ],
        self::PAKET_INTERNATIONAL => [
            self::SERVICE_NOTIFICATION,
            self::SERVICE_GO_GREEN,
            self::SERVICE_ADDITIONAL_INSURANCE,
            self::SERVICE_BULKY_GOOD,
            self::SERVICE_PDDP,
            self::SERVICE_PREMIUM,
            self::SERVICE_CDP,
            self::SERVICE_ECONOMY,
            self::SERVICE_ENDORSEMENT,
        ],
        self::EUROPAKET => [
            self::SERVICE_NOTIFICATION,
            self::SERVICE_GO_GREEN,
            self::SERVICE_ADDITIONAL_INSURANCE,
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
            self::PAKET_INTERNATIONAL          => '53',
            self::EUROPAKET                    => '54',
            self::WARENPOST                    => '62',
            self::WARENPOST_INTERNATIONAL      => '66',
            self::RETOURE_FUER_PAKET           => '07',
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

    /**
     * @return bool
     */
    public function supportsNoNeighbourDelivery() : bool
    {
        return in_array(self::SERVICE_NO_NEIGHBOUR_DELIVERY, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsNamedPersonOnly() : bool
    {
        return in_array(self::SERVICE_NAMED_PERSON_ONLY, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsSignedForByRecipient() : bool
    {
        return in_array(self::SERVICE_SIGNED_FOR_BY_RECIPIENT, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsPDDP() : bool
    {
        return in_array(self::SERVICE_PDDP, self::SUPPORTED_SERVICES[$this->identifier]);
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
            self::PAKET_INTERNATIONAL          => 'V53WPAK',
            self::EUROPAKET                    => 'V54EPAK',
            self::WARENPOST                    => 'V62WP',
            self::WARENPOST_INTERNATIONAL      => 'V66WPI',
            self::RETOURE_FUER_PAKET           => 'V01PAK',
        ];

        return $identifierToService[$this->identifier];
    }

    /**
     * @return bool
     */
    public function supportsCDP() : bool
    {
        return in_array(self::SERVICE_CDP, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function supportsEconomy() : bool
    {
        return in_array(self::SERVICE_ECONOMY, self::SUPPORTED_SERVICES[$this->identifier]);
    }

    /**
     * @return bool
     */
    public function isInternational()
    {
        return in_array($this->identifier, [
            self::PAKET_INTERNATIONAL,
            self::WARENPOST_INTERNATIONAL,
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
            'PAKET_INTERNATIONAL'    => 'DHL Paket International',
            'EUROPAKET'              => 'DHL Europaket (B2B)',
            'WARENPOST'              => 'Warenpost national',
            'INTERNETMARKE'          => 'Internetmarke',
            'WARENPOST_INTERNATIONAL'=> 'Warenpost International',
        ];
    }
}
