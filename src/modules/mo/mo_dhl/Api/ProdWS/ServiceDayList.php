<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ServiceDayList
{

    /**
     * @var DayType $serviceDay
     */
    protected $serviceDay = null;

    /**
     * @param DayType $serviceDay
     */
    public function __construct($serviceDay)
    {
      $this->serviceDay = $serviceDay;
    }

    /**
     * @return DayType
     */
    public function getServiceDay()
    {
      return $this->serviceDay;
    }

    /**
     * @param DayType $serviceDay
     * @return ServiceDayList
     */
    public function setServiceDay($serviceDay)
    {
      $this->serviceDay = $serviceDay;
      return $this;
    }

}
