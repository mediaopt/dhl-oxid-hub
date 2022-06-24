<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MoptWordline\Controller\Payment;

use MoptWordline\Adapter\WordlineSDKAdapter;
use MoptWordline\Bootstrap\Form;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionEntity;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Checkout\Payment\Cart\AsyncPaymentTransactionStruct;
use Shopware\Core\Checkout\Payment\Cart\PaymentHandler\AsynchronousPaymentHandlerInterface;
use Shopware\Core\Checkout\Payment\Exception\CustomerCanceledAsyncPaymentException;
use Shopware\Core\Checkout\Payment\Exception\InvalidTransactionException;
use Shopware\Core\Checkout\Payment\Exception\PaymentProcessException;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\NotFilter;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Monolog\Logger;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @RouteScope(scopes={"storefront"})
 */
class PaymentFinalizeController extends AbstractController
{
    private RouterInterface $router;

    private EntityRepositoryInterface $orderRepository;

    private AsynchronousPaymentHandlerInterface $paymentHandler;

    private OrderTransactionStateHandler $transactionStateHandler;

    private SystemConfigService $systemConfigService;

    private Logger $logger;

    private TranslatorInterface $translator;

    public function __construct(
        SystemConfigService $systemConfigService,
        EntityRepositoryInterface $orderRepository,
        AsynchronousPaymentHandlerInterface $paymentHandler,
        OrderTransactionStateHandler $transactionStateHandler,
        RouterInterface $router,
        Logger $logger,
        TranslatorInterface $translator
    ) {
        $this->systemConfigService = $systemConfigService;
        $this->orderRepository = $orderRepository;
        $this->paymentHandler = $paymentHandler;
        $this->transactionStateHandler = $transactionStateHandler;
        $this->router = $router;
        $this->logger = $logger;
        $this->translator = $translator;
    }

    /**
     * @Route(
     *     "/wordline/payment/finalize-transaction",
     *     name="wordline.payment.finalize.transaction",
     *     methods={"GET"}
     * )
     *
     * @throws InvalidTransactionException
     * @throws CustomerCanceledAsyncPaymentException
     */
    public function finalizeTransaction(Request $request, SalesChannelContext $salesChannelContext): RedirectResponse
    {
        $hostedCheckoutId = $request->query->get('hostedCheckoutId');

        $criteria = new Criteria();
        $criteria->addAssociation('order');
        $criteria->addFilter(
            new MultiFilter(
                MultiFilter::CONNECTION_AND,
                [
                    new EqualsFilter(
                        \sprintf('customFields.%s', Form::CUSTOM_FIELD_WORDLINE_PAYMENT_TRANSACTION_ID),
                        $hostedCheckoutId
                    ),
                    new NotFilter(
                        NotFilter::CONNECTION_AND,
                        [
                            new EqualsFilter(
                                \sprintf('customFields.%s', Form::CUSTOM_FIELD_WORDLINE_PAYMENT_TRANSACTION_ID),
                                null
                            ),
                        ]
                    ),
                ]
            )
        );

        $context = $salesChannelContext->getContext();
        /** @var OrderTransactionEntity|null $orderTransaction */
        $orderTransaction = $this->orderRepository->search($criteria, $context)->getEntities()->first();

        if ($orderTransaction === null) {
            throw new InvalidTransactionException('');
        }
        $order = $orderTransaction->getOrder();

        if ($order === null) {
            throw new InvalidTransactionException($orderTransaction->getId());
        }

        $paymentTransactionStruct = new AsyncPaymentTransactionStruct($orderTransaction, $order, '');

        $orderId = $order->getId();
        $changedPayment = $request->query->getBoolean('changedPayment');
        $finishUrl = $this->router->generate('frontend.checkout.finish.page', [
            'orderId' => $orderId,
            'changedPayment' => $changedPayment,
        ]);

        $adapter = new WordlineSDKAdapter($this->systemConfigService, $this->logger);
        try {
            $adapter->log($this->translator->trans('forwardToPaymentHandler'));
            $this->paymentHandler->finalize($paymentTransactionStruct, $request, $salesChannelContext);
        } catch (PaymentProcessException $paymentProcessException) {
            $adapter->log(
                $this->translator->trans('errorWithConfirmRedirrect'),
                Logger::ERROR,
                ['message' => $paymentProcessException->getMessage(), 'error' => $paymentProcessException]
            );
            $finishUrl = $this->redirectToConfirmPageWorkflow(
                $paymentProcessException,
                $context,
                $orderId
            );
        }

        return new RedirectResponse($finishUrl);
    }

    private function redirectToConfirmPageWorkflow(
        PaymentProcessException $paymentProcessException,
        Context $context,
        string $orderId
    ): string {
        $errorUrl = $this->router->generate('frontend.account.edit-order.page', ['orderId' => $orderId]);

        if ($paymentProcessException instanceof CustomerCanceledAsyncPaymentException) {
            $this->transactionStateHandler->cancel(
                $paymentProcessException->getOrderTransactionId(),
                $context
            );
            $urlQuery = \parse_url($errorUrl, \PHP_URL_QUERY) ? '&' : '?';

            return \sprintf('%s%serror-code=%s', $errorUrl, $urlQuery, $paymentProcessException->getErrorCode());
        }

        $transactionId = $paymentProcessException->getOrderTransactionId();

        $adapter = new WordlineSDKAdapter($this->systemConfigService, $this->logger);
        $adapter->log(
            $paymentProcessException->getMessage(),
            Logger::ERROR,
            ['orderTransactionId' => $transactionId, 'error' => $paymentProcessException]
        );
        $this->transactionStateHandler->fail(
            $transactionId,
            $context
        );
        $urlQuery = \parse_url($errorUrl, \PHP_URL_QUERY) ? '&' : '?';

        return \sprintf('%s%serror-code=%s', $errorUrl, $urlQuery, $paymentProcessException->getErrorCode());
    }
}
