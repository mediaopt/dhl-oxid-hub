<?php

namespace Mediaopt\DHL\Api\GKV;

class ReceiverType extends ReceiverTypeType
{

    /**
     * @param string                    $name1
     * @param ReceiverNativeAddressType $Address
     * @param PackStationType           $Packstation
     * @param PostfilialeTypeNoCountry  $Postfiliale
     */
    public function __construct($name1, $Address = null, $Packstation = null, $Postfiliale = null)
    {
        parent::__construct($name1, $Address, $Packstation, $Postfiliale);
    }

}
