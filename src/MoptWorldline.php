<?php
declare(strict_types=1);

/**
 * @author Mediaopt GmbH
 * @package MoptWorldline
 */

namespace MoptWorldline;

use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Shopware\Core\Framework\Plugin\Context\DeactivateContext;
use MoptWorldline\Service\CustomField;
use MoptWorldline\Service\PaymentMethod;
use Shopware\Core\Framework\Context;

class MoptWorldline extends Plugin
{
    const PLUGIN_NAME = 'MoptWorldline';

    const PLUGIN_VERSION = '1.0.1';
    const FULL_REDIRECT_PAYMENT_METHOD_NAME = "Worldline";
    const IFRAME_PAYMENT_METHOD_NAME = "Worldline Iframe";
    const SAVED_CARD_PAYMENT_METHOD_NAME = "Worldline saved card";
    const METHODS_LIST = [
        [
            'name' => self::FULL_REDIRECT_PAYMENT_METHOD_NAME,
            'description' => 'Worldline full redirect payment method',
            'activeOnInstall' => true
        ],
        [
            'name' => self::IFRAME_PAYMENT_METHOD_NAME,
            'description' => 'Worldline Iframe payment method',
            'activeOnInstall' => false
        ],
        [
            'name' => self::SAVED_CARD_PAYMENT_METHOD_NAME,
            'description' => 'Worldline saved card payment method',
            'activeOnInstall' => false
        ]
    ];

    /**
     * @param InstallContext $installContext
     */
    public function install(InstallContext $installContext): void
    {
        parent::install($installContext);

        $customField = new CustomField($this->container);
        $customField->addCustomFields($installContext);

        $paymentMethod = new PaymentMethod($this->container);
        foreach (self::METHODS_LIST as $method) {
            $paymentMethod->addPaymentMethod(
                $installContext->getContext(),
                $method['name'],
                $method['description'],
                $method['activeOnInstall']
            );
        }
    }

    /**
     * @param UninstallContext $uninstallContext
     */
    public function uninstall(UninstallContext $uninstallContext): void
    {
        parent::uninstall($uninstallContext);
        $this->setPaymentMethodsStatus(false, $uninstallContext->getContext());
    }

    /**
     * @param ActivateContext $activateContext
     */
    public function activate(ActivateContext $activateContext): void
    {
        parent::activate($activateContext);
        $this->setPaymentMethodsStatus(true, $activateContext->getContext());
    }

    /**
     * @param DeactivateContext $deactivateContext
     */
    public function deactivate(DeactivateContext $deactivateContext): void
    {
        parent::deactivate($deactivateContext);
        $this->setPaymentMethodsStatus(false, $deactivateContext->getContext());
    }

    private function setPaymentMethodsStatus(bool $status, Context $context)
    {
        $paymentMethod = new PaymentMethod($this->container);
        foreach (self::METHODS_LIST as $method) {
            $paymentMethod->setPaymentMethodStatus($status, $context, $method['name']);
        }
    }
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}
