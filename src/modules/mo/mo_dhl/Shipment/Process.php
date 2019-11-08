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
     * @var string DHL Retoure
     */
    const RETOURE = 'RETOURE';

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
     * @return string
     */
    public function __toString()
    {
        /** @var string[] $identifierToNumber */
        $identifierToNumber = [
            self::PAKET                  => '01',
            self::PAKET_PRIO             => '01',
            self::PAKET_TAGGLEICH        => '06',
            self::PAKET_INTERNATIONAL    => '53',
            self::EUROPAKET              => '54',
            self::PAKET_CONNECT          => '55',
            self::PAKET_AT               => '86',
            self::PAKET_CONNECT_AT       => '87',
            self::PAKET_INTERNATIONAL_AT => '82',
            self::RETOURE                => '06',
        ];

        return $identifierToNumber[$this->identifier];
    }

    /**
     * @return string
     */
    public function getServiceIdentifier()
    {
        $identifierToService = [
            self::PAKET                  => 'V01PAK',
            self::PAKET_PRIO             => 'V01PRIO',
            self::PAKET_TAGGLEICH        => 'V06PAK',
            self::PAKET_INTERNATIONAL    => 'V53WPAK',
            self::EUROPAKET              => 'V54EPAK',
            self::PAKET_CONNECT          => 'V55PAK',
            self::PAKET_AT               => 'V86PARCEL',
            self::PAKET_CONNECT_AT       => 'V87PARCEL',
            self::PAKET_INTERNATIONAL_AT => 'V82PARCEL',
            self::RETOURE                => 'V01PAK',
        ];

        return $identifierToService[$this->identifier];
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
            'RETOURE'                => 'DHL Retoure',
            'PAKET_INTERNATIONAL'    => 'DHL Paket International',
            'EUROPAKET'              => 'DHL Europaket (B2B)',
            'PAKET_CONNECT'          => 'DHL Paket Connect',
            'PAKET_AT'               => 'DHL Paket Austria',
            'PAKET_CONNECT_AT'       => 'DHL Paket Connect (Austria)',
            'PAKET_INTERNATIONAL_AT' => 'DHL Paket International (Austria)',
        ];
    }
}
