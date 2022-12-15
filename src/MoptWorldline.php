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

class MoptWorldline extends Plugin
{
    const PLUGIN_NAME = 'MoptWorldline';

    const PLUGIN_VERSION = '1.0.1';
    const FULL_REDIRECT_PAYMENT_METHOD_NAME = "Worldline";
    const IFRAME_PAYMENT_METHOD_NAME = "Worldline Iframe";

    /**
     * @param InstallContext $installContext
     */
    public function install(InstallContext $context): void
    {
        parent::install($context);

        $customField = new CustomField($this->container);
        $customField->addCustomFields($context);

        $paymentMethod = new PaymentMethod($this->container);
        $paymentMethod->addPaymentMethod(
            $context->getContext(),
            self::FULL_REDIRECT_PAYMENT_METHOD_NAME,
            'Worldline full redirect payment method',
            true
        );
        $paymentMethod->addPaymentMethod(
            $context->getContext(),
            self::IFRAME_PAYMENT_METHOD_NAME,
            'Worldline Iframe payment method',
            false
        );
    }

    /**
     * @param UninstallContext $context
     */
    public function uninstall(UninstallContext $context): void
    {
        parent::uninstall($context);

        $paymentMethod = new PaymentMethod($this->container);
        $paymentMethod->setPaymentMethodStatus(
            false,
            $context->getContext(),
            self::FULL_REDIRECT_PAYMENT_METHOD_NAME
        );
        $paymentMethod->setPaymentMethodStatus(
            false,
            $context->getContext(),
            self::IFRAME_PAYMENT_METHOD_NAME
        );
    }

    /**
     * @param ActivateContext $context
     */
    public function activate(ActivateContext $context): void
    {
        parent::activate($context);

        $paymentMethod = new PaymentMethod($this->container);
        $paymentMethod->setPaymentMethodStatus(
            true,
            $context->getContext(),
            self::FULL_REDIRECT_PAYMENT_METHOD_NAME
        );
        $paymentMethod->setPaymentMethodStatus(
            true,
            $context->getContext(),
            self::IFRAME_PAYMENT_METHOD_NAME
        );
    }

    /**
     * @param DeactivateContext $context
     */
    public function deactivate(DeactivateContext $context): void
    {
        parent::deactivate($context);

        $paymentMethod = new PaymentMethod($this->container);
        $paymentMethod->setPaymentMethodStatus(
            false,
            $context->getContext(),
            self::FULL_REDIRECT_PAYMENT_METHOD_NAME
        );
        $paymentMethod->setPaymentMethodStatus(
            false,
            $context->getContext(),
            self::IFRAME_PAYMENT_METHOD_NAME
        );
    }
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}
