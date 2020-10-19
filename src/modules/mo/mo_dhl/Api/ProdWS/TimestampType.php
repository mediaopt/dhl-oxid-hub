<?php


namespace Mediaopt\DHL\Api\ProdWS;

class TimestampType
{

    /**
     * @var date $date
     */
    protected $date = null;

    /**
     * @var time $time
     */
    protected $time = null;

    /**
     * @param date $date
     * @param time $time
     */
    public function __construct($date, $time)
    {
      $this->date = $date;
      $this->time = $time;
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
     * @return TimestampType
     */
    public function setDate($date)
    {
      $this->date = $date;
      return $this;
    }

    /**
     * @return time
     */
    public function getTime()
    {
      return $this->time;
    }

    /**
     * @param time $time
     * @return TimestampType
     */
    public function setTime($time)
    {
      $this->time = $time;
      return $this;
    }

}
