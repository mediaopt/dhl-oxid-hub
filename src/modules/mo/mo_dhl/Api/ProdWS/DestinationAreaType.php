<?php


namespace Mediaopt\DHL\Api\ProdWS;

class DestinationAreaType
{

    /**
     * @var NationalDestinationAreaType $nationalDestinationArea
     */
    protected $nationalDestinationArea = null;

    /**
     * @var InternationalDestinationAreaType $internationalDestinationArea
     */
    protected $internationalDestinationArea = null;

    /**
     * @param NationalDestinationAreaType      $nationalDestinationArea
     * @param InternationalDestinationAreaType $internationalDestinationArea
     */
    public function __construct($nationalDestinationArea, $internationalDestinationArea)
    {
      $this->nationalDestinationArea = $nationalDestinationArea;
      $this->internationalDestinationArea = $internationalDestinationArea;
    }

    /**
     * @return NationalDestinationAreaType
     */
    public function getNationalDestinationArea()
    {
      return $this->nationalDestinationArea;
    }

    /**
     * @param NationalDestinationAreaType $nationalDestinationArea
     * @return DestinationAreaType
     */
    public function setNationalDestinationArea($nationalDestinationArea)
    {
      $this->nationalDestinationArea = $nationalDestinationArea;
      return $this;
    }

    /**
     * @return InternationalDestinationAreaType
     */
    public function getInternationalDestinationArea()
    {
      return $this->internationalDestinationArea;
    }

    /**
     * @param InternationalDestinationAreaType $internationalDestinationArea
     * @return DestinationAreaType
     */
    public function setInternationalDestinationArea($internationalDestinationArea)
    {
      $this->internationalDestinationArea = $internationalDestinationArea;
      return $this;
    }

}
