<?php declare(strict_types=1);

namespace MoptWordline\Service;

use MoptWordline\Adapter\WordlineSDKAdapter;
use OnlinePayments\Sdk\Domain\HostedCheckoutSpecificInput;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Checkout\Payment\Cart\AsyncPaymentTransactionStruct;
use Shopware\Core\Checkout\Payment\Cart\PaymentHandler\AsynchronousPaymentHandlerInterface;
use Shopware\Core\Checkout\Payment\Cart\PaymentHandler\RefundPaymentHandlerInterface;
use Shopware\Core\Checkout\Payment\Exception\AsyncPaymentProcessException;
use Shopware\Core\Checkout\Payment\Exception\CustomerCanceledAsyncPaymentException;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Event\StorefrontRenderEvent;
use Shopware\Storefront\Page\Checkout\Finish\CheckoutFinishPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Monolog\Logger;
use OnlinePayments\Sdk\Domain\Order;
use OnlinePayments\Sdk\Domain\CreateHostedCheckoutRequest;
use OnlinePayments\Sdk\Domain\AmountOfMoney;
use MoptWordline\Bootstrap\Form;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;

class Payment implements  AsynchronousPaymentHandlerInterface
{
    private SystemConfigService $systemConfigService;

    private OrderTransactionStateHandler $transactionStateHandler;

    private EntityRepositoryInterface $orderRepository;

    private Session $session;

    private Logger $logger;

    /**
     * @param SystemConfigService $systemConfigService
     * @param OrderTransactionStateHandler $transactionStateHandler
     * @param EntityRepositoryInterface $orderRepository
     * @param Logger $logger
     * @param Session $session
     */
    public function __construct(
        SystemConfigService $systemConfigService,
        OrderTransactionStateHandler $transactionStateHandler,
        EntityRepositoryInterface $orderRepository,
        Logger $logger,
        Session $session
    )
    {
        $this->transactionStateHandler = $transactionStateHandler;
        $this->systemConfigService = $systemConfigService;
        $this->orderRepository = $orderRepository;
        $this->logger = $logger;
        $this->session = $session;
    }

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
     * @throws CustomerCanceledAsyncPaymentException
     */
    public function finalize(
        AsyncPaymentTransactionStruct $transaction,
        Request $request,
        SalesChannelContext $salesChannelContext
    ): void {
        $transactionId = $transaction->getOrderTransaction()->getId();

        //todo realise is it a Cancelled payment?
        if ($request->query->getBoolean('cancel')) {
            throw new CustomerCanceledAsyncPaymentException(
                $transactionId,
                'Customer canceled the payment on the PayPal page'
            );
        }

        $paymentState = $request->query->getAlpha('status');

        $context = $salesChannelContext->getContext();
        if ($paymentState === 'completed') {
            // Payment completed, set transaction status to "paid"
            $this->transactionStateHandler->paid($transaction->getOrderTransaction()->getId(), $context);
        } else {
            // Payment not completed, set transaction status to "open"
            $this->transactionStateHandler->reopen($transaction->getOrderTransaction()->getId(), $context);
        }
    }

    /**
     * @param OrderEntity $orderEntity
     * @param Context $context
     * @return string
     * @throws \Exception
     */
    private function sendReturnUrlToExternalGateway(AsyncPaymentTransactionStruct $transaction, Context $context)
    {
        $orderEntity = $transaction->getOrder();
        $currency = $orderEntity->getCurrency()->getIsoCode();
        $amountTotal = $orderEntity->getAmountTotal();

        $adapter = new WordlineSDKAdapter($this->systemConfigService, $this->logger);
        $merchantClient = $adapter->getMerchantClient();
        $hostedCheckoutClient = $merchantClient->hostedCheckout();

        $hostedCheckoutRequest =
            new CreateHostedCheckoutRequest();

        $order = new Order();

        $amountOfMoney = new AmountOfMoney();
        $amountOfMoney->setCurrencyCode($currency);
        $amountOfMoney->setAmount($amountTotal * 100);

        $order->setAmountOfMoney($amountOfMoney);

        $hostedCheckoutSpecificInput = new HostedCheckoutSpecificInput();

        $hostedCheckoutSpecificInput->setReturnUrl('http://localhost:8000/wordline/payment/finalize-transaction');
        $hostedCheckoutRequest->setOrder($order);
        $hostedCheckoutRequest->setHostedCheckoutSpecificInput($hostedCheckoutSpecificInput);

        // Get the response for the HostedCheckoutClient
        $hostedCheckoutResponse = $hostedCheckoutClient->createHostedCheckout($hostedCheckoutRequest);

        $this->orderRepository->update([
            [
                'id' => $transaction->getOrderTransaction()->getId(),
                'customFields' => [
                    Form::CUSTOM_FIELD_WORDLINE_PAYMENT_TRANSACTION_ID => $hostedCheckoutResponse->getHostedCheckoutId()
                ]
            ]
        ], $context);

        return $hostedCheckoutResponse->getRedirectUrl();
    }
}
