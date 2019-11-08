<?php

namespace Mediaopt\DHL\ServiceProvider;

use Mediaopt\DHL\Address\Address;

/**
 * Represents a Filiale.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL\ServiceProvider
 */
class Filiale extends BasicServiceProvider
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string             $id
     * @param int                $number
     * @param string             $name
     * @param Address            $address
     * @param Location           $location
     * @param ServiceInformation $information
     */
    public function __construct(
        $id,
        $number,
        $name,
        Address $address,
        Location $location,
        ServiceInformation $information
    ) {
        parent::__construct($id, $number, $address, $location, $information);
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @see BasicServiceProvider::toArray()
     * @return array
     */
    public function toArray()
    {
        return array_merge(['type' => 'Filiale', 'name' => $this->getName()], parent::toArray());
    }

}
