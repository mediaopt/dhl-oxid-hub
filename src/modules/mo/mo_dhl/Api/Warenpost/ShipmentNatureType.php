<?php

namespace Mediaopt\DHL\Api\Warenpost;

/**
 * Nature of the pieces in this item, based on UPU code list 136.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
class ShipmentNatureType
{
    /**
     * @var string
     */
    const SALE_GOODS = 'SALE_GOODS';

    /**
     * @var string
     */
    const RETURN_GOODS = 'RETURN_GOODS';

    /**
     * @var string
     */
    const GIFT = 'GIFT';

    /**
     * @var string
     */
    const COMMERCIAL_SAMPLE = 'COMMERCIAL_SAMPLE';

    /**
     * @var string
     */
    const DOCUMENTS = 'DOCUMENTS';

    /**
     * @var string
     */
    const MIXED_CONTENTS = 'MIXED_CONTENTS';

    /**
     * @var string
     */
    const OTHERS = 'OTHERS';

    /**
     * Array containing all shipment nature types.
     *
     * @var string[]
     */
    public static $TYPES = [
        self::SALE_GOODS,
        self::RETURN_GOODS,
        self::GIFT,
        self::COMMERCIAL_SAMPLE,
        self::DOCUMENTS,
        self::MIXED_CONTENTS,
        self::OTHERS
    ];
}
