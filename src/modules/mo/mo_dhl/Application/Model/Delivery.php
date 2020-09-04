<?php

namespace Mediaopt\DHL\Application\Model;

use Mediaopt\DHL\Shipment\Process;
use OxidEsales\Eshop\Core\DatabaseProvider;

/**
 * @author Mediaopt GmbH
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
        return (!is_object($user)
                || !$user->moIsForcedToUseDhlDelivery()
                || !$this->moIsExcluded())
            && $this->moSupportsSelectedWunschpaketServices($user)
            && parent::isForBasket($basket);
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
        $query = ' SELECT MIN(oxdelivery.MO_DHL_EXCLUDED + COALESCE(oxdeliveryset.MO_DHL_EXCLUDED, 0))' . ' FROM oxdeliveryset' . ' JOIN oxdel2delset on oxdel2delset.OXDELSETID = oxdeliveryset.OXID' . ' JOIN oxdelivery ON oxdelivery.OXID = OXDELID' . " WHERE oxdelivery.OXID = {$db->quote($this->getId())}";
        return (bool) $db->getOne($query);
    }

    /**
     * @param \Mediaopt\DHL\Application\Model\User $user
     * @return bool
     */
    public function moSupportsSelectedWunschpaketServices($user)
    {
        if (!$services = $user->moGetSelectedWunschpaketServices()) {
            return true;
        }
        $db = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);
        $query =
            ' SELECT oxdeliveryset.mo_dhl_process' .
            ' FROM oxdeliveryset' .
            ' JOIN oxdel2delset on oxdel2delset.OXDELSETID = oxdeliveryset.OXID' .
            ' JOIN oxdelivery ON oxdelivery.OXID = OXDELID' .
            " WHERE oxdelivery.OXID = {$db->quote($this->getId())}";
        $processes = $db->getCol($query);
        foreach ($services as $service) {
            $processes = array_intersect($processes, Process::getProcessesSupportingService($service));
        }
        return $processes !== [];
    }

    /**
     * @param string $service
     * @return bool
     */
    public function moDHLUsesService(string $service) : bool
    {
        return (bool) $this->getFieldData($service);
    }
}
