<?php

namespace Mediaopt\DHL\Api\GKV;

class ShipmentItemType
{

    /**
     * @var float $weightInKG
     */
    protected $weightInKG = null;

    /**
     * @var int $lengthInCM
     */
    protected $lengthInCM = null;

    /**
     * @var int $widthInCM
     */
    protected $widthInCM = null;

    /**
     * @var int $heightInCM
     */
    protected $heightInCM = null;

    /**
     * @param float $weightInKG
     */
    public function __construct($weightInKG)
    {
        $this->weightInKG = $weightInKG;
    }

    /**
     * @return float
     */
    public function getWeightInKG()
    {
        return $this->weightInKG;
    }

    /**
     * @param float $weightInKG
     * @return ShipmentItemType
     */
    public function setWeightInKG($weightInKG)
    {
        $this->weightInKG = $weightInKG;
        return $this;
    }

    /**
     * @return int
     */
    public function getLengthInCM()
    {
        return $this->lengthInCM;
    }

    /**
     * @param int $lengthInCM
     * @return ShipmentItemType
     */
    public function setLengthInCM($lengthInCM)
    {
        $this->lengthInCM = $lengthInCM;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidthInCM()
    {
        return $this->widthInCM;
    }

    /**
     * @param int $widthInCM
     * @return ShipmentItemType
     */
    public function setWidthInCM($widthInCM)
    {
        $this->widthInCM = $widthInCM;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeightInCM()
    {
        return $this->heightInCM;
    }

    /**
     * @param int $heightInCM
     * @return ShipmentItemType
     */
    public function setHeightInCM($heightInCM)
    {
        $this->heightInCM = $heightInCM;
        return $this;
    }

}
