<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2019 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Adapter;

/**
 * This class transforms an \oxOrder object into a Shipment object.
 *
 * @author Mediaopt GmbH
 */
class DHLBaseShipmentBuilder
{
    /**
     * @var string
     */
    protected $ekp;

    /**
     * @var string[]
     */
    protected $deliverySetToProcessIdentifier = [];

    /**
     * @var string[]
     */
    protected $deliverySetToParticipationNumber = [];

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    public function __construct()
    {
        $this->ekp = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__merchant_ekp');
        $this->loadProcessAndParticipationForDeliverySets();
    }

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    protected function loadProcessAndParticipationForDeliverySets()
    {
        $query = ' SELECT OXID, MO_DHL_PROCESS, MO_DHL_PARTICIPATION' . ' FROM ' . getViewName('oxdeliveryset');
        foreach ((array)\OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC)->getAll($query) as $row) {
            $this->deliverySetToProcessIdentifier[$row['OXID']] = $row['MO_DHL_PROCESS'];
            $this->deliverySetToParticipationNumber[$row['OXID']] = $row['MO_DHL_PARTICIPATION'];
        }
    }
}
