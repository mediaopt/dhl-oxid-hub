<?php

namespace Mediaopt\DHL\Application\Model;

/**
 * @author derksen mediaopt GmbH
 */
class Delivery extends Delivery_parent
{
    /**
     * @param \OxidEsales\Eshop\Application\Model\Basket $basket
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function isForBasket($basket)
    {
        /** @var \Mediaopt\DHL\Application\Model\User|bool $user */
        $user = $basket->getUser();
        return (!is_object($user) || !$user->moIsForcedToUseDhlDelivery() || !$this->moIsExcluded()) && parent::isForBasket($basket);
    }

    /**
     * A delivery is excluded every associated delivery set is excluded.
     * 
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function moIsExcluded()
    {
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $query = ' SELECT MIN(oxdelivery.MO_EMPFAENGERSERVICES_EXCLUDED + COALESCE(oxdeliveryset.MO_EMPFAENGERSERVICES_EXCLUDED, 0))' . ' FROM oxdeliveryset' . ' JOIN oxdel2delset on oxdel2delset.OXDELSETID = oxdeliveryset.OXID' . ' JOIN oxdelivery ON oxdelivery.OXID = OXDELID' . " WHERE oxdelivery.OXID = {$db->quote($this->getId())}";
        return (bool) $db->getOne($query);
    }
}
