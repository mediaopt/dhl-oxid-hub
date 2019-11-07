<?php

namespace Mediaopt\DHL\ServiceProvider;


/**
 * Represents a Packstation.
 *
 * @author derksen mediaopt GmbH
 * @package Mediaopt\DHL\ServiceProvider
 */
class Packstation extends BasicServiceProvider
{

    /**
     * @see BasicServiceProvider::toArray()
     * @return array
     */
    public function toArray()
    {
        return array_merge(['type' => 'Packstation'], parent::toArray());
    }

}
