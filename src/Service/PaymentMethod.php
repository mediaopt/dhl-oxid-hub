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
    const PAYMENT_METHOD_INTERSOLVE = 5700;
    const PAYMENT_METHOD_ONEY_3X_4X = 5110;
    const PAYMENT_METHOD_ONEY_FINANCEMENT_LONG = 5125;
    const PAYMENT_METHOD_ONEY_BRANDED_GIFT_CARD = 5600;
    const PAYMENT_METHOD_KLARNA_PAY_NOW = 3301;
    const PAYMENT_METHOD_KLARNA_PAY_LATER = 3302;
    const PAYMENT_METHOD_NEED_DETAILS = [
          self::PAYMENT_METHOD_ONEY_3X_4X,
          self::PAYMENT_METHOD_ONEY_FINANCEMENT_LONG,
          self::PAYMENT_METHOD_ONEY_BRANDED_GIFT_CARD,
          self::PAYMENT_METHOD_KLARNA_PAY_NOW,
          self::PAYMENT_METHOD_KLARNA_PAY_LATER,
    ];
    private const PAYMENT_METHOD_MEDIA_DIR = 'bundles/moptworldline/static/img';
    private const PAYMENT_METHOD_MEDIA_PREFIX = 'pp_logo_';
    private const PAYMENT_METHOD_MEDIA_DEFAULT = 'base';
    private const PAYMENT_METHOD_NAMES = [
        self::PAYMENT_METHOD_INTERSOLVE => 'Intersolve',
        self::PAYMENT_METHOD_KLARNA_PAY_NOW => 'Klarna',
        self::PAYMENT_METHOD_KLARNA_PAY_LATER => 'Klarna',
        self::PAYMENT_METHOD_ONEY_3X_4X => 'Oney 3x-4x',
        self::PAYMENT_METHOD_ONEY_FINANCEMENT_LONG => 'Oney Financement Long',
        self::PAYMENT_METHOD_ONEY_BRANDED_GIFT_CARD => 'OneyBrandedGiftCard',
        861 => 'Alipay',
        2 => 'American Express',
        302 => 'Apple Pay',
        3012 => 'Bancontact',
        5001 => 'Bizum',
        130 => 'Carte Bancaire',
        5100 => 'Cpay',
        132 => 'Diners Club',
        320 => 'Google Pay',
        809 => 'iDEAL',
        3112 => 'Illicado',
        125 => 'JCB',
        117 => 'Maestro',
        3 => 'Mastercard',
        5402 => 'Mealvouchers',
        5500 => 'Multibanco',
        840 => 'Paypal',
        771 => 'SEPA Direct Debit',
        56 => 'UPI - UnionPay International', //no logo!
        1 => 'Visa',
        863 => 'WeChat Pay',
    ];

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
     * @param bool $active
     * @return void
     */
    public function addPaymentMethod(Context $context, string $methodName, string $description, bool $active)
    {
        $paymentMethodExists = $this->getPaymentMethodId($methodName);
        if ($paymentMethodExists) {
            return;
        }

        /** @var PluginIdProvider $pluginIdProvider */
        $pluginIdProvider = $this->container->get(PluginIdProvider::class);
        $pluginId = $pluginIdProvider->getPluginIdByBaseClass(Payment::class, $context);

        $methodId = Uuid::randomHex();
        $paymentData = [
            'id' => $methodId,
            'handlerIdentifier' => Payment::class,
            'name' => $methodName,
            'description' => $description,
            'pluginId' => $pluginId,
            'afterOrderEnabled' => true,
            'active' => $active
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

    /**
     * @param string $paymentProductId
     * @return array
     */
    public static function getPaymentProductDetails(string $paymentProductId): array
    {
        $title = 'Unknown';
        $logoName = self::PAYMENT_METHOD_MEDIA_DEFAULT;
        if (array_key_exists($paymentProductId, self::PAYMENT_METHOD_NAMES)) {
            $title = self::PAYMENT_METHOD_NAMES[$paymentProductId];
            $logoName = self::PAYMENT_METHOD_MEDIA_PREFIX . $paymentProductId;
        }

        return [
            'title' => $title,
            'logo' => \sprintf('%s/%s.svg', self::PAYMENT_METHOD_MEDIA_DIR, $logoName),
        ];
    }
}
