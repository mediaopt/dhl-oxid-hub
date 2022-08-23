<?php declare(strict_types=1);

/**
 * @author Mediaopt GmbH
 * @package MoptWorldline\Service
 */

namespace MoptWorldline\Service;

use MoptWorldline\MoptWorldline;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Plugin\Util\PluginIdProvider;
use Symfony\Component\DependencyInjection\ContainerInterface;


class PaymentMethod
{
    private ContainerInterface $container;

    /**
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @param Context $context
     */
    public function addPaymentMethod(Context $context)
    {
        $paymentMethiodsExists = $this->getPaymentMethodId();
        if ($paymentMethiodsExists) {
            return;
        }

        /** @var PluginIdProvider $pluginIdProvider */
        $pluginIdProvider = $this->container->get(PluginIdProvider::class);
        $pluginId = $pluginIdProvider->getPluginIdByBaseClass(MoptWorldline::class, $context);

        $paymentData = [
            'handlerIdentifier' => Payment::class,
            'name' => 'Worldline',
            'description' => 'Worldline full redirect payment method',
            'pluginId' => $pluginId,
            'afterOrderEnabled' => false
        ];

        /** @var EntityRepositoryInterface $paymentRepository */
        $paymentRepository = $this->container->get('payment_method.repository');
        $paymentRepository->create([$paymentData], $context);
    }

    /**
     * @param bool $active
     * @param Context $context
     */
    public function setPaymentMethodStatus(bool $active, Context $context)
    {
        /** @var EntityRepositoryInterface $paymentRepository */
        $paymentRepository = $this->container->get('payment_method.repository');

        $paymentMethodId = $this->getPaymentMethodId();
        if (!$paymentMethodId) {
            return;
        }

        $paymentMethod = [
            'id' => $paymentMethodId,
            'active' => $active
        ];

        $paymentRepository->update([$paymentMethod], $context);
    }

    /**
     * @return string|null
     */
    private function getPaymentMethodId(): ?string
    {
        /** @var EntityRepositoryInterface $paymentRepository */
        $paymentRepository = $this->container->get('payment_method.repository');

        $paymentCriteria = (new Criteria())->addFilter(new EqualsFilter('handlerIdentifier', Payment::class));
        $paymentIds = $paymentRepository->searchIds($paymentCriteria, Context::createDefaultContext());

        if ($paymentIds->getTotal() === 0) {
            return null;
        }

        return $paymentIds->getIds()[0];
    }
}
