<?php

namespace Mediaopt\DHL\Api\GKV;

class ShipperType extends ShipperTypeType
{

    /**
     * @param NameType          $Name
     * @param NativeAddressType $Address
     */
    public function __construct(NameType $Name, NativeAddressType $Address)
    {
        parent::__construct($Name, $Address);
    }

}
