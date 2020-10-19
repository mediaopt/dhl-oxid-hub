<?php


namespace Mediaopt\DHL\Api\ProdWS;

class SpecialServiceList
{

    /**
     * @var SpecialServiceType $SpecialService
     */
    protected $SpecialService = null;

    /**
     * @param SpecialServiceType $SpecialService
     */
    public function __construct($SpecialService)
    {
      $this->SpecialService = $SpecialService;
    }

    /**
     * @return SpecialServiceType
     */
    public function getSpecialService()
    {
      return $this->SpecialService;
    }

    /**
     * @param SpecialServiceType $SpecialService
     * @return SpecialServiceList
     */
    public function setSpecialService($SpecialService)
    {
      $this->SpecialService = $SpecialService;
      return $this;
    }

}
