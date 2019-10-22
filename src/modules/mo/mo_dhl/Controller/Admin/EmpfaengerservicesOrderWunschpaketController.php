<?php

namespace Mediaopt\DHL\Controller\Admin;

use Mediaopt\Empfaengerservices\Merchant\Ekp;
use Mediaopt\Empfaengerservices\Shipment\Participation;
use Mediaopt\Empfaengerservices\Shipment\Process;

/**
 * @author derksen mediaopt GmbH
 */
class EmpfaengerservicesOrderWunschpaketController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{
    /**
     * @var \OxidEsales\Eshop\Application\Model\Order|null
     */
    protected $order;

    /**
     * @extend
     * @return string
     */
    public function render()
    {
        parent::render();
        $this->addTplParam('processes', Process::getAvailableProcesses());
        $this->addTplParam('ekp', $this->getEkp());
        $this->addTplParam('participationNumber', $this->getParticipationNumber());
        $this->addTplParam('processIdentifier', $this->getProcessIdentifier());
        return 'MoEmpfaengerservicesOrderWunschpaket.tpl';
    }

    /**
     * @return string
     */
    protected function getEkp()
    {
        return (string) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('ekp') ?: (string) $this->getOrder()->oxorder__mo_empfaengerservices_ekp->rawValue ?: (string) \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_empfaengerservices__merchant_ekp');
    }

    /**
     * @return \OxidEsales\Eshop\Application\Model\Order
     */
    protected function getOrder()
    {
        if ($this->order !== null) {
            return $this->order;
        }

        $this->order = \oxNew(\OxidEsales\Eshop\Application\Model\Order::class);
        $this->order->load($this->getEditObjectId());
        return $this->order;
    }

    /**
     * @return string
     */
    protected function getParticipationNumber()
    {
        return (string) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('participationNumber') ?: (string) $this->getOrder()->oxorder__mo_empfaengerservices_participation->rawValue;
    }

    /**
     * @return string
     */
    protected function getProcessIdentifier()
    {
        return (string) $this->getOrder()->oxorder__mo_empfaengerservices_process->rawValue;
    }

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function save()
    {
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $information = ['MO_EMPFAENGERSERVICES_EKP' => $this->validateEkp(), 'MO_EMPFAENGERSERVICES_PROCESS' => $this->validateProcessIdentifier(), 'MO_EMPFAENGERSERVICES_PARTICIPATION' => $this->validateParticipationNumber()];
        $tuples = [];
        foreach ($information as $column => $value) {
            if (empty($value)) {
                continue;
            }
            $tuples[] = "{$column} = {$db->quote($value)}";
        }
        if ($tuples === []) {
            return;
        }

        $query = ' UPDATE ' . \getViewName('oxorder') . ' SET ' . implode(', ', $tuples) . " WHERE OXID = {$db->quote($this->getEditObjectId())}";
        $db->execute($query);
    }

    /**
     * @return string
     */
    protected function validateEkp()
    {
        try {
            $ekp = \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('ekp');
            Ekp::build($ekp);
            return $ekp;
        } catch (\InvalidArgumentException $exception) {
            /** @noinspection PhpParamsInspection */
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_EMPFAENGERSERVICES__EKP_ERROR');
            return '';
        }
    }

    /**
     * @return string
     */
    protected function validateProcessIdentifier()
    {
        try {
            $processIdentifier = \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('processIdentifier');
            Process::build($processIdentifier);
            return $processIdentifier;
        } catch (\InvalidArgumentException $exception) {
            /** @noinspection PhpParamsInspection */
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_EMPFAENGERSERVICES__PROCESS_IDENTIFIER_ERROR');
            return '';
        }
    }

    /**
     * @return string
     */
    protected function validateParticipationNumber()
    {
        try {
            $participationNumber = \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('participationNumber');
            Participation::build($participationNumber);
            return $participationNumber;
        } catch (\InvalidArgumentException $exception) {
            /** @noinspection PhpParamsInspection */
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_EMPFAENGERSERVICES__PARTICIPATION_NUMBER_ERROR');
            return '';
        }
    }
}