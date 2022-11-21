<?php declare(strict_types=1);

namespace MoptWorldline\Service;

use MoptWorldline\Adapter\WorldlineSDKAdapter;
use MoptWorldline\Bootstrap\Form;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\MessageQueue\ScheduledTask\ScheduledTaskHandler;
use Shopware\Core\Kernel;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Contracts\Translation\TranslatorInterface;

class CronTaskHandler extends ScheduledTaskHandler
{
    private EntityRepositoryInterface $salesChannelRepository;
    private SystemConfigService $systemConfigService;
    private Logger $logger;
    private EntityRepositoryInterface $orderTransactionRepository;
    private EntityRepositoryInterface $orderRepository;
    private OrderTransactionStateHandler $transactionStateHandler;
    private TranslatorInterface $translator;

    const CANCELLATION_MODE = 'cancellation';
    const CAPTURE_MODE = 'captrure';

    public function __construct(
        EntityRepositoryInterface    $scheduledTaskRepository,
        EntityRepositoryInterface    $salesChannelRepository,
        SystemConfigService          $systemConfigService,
        Logger                       $logger,
        EntityRepositoryInterface    $orderTransactionRepository,
        EntityRepositoryInterface    $orderRepository,
        OrderTransactionStateHandler $transactionStateHandler,
        TranslatorInterface          $translator
    )
    {
        $this->salesChannelRepository = $salesChannelRepository;
        $this->systemConfigService = $systemConfigService;
        $this->logger = $logger;
        $this->orderTransactionRepository = $orderTransactionRepository;
        $this->orderRepository = $orderRepository;
        $this->transactionStateHandler = $transactionStateHandler;
        $this->translator = $translator;
        parent::__construct($scheduledTaskRepository);
    }

    public static function getHandledMessages(): iterable
    {
        return [CronTask::class];
    }

    public function run(): void
    {
        $salesChannels = $this->salesChannelRepository->search(new Criteria(), Context::createDefaultContext());
        foreach ($salesChannels as $salesChannel) {

            $captureOrdersList = $this->getOrderList($salesChannel->getId(), self::CAPTURE_MODE);
            foreach ($captureOrdersList as $order) {
                $this->processOrder($order, self::CAPTURE_MODE);
            }
            $cancellationOrdersList = $this->getOrderList($salesChannel->getId(), self::CANCELLATION_MODE);
            foreach ($cancellationOrdersList as $order) {
                $this->processOrder($order, self::CANCELLATION_MODE);
            }
        }
    }

    /**
     * @param string $salesChannelId
     * @param string $mode
     * @return array|\mixed[][]|void
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    private function getOrderList(string $salesChannelId, string $mode)
    {
        $adapter = new WorldlineSDKAdapter($this->systemConfigService, $this->logger, $salesChannelId);
        $connection = Kernel::getConnection();

        $qb = $connection->createQueryBuilder();

        $qb->select('ot.custom_fields, ot.updated_at')
            ->from('`order`', 'o')
            ->leftJoin('o', 'order_transaction', 'ot', "ot.order_id = o.id")
            ->where("o.sales_channel_id = UNHEX(:salesChannelId)")
            ->orderBy('ot.updated_at', 'DESC')
            ->setParameter('salesChannelId', $salesChannelId);

        switch ($mode) {
            case self::CAPTURE_MODE:
            {
                $captureConfig = $adapter->getPluginConfig(Form::AUTO_CAPTURE);
                if ($captureConfig === Form::AUTO_PROCESSING_DISABLED) {
                    return [];
                }

                $qb->andWhere(
                    $qb->expr()->or(
                        $qb->expr()->like('ot.custom_fields', "'%payment_transaction_status\": \"5%'"),
                        $qb->expr()->like('ot.custom_fields', "'%payment_transaction_status\": \"56%'")
                    )
                );

                $timeInterval = $this->getTimeInterval($captureConfig) * 60 * 60 * 24;
                break;
            }
            case self::CANCELLATION_MODE:
            {
                $cancellationConfig = $adapter->getPluginConfig(Form::AUTO_CANCEL);
                if ($cancellationConfig === Form::AUTO_PROCESSING_DISABLED) {
                    return [];
                }

                $qb->andWhere(
                    $qb->expr()->or(
                        $qb->expr()->like('ot.custom_fields', "'%payment_transaction_status\": \"0%'"),
                        $qb->expr()->like('ot.custom_fields', "'%payment_transaction_status\": \"46%'")
                    )
                );

                $timeInterval = $this->getTimeInterval($cancellationConfig) * 60 * 60;
                break;
            }
            default:
                return [];
        }

        if ($timeInterval > 0) {
            $qb->andWhere("UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(ot.updated_at) > :timeInterval")
                ->setParameter('timeInterval', $timeInterval);
        }

        return $qb->execute()->fetchAllAssociative() ?: [];
    }

    /**
     * @return int
     */
    private function getTimeInterval($captureConfig)
    {
        return (int)filter_var($captureConfig, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * @param $order
     * @param $mode
     * @return void
     * @throws \Exception
     */
    private function processOrder($order, $mode)
    {
        if (!array_key_exists('custom_fields', $order)) {
            return;
        }
        $customFields = json_decode($order['custom_fields'], true);
        if (!array_key_exists(Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_HOSTED_CHECKOUT_ID, $customFields)) {
            return;
        }
        $hostedCheckoutId = $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_HOSTED_CHECKOUT_ID];

        $orderTransaction = PaymentHandler::getOrderTransaction(
            Context::createDefaultContext(),
            $this->orderTransactionRepository,
            $hostedCheckoutId
        );

        $paymentHandler = new PaymentHandler(
            $this->systemConfigService,
            $this->logger,
            $orderTransaction,
            $this->translator,
            $this->orderRepository,
            $this->orderTransactionRepository,
            Context::createDefaultContext(),
            $this->transactionStateHandler
        );

        switch ($mode) {
            case self::CANCELLATION_MODE:
            {
                debug('try to cancel ' . $hostedCheckoutId);

                $paymentHandler->cancelPayment($hostedCheckoutId);
                break;
            }
            case self::CAPTURE_MODE :
            {
                debug('try to capture ' . $hostedCheckoutId);
                $paymentHandler->capturePayment($hostedCheckoutId);
                break;
            }
            default :
            {
                break;
            }
        }
    }
}
