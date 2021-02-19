<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class Position
{

    /**
     * @var labelX $labelX
     */
    protected $labelX = null;

    /**
     * @var labelY $labelY
     */
    protected $labelY = null;

    /**
     * @param labelX $labelX
     * @param labelY $labelY
     */
    public function __construct($labelX, $labelY)
    {
      $this->labelX = $labelX;
      $this->labelY = $labelY;
    }

    /**
     * @return labelX
     */
    public function getLabelX()
    {
      return $this->labelX;
    }

    /**
     * @param labelX $labelX
     * @return Position
     */
    public function setLabelX($labelX)
    {
      $this->labelX = $labelX;
      return $this;
    }

    /**
     * @return labelY
     */
    public function getLabelY()
    {
      return $this->labelY;
    }

    /**
     * @param labelY $labelY
     * @return Position
     */
    public function setLabelY($labelY)
    {
      $this->labelY = $labelY;
      return $this;
    }

}
