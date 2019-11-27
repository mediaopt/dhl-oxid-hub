<?php

namespace Mediaopt\DHL\Application\Controller\Admin;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Shipment\Process;

/** @noinspection LongInheritanceChainInspection */

/**
 * Extends the module configuration to allow the user to download logs.
 *
 * @author Mediaopt GmbH
 */
class ModuleConfiguration extends ModuleConfiguration_parent
{
    /**
     * @extend
     * @return string
     */
    public function render()
    {
        $this->addTplParam('processes', Process::getAvailableProcesses());
        return parent::render();
    }

    /**
     * Streams the chosen log to the user.
     */
    public function moDownload()
    {
        $log = \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('log');
        if (!in_array($log, $this->moGetLogs(), true)) {
            return;
        }

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename=' . $log);
        fpassthru(fopen(\OxidEsales\Eshop\Core\Registry::getConfig()->getLogsDir() . $log, 'rb'));
        exit;
    }

    /**
     * @return array
     */
    public function moGetLogs()
    {
        $logs = array_reverse(glob(\OxidEsales\Eshop\Core\Registry::getConfig()->getLogsDir() . 'mo_dhl_*.log'));
        return array_map('basename', $logs);
    }

    /**
     * @extend
     */
    public function saveConfVars()
    {
        parent::saveConfVars();

        if ($this->getEditObjectId() === 'mo_dhl') {
            $this->moReviewEkp();
            $this->moReviewFilialroutingAlternativeEmail();
        }
    }

    /**
     */
    protected function moReviewFilialroutingAlternativeEmail()
    {
        $mailVariable = 'mo_dhl__filialrouting_alternative_email';
        $email = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam($mailVariable);
        if (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return;
        }
        \OxidEsales\Eshop\Core\Registry::getConfig()->saveShopConfVar('string', $mailVariable, '', '', 'module:mo_dhl');
        \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__FILIALROUTING_EMAIL_ERROR');
    }

    /**
     */
    protected function moReviewEkp()
    {
        $ekpVariable = 'mo_dhl__merchant_ekp';
        $ekp = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam($ekpVariable);
        if (empty($ekp)) {
            return;
        }

        try {
            Ekp::build($ekp);
        } catch (\InvalidArgumentException $exception) {
            \OxidEsales\Eshop\Core\Registry::getConfig()->saveShopConfVar('string', $ekpVariable, '', '', 'module:mo_dhl');
            /** @noinspection PhpParamsInspection */
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__EKP_ERROR');
        }
    }

    /**
     */
    public function moSaveAndCheckLogin()
    {
        $this->save();
        $adapter = new \Mediaopt\DHL\Adapter\DHLAdapter();

        try {
            $days = $adapter->buildWunschpaket()->getPreferredDays('12045');
        } catch (\RuntimeException $e) {
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($e->getMessage());
            return;
        }
        if (empty($days)) {
            \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__INCORRECT_CREDENTIALS');
            return;
        }
        \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__CORRECT_CREDENTIALS');
    }
}
