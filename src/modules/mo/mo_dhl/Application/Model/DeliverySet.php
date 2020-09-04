<?php

namespace Mediaopt\DHL\Application\Model;

use Mediaopt\DHL\Shipment\Process;
use OxidEsales\Eshop\Core\DatabaseProvider;

/**
 * @author Mediaopt GmbH
 */
class DeliverySet extends DeliverySet_parent
{

    /**
     * @param string $service
     * @return bool
     */
    public function moDHLUsesService(string $service) : bool
    {
        return (bool) $this->getFieldData($service);
    }
}
