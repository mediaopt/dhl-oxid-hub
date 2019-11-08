<?php

namespace Mediaopt\DHL\Address;

/**
 * This interface abstracts from addressable entities.
 *
 * @author  Mediaopt GmbH
 * @version ${VERSION}, ${REVISION}
 * @package Mediaopt\DHL
 */
interface Addressable
{
    /**
     * @return Address
     */
    public function getAddress();

    /**
     * @return string
     */
    public function getLine1();

    /**
     * @return string
     */
    public function getLine2();

    /**
     * @return string
     */
    public function getLine3();
}
