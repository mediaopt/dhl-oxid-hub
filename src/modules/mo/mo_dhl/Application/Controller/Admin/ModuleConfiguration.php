<?php

namespace Mediaopt\DHL\Application\Controller\Admin;

/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

use Mediaopt\DHL\Merchant\Ekp;
use Mediaopt\DHL\Shipment\Process;
use OxidEsales\Eshop\Core\Registry;

/** @noinspection LongInheritanceChainInspection */

/**
 * Extends the module configuration to allow the user to download logs.
 *
 * @author Mediaopt GmbH
 */
class ModuleConfiguration extends ModuleConfiguration_parent
{

    const SURCHARGE_SNIPPETS = [
        'mo_dhl__wunschtag_surcharge_text'            => 'MO_DHL__WUNSCHTAG_COSTS',
        'mo_dhl__wunschzeit_surcharge_text'           => 'MO_DHL__WUNSCHZEIT_COSTS',
        'mo_dhl__wunschtag_wunschzeit_surcharge_text' => 'MO_DHL__COMBINATION_SURCHARGE',
    ];

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
        $log = Registry::get(\OxidEsales\Eshop\Core\Request::class)->getRequestParameter('log');
        if (!in_array($log, $this->moGetLogs(), true)) {
            return;
        }

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename=' . $log);
        fpassthru(fopen(Registry::getConfig()->getLogsDir() . $log, 'rb'));
        exit;
    }

    /**
     * @return array
     */
    public function moGetLogs()
    {
        $logs = array_reverse(glob(Registry::getConfig()->getLogsDir() . 'mo_dhl_*.log'));
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
        $email = Registry::getConfig()->getConfigParam($mailVariable);
        if (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return;
        }
        Registry::getConfig()->saveShopConfVar('str', $mailVariable, '', '', 'module:mo_dhl');
        Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__FILIALROUTING_EMAIL_ERROR');
    }

    /**
     */
    protected function moReviewEkp()
    {
        $ekpVariable = 'mo_dhl__merchant_ekp';
        $ekp = Registry::getConfig()->getConfigParam($ekpVariable);
        if (empty($ekp)) {
            return;
        }

        try {
            Ekp::build($ekp);
        } catch (\InvalidArgumentException $exception) {
            Registry::getConfig()->saveShopConfVar('str', $ekpVariable, '', '', 'module:mo_dhl');
            /** @noinspection PhpParamsInspection */
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__EKP_ERROR');
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
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay($e->getMessage());
            return;
        }
        if (empty($days)) {
            Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__INCORRECT_CREDENTIALS');
            return;
        }
        Registry::get(\OxidEsales\Eshop\Core\UtilsView::class)->addErrorToDisplay('MO_DHL__CORRECT_CREDENTIALS');
    }

    /**
     * @param string $textVarName
     * @return string[]
     */
    public function moDHLGetSurchargeTexts($textVarName)
    {
        $texts = Registry::getConfig()->getShopConfVar($textVarName) ?: [];
        foreach (array_keys($this->moDHLGetLanguages()) as $lang) {
            if (!isset($texts[$lang])) {
                $texts[$lang] = '';
            }
        }
        return $texts;
    }

    /**
     * @param int $langId
     * @return string
     */
    public function moDHLGetLanguageName(int $langId): string
    {
        return $this->moDHLGetLanguages()[$langId]->name;
    }

    /**
     * @return \stdClass[]
     */
    public function moDHLGetLanguages(): array
    {
        return Registry::getLang()->getLanguageArray();
    }

    /**
     * @param string $textVarName
     * @param int    $langId
     * @return string
     */
    public function moDHLGetPlaceholder(string $textVarName, int $langId): string
    {
        $snippet = self::SURCHARGE_SNIPPETS[$textVarName];
        $snippet .= Registry::getConfig()->getConfigParam('blShowVATForDelivery') ? '_NET' : '_GROSS';
        $translation = Registry::getLang()->translateString($snippet, $langId, false);
        return $translation !== $snippet ? $translation : '';
    }
}
