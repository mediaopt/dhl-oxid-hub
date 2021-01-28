<?php


namespace Mediaopt\DHL\Api\ProdWS;

class NationalZipCodeGroupType
{

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var string $description
     */
    protected $description = null;

    /**
     * @var routeRegionType $routeRegion
     */
    protected $routeRegion = null;

    /**
     * @var routeZoneType $routeZone
     */
    protected $routeZone = null;

    /**
     * @var NationalZipCodeArea $nationalZipCodeArea
     */
    protected $nationalZipCodeArea = null;

    /**
     * @param routeRegionType     $routeRegion
     * @param routeZoneType       $routeZone
     * @param NationalZipCodeArea $nationalZipCodeArea
     */
    public function __construct($routeRegion, $routeZone, $nationalZipCodeArea)
    {
      $this->routeRegion = $routeRegion;
      $this->routeZone = $routeZone;
      $this->nationalZipCodeArea = $nationalZipCodeArea;
    }

    /**
     * @return string
     */
    public function getName()
    {
      return $this->name;
    }

    /**
     * @param string $name
     * @return NationalZipCodeGroupType
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
      return $this->description;
    }

    /**
     * @param string $description
     * @return NationalZipCodeGroupType
     */
    public function setDescription($description)
    {
      $this->description = $description;
      return $this;
    }

    /**
     * @return routeRegionType
     */
    public function getRouteRegion()
    {
      return $this->routeRegion;
    }

    /**
     * @param routeRegionType $routeRegion
     * @return NationalZipCodeGroupType
     */
    public function setRouteRegion($routeRegion)
    {
      $this->routeRegion = $routeRegion;
      return $this;
    }

    /**
     * @return routeZoneType
     */
    public function getRouteZone()
    {
      return $this->routeZone;
    }

    /**
     * @param routeZoneType $routeZone
     * @return NationalZipCodeGroupType
     */
    public function setRouteZone($routeZone)
    {
      $this->routeZone = $routeZone;
      return $this;
    }

    /**
     * @return NationalZipCodeArea
     */
    public function getNationalZipCodeArea()
    {
      return $this->nationalZipCodeArea;
    }

    /**
     * @param NationalZipCodeArea $nationalZipCodeArea
     * @return NationalZipCodeGroupType
     */
    public function setNationalZipCodeArea($nationalZipCodeArea)
    {
      $this->nationalZipCodeArea = $nationalZipCodeArea;
      return $this;
    }

}
