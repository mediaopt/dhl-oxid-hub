<?php

namespace Mediaopt\DHL\Controller\Admin;

use Mediaopt\DHL\Api\Wunschpaket;
use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Shipment\Participation;
use Mediaopt\DHL\Shipment\Process;

/**
 * @author Mediaopt GmbH
 */
class OrderDHLController extends \OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController
{
    /**
     * @var \OxidEsales\Eshop\Application\Model\Order|null
     */
    protected $order;

    /**
     * @var \Mediaopt\DHL\Wunschpaket
     */
    protected $wunschpaket;

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
        $this->addTplParam('remarks', $this->getRemarks());
        return 'mo_dhl__order_dhl.tpl';
    }

    /**
     * @return string
     */
    protected function getEkp()
    {
        return (string) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('ekp') ?: (string) $this->getOrder()->oxorder__mo_dhl_ekp->rawValue ?: (string) \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('mo_dhl__merchant_ekp');
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
        return (string) \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('participationNumber') ?: (string) $this->getOrder()->oxorder__mo_dhl_participation->rawValue;
    }

    /**
     * @return string
     */
    protected function getProcessIdentifier()
    {
        return (string) $this->getOrder()->oxorder__mo_dhl_process->rawValue;
    }

    /**
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function save()
    {
        $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
        $information = ['MO_DHL_EKP' => $this->validateEkp(), 'MO_DHL_PROCESS' => $this->validateProcessIdentifier(), 'MO_DHL_PARTICIPATION' => $this->validateParticipationNumber()];
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
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__EKP_ERROR');
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
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__PROCESS_IDENTIFIER_ERROR');
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
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__PARTICIPATION_NUMBER_ERROR');
            return '';
        }
    }

    /**
     * @return string[]
     */
    protected function getRemarks()
    {
        $remark = $this->getOrder()->oxorder__oxremark->value;
        return array_merge($this->moDHLGetPreferredDay($remark), $this->moDHLGetPreferredTime($remark), $this->moDHLGetPreferredLocation($remark));
    }

    /**
     * @param string $remark
     * @return string[]
     */
    protected function moDHLGetPreferredDay($remark)
    {
        $preferredDay = $this->getWunschpaket()->extractWunschtag($remark);
        return $preferredDay !== '' ? [$this->translateString('MO_DHL__WUNSCHTAG') => $preferredDay] : [];
    }

    /**
     * @param string $remark
     * @return string[]
     */
    protected function moDHLGetPreferredTime($remark)
    {
        $preferredTime = $this->getWunschpaket()->extractTime($remark);
        return $preferredTime !== '' ? [$this->translateString('MO_DHL__WUNSCHZEIT') => Wunschpaket::formatPreferredTime($preferredTime)] : [];
    }

    /**
     * @param string $remark
     * @return string[]
     */
    protected function moDHLGetPreferredLocation($remark)
    {
        list($type, $locationPart1, $locationPart2) = $this->getWunschpaket()->extractLocation($remark);
        switch ($type) {
            case Wunschpaket::WUNSCHNACHBAR:
                return [$this->translateString('MO_DHL__WUNSCHNACHBAR') => "{$locationPart2}, {$locationPart1}"];
            case Wunschpaket::WUNSCHORT:
                return [$this->translateString('MO_DHL__WUNSCHORT') => $locationPart1];
            default:
                return [];
        }
    }

    /**
     * @return \Mediaopt\DHL\Wunschpaket
     */
    protected function getWunschpaket()
    {
        if (!$this->wunschpaket) {
            $this->wunschpaket = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Wunschpaket::class);
        }
        return $this->wunschpaket;
    }

    /**
     * @param string $text
     * @return string
     */
    protected function translateString(string $text)
    {
        $lang = \OxidEsales\Eshop\Core\Registry::getLang();
        return $lang->translateString($text);
    }

}
