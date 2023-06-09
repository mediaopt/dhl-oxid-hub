<?php

namespace Mediaopt\DHL\Application\Model;

use Mediaopt\DHL\Shipment\Process;

/**
 * @author Mediaopt GmbH
 */
class DeliveryList extends DeliveryList_parent
{

    /**
     * Checks if deliveries in list fits for current basket and delivery set
     *
     * @param \OxidEsales\Eshop\Application\Model\Basket $basket shop basket
     * @param \OxidEsales\Eshop\Application\Model\User $user session user
     * @param string $sDelCountry delivery country
     * @param string $sDeliverySetId delivery set id to check its relation to delivery list
     *
     * @return bool
     */
    public function hasDeliveries($basket, $user, $sDelCountry, $sDeliverySetId)
    {
        return (!is_object($user)
                || !$user->moIsForcedToUseDhlDelivery()
                || !$this->moIsExcluded($sDeliverySetId))
            && $this->moSupportsSelectedWunschpaketServices($user, $sDeliverySetId)
            && parent::hasDeliveries($basket, $user, $sDelCountry, $sDeliverySetId);
    }

    /**
     * @param string $deliverySetId
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function moIsExcluded($deliverySetId)
    {
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $query = ' SELECT MO_DHL_EXCLUDED' . ' FROM oxdeliveryset' . " WHERE OXID = {$db->quote($deliverySetId)}";
        return (bool) $db->getOne($query);
    }

    /**
     * @param \Mediaopt\DHL\Application\Model\User $user
     * @param string                               $deliverySetId
     * @return bool
     */
    public function moSupportsSelectedWunschpaketServices($user, $deliverySetId)
    {
        if (!$services = $user->moGetSelectedWunschpaketServices()) {
            return true;
        }
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $query = " SELECT MO_DHL_PROCESS FROM oxdeliveryset WHERE OXID = {$db->quote($deliverySetId)}";
        $process = $db->getOne($query);
        foreach ($services as $service) {
            if (!in_array($process, Process::getProcessesSupportingService($service))) {
                return false;
            }
        }
        return true;
    }
}
