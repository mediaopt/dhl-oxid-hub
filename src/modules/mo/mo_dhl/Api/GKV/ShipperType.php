<?php

namespace Mediaopt\DHL\Api\GKV;

class ShipperType extends ShipperTypeType
{

    /**
     * @param NameType             $Name
     * @param NativeAddressTypeNew $Address
     */
    public function __construct($Name, $Address)
    {
        parent::__construct($Name, $Address);
    }

}
