<?php declare(strict_types=1);

/**
 * @author Mediaopt GmbH
 * @package MoptWordline\Service
 */

namespace MoptWordline\Service;

use MoptWordline\Adapter\WordlineSDKAdapter;
use OnlinePayments\Sdk\Domain\HostedCheckoutSpecificInput;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Checkout\Order\OrderEntity;
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
use Symfony\Component\HttpFoundation\Session\Session;
use Monolog\Logger;
use OnlinePayments\Sdk\Domain\Order;
use OnlinePayments\Sdk\Domain\CreateHostedCheckoutRequest;
use OnlinePayments\Sdk\Domain\AmountOfMoney;
use MoptWordline\Bootstrap\Form;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class Payment implements  AsynchronousPaymentHandlerInterface
{
    private SystemConfigService $systemConfigService;

    private OrderTransactionStateHandler $transactionStateHandler;

    private EntityRepositoryInterface $orderTransactionRepository;

    private EntityRepositoryInterface $orderRepository;

    private TranslatorInterface $translator;

    private Session $session;

    private Logger $logger;

    /**
     * @param SystemConfigService $systemConfigService
     * @param OrderTransactionStateHandler $transactionStateHandler
     * @param EntityRepositoryInterface $orderRepository
     * @param TranslatorInterface $translator
     * @param Logger $logger
     * @param Session $session
     */
    public function __construct(
        SystemConfigService $systemConfigService,
        OrderTransactionStateHandler $transactionStateHandler,
        EntityRepositoryInterface $orderTransactionRepository,
        EntityRepositoryInterface $orderRepository,
        TranslatorInterface $translator,
        Logger $logger,
        Session $session
    )
    {
        $this->transactionStateHandler = $transactionStateHandler;
        $this->systemConfigService = $systemConfigService;
        $this->orderTransactionRepository = $orderTransactionRepository;
        $this->orderRepository = $orderRepository;
        $this->translator = $translator;
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
        $transactionId = $transaction->getOrderTransaction()->getId();
        $orderEntity = $transaction->getOrder();
        $orderId = $orderEntity->getId();
        $currency = $orderEntity->getCurrency()->getIsoCode();
        $amountTotal = $orderEntity->getAmountTotal();

        $adapter = new WordlineSDKAdapter($this->systemConfigService, $this->logger);
        $adapter->log($this->translator->trans('started'));

        $merchantClient = $adapter->getMerchantClient();
        $hostedCheckoutClient = $merchantClient->hostedCheckout();

        $hostedCheckoutRequest =
            new CreateHostedCheckoutRequest();

        $adapter->log($this->translator->trans('buildingOrder'));
        $order = new Order();

        $amountOfMoney = new AmountOfMoney();
        $amountOfMoney->setCurrencyCode($currency);
        $amountOfMoney->setAmount($amountTotal * 100);

        $order->setAmountOfMoney($amountOfMoney);

        $hostedCheckoutSpecificInput = new HostedCheckoutSpecificInput();

        $returnUrl = $adapter->getPluginConfig(Form::RETURN_URL_FIELD);
        $hostedCheckoutSpecificInput->setReturnUrl($returnUrl);
        $hostedCheckoutRequest->setOrder($order);
        $hostedCheckoutRequest->setHostedCheckoutSpecificInput($hostedCheckoutSpecificInput);

        try {
            $hostedCheckoutResponse = $hostedCheckoutClient->createHostedCheckout($hostedCheckoutRequest);
        } catch (\Exception $e){
            $adapter->log($e->getMessage(), Logger::ERROR);

            throw new AsyncPaymentProcessException(
                $transactionId,
                \sprintf('An error occurred during the communication with Wordline%s%s', \PHP_EOL, $e->getMessage())
            );
        }

        $customFields = [
            Form::CUSTOM_FIELD_WORDLINE_PAYMENT_TRANSACTION_ID => $hostedCheckoutResponse->getHostedCheckoutId()
        ];

        $this->orderTransactionRepository->update([
            [
                'id' => $transactionId,
                'customFields' => $customFields
            ]
        ], $context);

        $this->orderRepository->update([
            [
                'id' => $orderId,
                'customFields' => $customFields
            ]
        ], $context);

        $link = $hostedCheckoutResponse->getRedirectUrl();
        if ($link === null) {
            throw new AsyncPaymentProcessException($transactionId, 'No redirect link provided by Wordline');
        }

        return $link;
    }
}
