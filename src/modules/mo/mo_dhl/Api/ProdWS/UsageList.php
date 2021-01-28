<?php


namespace Mediaopt\DHL\Api\ProdWS;

class UsageList
{

    /**
     * @var GroupedPropertyType $usage
     */
    protected $usage = null;

    /**
     * @param GroupedPropertyType $usage
     */
    public function __construct($usage)
    {
      $this->usage = $usage;
    }

    /**
     * @return GroupedPropertyType
     */
    public function getUsage()
    {
      return $this->usage;
    }

    /**
     * @param GroupedPropertyType $usage
     * @return UsageList
     */
    public function setUsage($usage)
    {
      $this->usage = $usage;
      return $this;
    }

}
