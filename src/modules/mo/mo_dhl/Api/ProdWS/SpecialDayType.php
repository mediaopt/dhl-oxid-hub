<?php


namespace Mediaopt\DHL\Api\ProdWS;

class SpecialDayType
{

    /**
     * @var date $date
     */
    protected $date = null;

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var Region[] $region
     */
    protected $region = null;

    /**
     * @param date     $date
     * @param Region[] $region
     */
    public function __construct($date, array $region)
    {
      $this->date = $date;
      $this->region = $region;
    }

    /**
     * @return date
     */
    public function getDate()
    {
      return $this->date;
    }

    /**
     * @param date $date
     * @return SpecialDayType
     */
    public function setDate($date)
    {
      $this->date = $date;
      return $this;
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
     * @return SpecialDayType
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return Region[]
     */
    public function getRegion()
    {
      return $this->region;
    }

    /**
     * @param Region[] $region
     * @return SpecialDayType
     */
    public function setRegion(array $region)
    {
      $this->region = $region;
      return $this;
    }

}
