<?php

namespace Mediaopt\DHL\Warenpost;

/**
 * The product that is used for the shipment of this item. Available products are:
 * GPP (Packet Plus),
 * GMP (Packet),
 * GMM (Business Mail Standard),
 * GMR (Business Mail Registered),
 * GPT (Packet Tracked).
 * 246/247/... (Internet Stamp Product)
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
class Product
{
    /**
     * @var string
     */
    const GPP = 'GPP';

    /**
     * @var string
     */
    const GMP = 'GMP';

    /**
     * @var string
     */
    const GMM = 'GMM';

    /**
     * @var string
     */
    const GMR = 'GMR';

    /**
     * @var string
     */
    const GPT = 'GPT';

    /**
     * Array containing all products.
     *
     * @var string[]
     */
    public static $PRODUCTS = [
        self::GPP,
        self::GMP,
        self::GMM,
        self::GMR,
        self::GPT,
    ];
}
