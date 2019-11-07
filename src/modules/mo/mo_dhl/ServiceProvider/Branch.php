<?php

namespace Mediaopt\DHL\ServiceProvider;

/**
 * This class is used to distinguish branches.
 *
 * @author  derksen mediaopt GmbH
 * @version ${VERSION}, ${REVISION}
 * @package Mediaopt\DHL\ServiceProvider
 */
class Branch
{
    /**
     * @param string $label
     * @return bool
     */
    public static function isBranch($label)
    {
        return self::isPackstation($label) || self::isFiliale($label);
    }

    /**
     * @param string $label
     * @return bool
     */
    public static function isPackstation($label)
    {
        return strtoupper($label) === 'PACKSTATION';
    }

    /**
     * @param string $label
     * @return bool
     */
    public static function isFiliale($label)
    {
        return self::isPostfiliale($label) || self::isPaketshop($label);
    }

    /**
     * @param string $label
     * @return bool
     */
    public static function isPostfiliale($label)
    {
        return strtoupper($label) === 'POSTFILIALE';
    }

    /**
     * @param string $label
     * @return bool
     */
    public static function isPaketshop($label)
    {
        return strtoupper($label) === 'PAKETSHOP';
    }
}
