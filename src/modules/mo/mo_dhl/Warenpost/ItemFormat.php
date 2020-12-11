<?php

namespace Mediaopt\DHL\Warenpost;

/**
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
class ItemFormat
{
    /**
     * @var string
     */
    const P = 'P';

    /**
     * @var string
     */
    const G = 'G';

    /**
     * @var string
     */
    const E = 'E';

    /**
     * @var string
     */
    const MIXED = 'MIXED';

    /**
     * Array containing all item formats.
     *
     * @var string[]
     */
    public static $ITEM_FORMATS = [
        self::P,
        self::G,
        self::E,
        self::MIXED,
    ];
}
