<?php declare(strict_types=1);

namespace MoptWorldline\Subscriber;

use Monolog\Logger;
use MoptWorldline\Adapter\WorldlineSDKAdapter;
use MoptWorldline\Bootstrap\Form;
use MoptWorldline\Service\AdminTranslate;
use MoptWorldline\Service\Payment;
use MoptWorldline\Service\PaymentHandler;
use Psr\Log\LogLevel;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionEntity;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Checkout\Order\OrderEvents;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenEvent;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Kernel;
use Shopware\Core\System\StateMachine\Aggregation\StateMachineTransition\StateMachineTransitionActions;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Event\StorefrontRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Shopware\Core\Framework\Context;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

class OrderChangesSubscriber implements EventSubscriberInterface
{
    private SystemConfigService $systemConfigService;
    private EntityRepositoryInterface $orderRepository;
    private EntityRepositoryInterface $orderTransactionRepository;
    private Logger $logger;
    private RequestStack $requestStack;
    private TranslatorInterface $translator;
    private OrderTransactionStateHandler $transactionStateHandler;

    /**
     * @param SystemConfigService $systemConfigService
     * @param Logger $logger
     */
    public function __construct(
        SystemConfigService          $systemConfigService,
        EntityRepositoryInterface    $orderRepository,
        EntityRepositoryInterface    $orderTransactionRepository,
        Logger                       $logger,
        RequestStack                 $requestStack,
        TranslatorInterface          $translator,
        OrderTransactionStateHandler $transactionStateHandler
    )
    {
        $this->systemConfigService = $systemConfigService;
        $this->orderRepository = $orderRepository;
        $this->orderTransactionRepository = $orderTransactionRepository;
        $this->logger = $logger;
        $this->requestStack = $requestStack;
        $this->translator = $translator;
        $this->transactionStateHandler = $transactionStateHandler;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            OrderEvents::ORDER_WRITTEN_EVENT => 'onOrderWritten',
         //   StorefrontRenderEvent::class => 'test'
        ];
    }

    public function test(StorefrontRenderEvent $event)
    {
        $this->run($event->getSalesChannelContext()->getSalesChannelId());
    }


    public function run($salesChannelId): void
    {
        //todo move back
        //todo test with real cancelation
        $salesChannels = [$salesChannelId];//$this->salesChannelRepository->search(new Criteria(), Context::createDefaultContext());
        foreach ($salesChannels as $salesChannel) {
            //$salesChannelId = $salesChannel->getId();
            $captureOrdersList = $this->getOrderList($salesChannelId, 'capture');
            $cancellationOrdersList = $this->getOrderList($salesChannelId, 'cancellation');
            foreach ($captureOrdersList as $order) {
                debug('capture');
                debug($order);   //      $this->processOrder($order);
            }
            foreach ($cancellationOrdersList as $order) {
                debug('cancel');
                debug($order);//  $this->processOrder($order);
             }
        }
    }

    /**
     * @param string $salesChannelId
     * @param string $mode
     * @return array
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
            case "capture":
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
            case "cancellation":
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

        return $qb->execute()->fetchAllAssociative() ? : [];
    }

    /**
     * @return int
     */
    private function getTimeInterval($captureConfig)
    {
        return (int)filter_var($captureConfig, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * @param EntityWrittenEvent $event
     * @return void
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function onOrderWritten(EntityWrittenEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();

        $uri = $request->getUri();

        $uriArr = explode('/', $uri);
        $newState = $uriArr[count($uriArr) - 1];
        if (is_null($newState)
            || !in_array(
                $newState,
                [StateMachineTransitionActions::ACTION_CANCEL, StateMachineTransitionActions::ACTION_REFUND]
            )
        ) {
            return;
        }

        foreach ($event->getWriteResults() as $result) {
            $orderId = $result->getPrimaryKey();
            if (is_null($orderId)) {
                continue;
            }
            if (Payment::isOrderLocked($this->requestStack->getSession(), $orderId)) {
                continue;
            }

            //For order transaction changes payload is empty
            if (empty($result->getPayload())) {
                $this->processOrder($orderId, $newState, $event->getContext());
                //Order cancel should lead to payment transaction refund.
                //For order changes payload is NOT empty.
            } else {
                $this->processOrder($orderId, StateMachineTransitionActions::ACTION_REFUND, $event->getContext());
            }
        }
    }

    /**
     * @param string $orderId
     * @param string $state
     * @param Context $context
     * @return void
     * @throws \Exception
     */
    private function processOrder(string $orderId, string $state, Context $context)
    {
        if (!$order = $this->getOrder($orderId, $context)) {
            return;
        }
        $customFields = $order->getCustomFields();
        if (!is_array($customFields)) {
            return;
        }
        if (!array_key_exists('payment_transaction_id', $customFields)) {
            return;
        }
        $hostedCheckoutId = $customFields['payment_transaction_id'];

        /** @var OrderTransactionEntity|null $orderTransaction */
        $orderTransaction = PaymentHandler::getOrderTransaction($context, $this->orderTransactionRepository, $hostedCheckoutId);

        $paymentHandler = new PaymentHandler(
            $this->systemConfigService,
            $this->logger,
            $orderTransaction,
            $this->translator,
            $this->orderRepository,
            $this->orderTransactionRepository,
            $context,
            $this->transactionStateHandler
        );
        switch ($state) {
            case StateMachineTransitionActions::ACTION_CANCEL:
            {
                Payment::lockOrder($this->requestStack->getSession(), $orderId);
                $paymentHandler->cancelPayment($hostedCheckoutId);
                break;
            }
            case StateMachineTransitionActions::ACTION_REFUND:
            {
                Payment::lockOrder($this->requestStack->getSession(), $orderId);
                $paymentHandler->refundPayment($hostedCheckoutId);
                break;
            }
            default :
            {
                break;
            }
        }
        Payment::unlockOrder($this->requestStack->getSession(), $orderId);
    }

    /**
     * @param string $orderId
     * @param Context $context
     * @return OrderEntity|mixed
     */
    private function getOrder(string $orderId, Context $context)
    {
        $orders = $this->orderRepository->search(new Criteria([$orderId]), $context);
        /* @var $order OrderEntity */
        foreach ($orders->getElements() as $order) {
            return $order;
        }
        $this->logger->log(LogLevel::ERROR, "There is no order with id = $orderId");
        return false;
    }
}
