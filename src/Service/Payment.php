<?php declare(strict_types=1);

/**
 * @author Mediaopt GmbH
 * @package MoptWordline\Service
 */

namespace MoptWordline\Service;

use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Checkout\Payment\Cart\AsyncPaymentTransactionStruct;
use Shopware\Core\Checkout\Payment\Cart\PaymentHandler\AsynchronousPaymentHandlerInterface;
use Shopware\Core\Checkout\Payment\Exception\AsyncPaymentProcessException;
use Shopware\Core\Checkout\Payment\Exception\CustomerCanceledAsyncPaymentException;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Monolog\Logger;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use MoptWordline\Bootstrap\Form;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class Payment implements AsynchronousPaymentHandlerInterface
{
    private SystemConfigService $systemConfigService;
    private EntityRepositoryInterface $orderTransactionRepository;
    private EntityRepositoryInterface $orderRepository;
    private TranslatorInterface $translator;
    private Logger $logger;
    private OrderTransactionStateHandler $transactionStateHandler;

    public const STATUS_PAYMENT_CREATED = [0];                  //open
    public const STATUS_PAYMENT_CANCELLED = [1, 6, 61, 62, 64, 75]; //cancelled
    public const STATUS_PAYMENT_REJECTED = [2, 57, 59, 73, 83]; //failed
    public const STATUS_REJECTED_CAPTURE = [93];                //fail
    public const STATUS_REDIRECTED = [46];                      //
    public const STATUS_PENDING_CAPTURE = [5, 56];              //open
    public const STATUS_AUTHORIZATION_REQUESTED = [50, 51, 55]; //
    public const STATUS_CAPTURE_REQUESTED = [4, 91, 92, 99];    //in progress
    public const STATUS_CAPTURED = [9];                         //payed
    public const STATUS_REFUND_REQUESTED = [81, 82];            //in progress
    public const STATUS_REFUNDED = [7, 8, 85];                  //refunded

    public const STATUS_LABELS = [
        0 => 'created',

        1  => 'cancelled',
        6  => 'cancelled',
        61 => 'cancelled',
        62 => 'cancelled',
        64 => 'cancelled',
        75 => 'cancelled',

        2  => 'rejected',
        57 => 'rejected',
        59 => 'rejected',
        73 => 'rejected',
        83 => 'rejected',

        93 => 'rejectedCapture',

        46 => 'redirected',

        5  => 'pendingCapture',
        56 => 'pendingCapture',

        50 => 'authorizationRequested',
        51 => 'authorizationRequested',
        55 => 'authorizationRequested',

        4  => 'captureRequested',
        91 => 'captureRequested',
        92 => 'captureRequested',
        99 => 'captureRequested',

        9 => 'captured',

        81 => 'refundRequested',
        82 => 'refundRequested',

        7  => 'refunded',
        8  => 'refunded',
        85 => 'refunded',
    ];

    /**
     * @param SystemConfigService $systemConfigService
     * @param EntityRepositoryInterface $orderTransactionRepository
     * @param EntityRepositoryInterface $orderRepository
     * @param TranslatorInterface $translator
     * @param Logger $logger
     * @param OrderTransactionStateHandler $transactionStateHandler
     */
    public function __construct(
        SystemConfigService          $systemConfigService,
        EntityRepositoryInterface    $orderTransactionRepository,
        EntityRepositoryInterface    $orderRepository,
        TranslatorInterface          $translator,
        Logger                       $logger,
        OrderTransactionStateHandler $transactionStateHandler
    )
    {
        $this->systemConfigService = $systemConfigService;
        $this->orderTransactionRepository = $orderTransactionRepository;
        $this->orderRepository = $orderRepository;
        $this->translator = $translator;
        $this->logger = $logger;
        $this->transactionStateHandler = $transactionStateHandler;
    }

    /**
     * @param AsyncPaymentTransactionStruct $transaction
     * @param RequestDataBag $dataBag
     * @param SalesChannelContext $salesChannelContext
     * @return RedirectResponse
     */
    public function pay(AsyncPaymentTransactionStruct $transaction, RequestDataBag $dataBag, SalesChannelContext $salesChannelContext): RedirectResponse
    {
        // Method that sends the return URL to the external gateway and gets a redirect URL back
        try {
            $redirectUrl = $this->sendReturnUrlToExternalGateway($transaction, $salesChannelContext->getContext());
        } catch (\Exception $e) {
            throw new AsyncPaymentProcessException(
                $transaction->getOrderTransaction()->getId(),
                'An error occurred during the communication with external payment gateway' . PHP_EOL . $e->getMessage()
            );
        }
        return new RedirectResponse($redirectUrl);
    }

    /**
     * @param AsyncPaymentTransactionStruct $transaction
     * @param Request $request
     * @param SalesChannelContext $salesChannelContext
     * @return void
     */
    public function finalize(
        AsyncPaymentTransactionStruct $transaction,
        Request                       $request,
        SalesChannelContext           $salesChannelContext
    ): void
    {
        $transactionId = $transaction->getOrderTransaction()->getId();

        //todo realise is it a Cancelled payment?
        if ($request->query->getBoolean('cancel')) {
            throw new CustomerCanceledAsyncPaymentException(
                $transactionId,
                'Customer canceled the payment on the PayPal page'
            );
        }
    }

    /**
     * @param AsyncPaymentTransactionStruct $transaction
     * @param Context $context
     * @return string
     * @throws \Exception
     */
    private function sendReturnUrlToExternalGateway(AsyncPaymentTransactionStruct $transaction, Context $context)
    {
        $transactionId = $transaction->getOrderTransaction()->getId();

        $criteria = new Criteria([$transactionId]);
        $criteria->addAssociation('order');
        $orderTransaction = $this->orderTransactionRepository->search($criteria, $context)->first();

        $handler = new PaymentHandler(
            $this->systemConfigService,
            $this->logger,
            $orderTransaction,
            $this->translator,
            $this->orderRepository,
            $this->orderTransactionRepository,
            $context,
            $this->transactionStateHandler
        );

        try {
            $hostedCheckoutResponse = $handler->createPayment();
        } catch (\Exception $e) {
            throw new AsyncPaymentProcessException(
                $transactionId,
                \sprintf('An error occurred during the communication with Wordline%s%s', \PHP_EOL, $e->getMessage())
            );
        }

        $link = $hostedCheckoutResponse->getRedirectUrl();
        if ($link === null) {
            throw new AsyncPaymentProcessException($transactionId, 'No redirect link provided by Wordline');
        }

        return $link;
    }

    /**
     * @param string $orderId
     * @param SessionInterface $session
     * @return void
     */
    public static function lockOrder(SessionInterface $session, string $orderId)
    {
        $session->set(Form::SESSION_OPERATIONS_LOCK . $orderId, true);
    }

    /**
     * @param string $orderId
     * @param SessionInterface $session
     * @return void
     */
    public static function unlockOrder(SessionInterface $session, string $orderId)
    {
        $session->set(Form::SESSION_OPERATIONS_LOCK . $orderId, false);
    }

    /**
     * @param string $orderId
     * @param SessionInterface $session
     * @return bool
     */
    public static function isOrderLocked(SessionInterface $session, string $orderId): bool
    {
        return $session->get(Form::SESSION_OPERATIONS_LOCK . $orderId, false);
    }

}
