<?php


namespace Mediaopt\DHL\Api\ProdWS;

class DateValueType
{

    /**
     * @var date $firstDate
     */
    protected $firstDate = null;

    /**
     * @var date $lastDate
     */
    protected $lastDate = null;

    /**
     * @var date $fixDate
     */
    protected $fixDate = null;

    /**
     * @param date $firstDate
     * @param date $lastDate
     * @param date $fixDate
     */
    public function __construct($firstDate, $lastDate, $fixDate)
    {
      $this->firstDate = $firstDate;
      $this->lastDate = $lastDate;
      $this->fixDate = $fixDate;
    }

    /**
     * @return date
     */
    public function getFirstDate()
    {
      return $this->firstDate;
    }

    /**
     * @param date $firstDate
     * @return DateValueType
     */
    public function setFirstDate($firstDate)
    {
      $this->firstDate = $firstDate;
      return $this;
    }

    /**
     * @return date
     */
    public function getLastDate()
    {
      return $this->lastDate;
    }

    /**
     * @param date $lastDate
     * @return DateValueType
     */
    public function setLastDate($lastDate)
    {
      $this->lastDate = $lastDate;
      return $this;
    }

    /**
     * @return date
     */
    public function getFixDate()
    {
      return $this->fixDate;
    }

    /**
     * @param date $fixDate
     * @return DateValueType
     */
    public function setFixDate($fixDate)
    {
      $this->fixDate = $fixDate;
      return $this;
    }

}
