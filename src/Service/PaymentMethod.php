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
use Shopware\Core\Framework\Uuid\Uuid;
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
     * @param string $methodName
     * @param string $description
     */
    public function addPaymentMethod(Context $context, string $methodName, string $description)
    {
        $paymentMethodExists = $this->getPaymentMethodId($methodName);
        if ($paymentMethodExists) {
            return;
        }

        /** @var PluginIdProvider $pluginIdProvider */
        $pluginIdProvider = $this->container->get(PluginIdProvider::class);
        $pluginId = $pluginIdProvider->getPluginIdByBaseClass(MoptWorldline::class, $context);

        $methodId = Uuid::randomHex();
        $paymentData = [
            'id' => $methodId,
            'handlerIdentifier' => Payment::class,
            'name' => $methodName,
            'description' => $description,
            'pluginId' => $pluginId,
            'afterOrderEnabled' => true,
            'active' => true
        ];

        /** @var EntityRepositoryInterface $paymentRepository */
        $paymentRepository = $this->container->get('payment_method.repository');
        $paymentRepository->create([$paymentData], $context);

        /** @var EntityRepositoryInterface $salesChannelRepository */
        $salesChannelRepository = $this->container->get('sales_channel.repository');
        $salesChannels = $salesChannelRepository->search(new Criteria(), $context);
        $toSave = [];
        foreach ($salesChannels as $salesChannel) {
            $toSave[] = [
                'salesChannelId' => $salesChannel->getId(),
                'paymentMethodId' => $methodId
            ];
        }

        /** @var EntityRepositoryInterface $salesChannelRepository */
        $salesChannelPaymentRepository = $this->container->get('sales_channel_payment_method.repository');
        $salesChannelPaymentRepository->create($toSave, $context);
    }

    /**
     * @param bool $active
     * @param Context $context
     * @param string $methodName
     */
    public function setPaymentMethodStatus(bool $active, Context $context, string $methodName)
    {
        /** @var EntityRepositoryInterface $paymentRepository */
        $paymentRepository = $this->container->get('payment_method.repository');

        $paymentMethodId = $this->getPaymentMethodId($methodName);
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
     * @param string $methodName
     * @return string|null
     */
    private function getPaymentMethodId(string $methodName): ?string
    {
        /** @var EntityRepositoryInterface $paymentRepository */
        $paymentRepository = $this->container->get('payment_method.repository');

        $paymentCriteria = (
        new Criteria())
            ->addFilter(new EqualsFilter('handlerIdentifier', Payment::class))
            ->addFilter(new EqualsFilter('name', $methodName));
        $paymentIds = $paymentRepository->searchIds($paymentCriteria, Context::createDefaultContext());

        if ($paymentIds->getTotal() === 0) {
            return null;
        }

        return $paymentIds->getIds()[0];
    }
}
