<?php

namespace Mediaopt\DHL\Application\Model;

/**
 * @author derksen mediaopt GmbH
 */
class DeliverySetList extends DeliverySetList_parent
{
    /**
     * This method is used to avoid the case that a preselected shipping set is unavailable.
     * 
     * This case occurs if the customer has selected a Wunschpaket service such that the delivery must be carried out
     * by DHL. Consequently, some shipping sets are excluded in this cases.
     * 
     * @param string $shippingSetId
     * @param \OxidEsales\Eshop\Application\Model\User|null $user
     * @param \OxidEsales\Eshop\Application\Model\Basket $basket
     * @return array|null
     */
    public function getDeliverySetData($shippingSetId, $user, $basket)
    {
        $data = parent::getDeliverySetData($shippingSetId, $user, $basket);
        if (!is_array($data)) {
            return null;
        }

        list($shippingSets, $shippingSet, ) = $data;
        return $shippingSet === null && $shippingSets !== [] ? parent::getDeliverySetData(null, $user, $basket) : $data;
    }
}
