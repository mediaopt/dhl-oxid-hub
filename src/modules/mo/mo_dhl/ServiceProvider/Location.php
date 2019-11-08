<?php

namespace Mediaopt\DHL\ServiceProvider;

/**
 * This class represents a location and its distance to a zip/city combination.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL
 */
class Location
{
    /**
     * @var Coordinates
     */
    protected $coordinates;

    /**
     * @var int
     */
    protected $distance;

    /**
     * @param Coordinates $coordinates
     * @param int         $distance
     */
    public function __construct(Coordinates $coordinates, $distance)
    {
        $this->coordinates = $coordinates;
        $this->distance = (int)$distance;
    }

    /**
     * @see $distance
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @return Coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }


    /**
     * @return mixed[]
     */
    public function toArray()
    {
        $coordinates = $this->getCoordinates();
        return [
            'latitude'  => $coordinates->getLatitude(),
            'longitude' => $coordinates->getLongitude(),
            'distance'  => $this->getDistance(),
        ];
    }
}
