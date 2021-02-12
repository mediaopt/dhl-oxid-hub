<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ExclusionDayList
{

    /**
     * @var SpecialDayType $exclusionDay
     */
    protected $exclusionDay = null;

    /**
     * @param SpecialDayType $exclusionDay
     */
    public function __construct($exclusionDay)
    {
      $this->exclusionDay = $exclusionDay;
    }

    /**
     * @return SpecialDayType
     */
    public function getExclusionDay()
    {
      return $this->exclusionDay;
    }

    /**
     * @param SpecialDayType $exclusionDay
     * @return ExclusionDayList
     */
    public function setExclusionDay($exclusionDay)
    {
      $this->exclusionDay = $exclusionDay;
      return $this;
    }

}
