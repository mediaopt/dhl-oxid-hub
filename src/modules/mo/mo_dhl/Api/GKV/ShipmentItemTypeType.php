<?php

namespace Mediaopt\DHL\Api\GKV;

class ShipmentItemTypeType extends ShipmentItemType
{

    /**
     * @param float $weightInKG
     */
    public function __construct($weightInKG)
    {
        parent::__construct($weightInKG);
    }

}
