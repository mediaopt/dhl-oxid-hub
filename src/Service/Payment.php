<?php declare(strict_types=1);

/**
 * @author Mediaopt GmbH
 * @package MoptWordline\Service
 */

namespace MoptWordline\Service;

use MoptWordline\Adapter\WordlineSDKAdapter;
use OnlinePayments\Sdk\DataObject;
use OnlinePayments\Sdk\Domain\HostedCheckoutSpecificInput;
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
use Monolog\Logger;
use OnlinePayments\Sdk\Domain\Order;
use OnlinePayments\Sdk\Domain\CreateHostedCheckoutRequest;
use OnlinePayments\Sdk\Domain\AmountOfMoney;
use MoptWordline\Bootstrap\Form;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class Payment implements AsynchronousPaymentHandlerInterface
{
    private SystemConfigService $systemConfigService;

    private EntityRepositoryInterface $orderTransactionRepository;

    private EntityRepositoryInterface $orderRepository;

    private TranslatorInterface $translator;

    private Logger $logger;

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

    /**
     * @param SystemConfigService $systemConfigService
     * @param EntityRepositoryInterface $orderTransactionRepository
     * @param EntityRepositoryInterface $orderRepository
     * @param TranslatorInterface $translator
     * @param Logger $logger
     */
    public function __construct(
        SystemConfigService       $systemConfigService,
        EntityRepositoryInterface $orderTransactionRepository,
        EntityRepositoryInterface $orderRepository,
        TranslatorInterface       $translator,
        Logger                    $logger
    )
    {
        $this->systemConfigService = $systemConfigService;
        $this->orderTransactionRepository = $orderTransactionRepository;
        $this->orderRepository = $orderRepository;
        $this->translator = $translator;
        $this->logger = $logger;
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
        $salseChannelId = $orderEntity->getSalesChannelId();

        $adapter = new WordlineSDKAdapter($this->systemConfigService, $this->logger, $salseChannelId);
        $adapter->log($this->translator->trans('started'));

        $hostedCheckoutRequest = $this->buildHostedCheckoutRequest($adapter, $currency, $amountTotal);

        $merchantClient = $adapter->getMerchantClient();
        $hostedCheckoutClient = $merchantClient->hostedCheckout();
        try {
            $hostedCheckoutResponse = $hostedCheckoutClient->createHostedCheckout($hostedCheckoutRequest);
        } catch (\Exception $e) {
            $adapter->log($e->getMessage(), Logger::ERROR);

            throw new AsyncPaymentProcessException(
                $transactionId,
                \sprintf('An error occurred during the communication with Wordline%s%s', \PHP_EOL, $e->getMessage())
            );
        }

        $this->saveCustomFields($hostedCheckoutResponse, $context, $transactionId, $orderId);

        $link = $hostedCheckoutResponse->getRedirectUrl();
        if ($link === null) {
            throw new AsyncPaymentProcessException($transactionId, 'No redirect link provided by Wordline');
        }

        return $link;
    }

    /**
     * @param WordlineSDKAdapter $adapter
     * @param string $currency
     * @param float $amountTotal
     * @return CreateHostedCheckoutRequest
     */
    private function buildHostedCheckoutRequest( //todo move it to PaymentHandler
        WordlineSDKAdapter $adapter,
        string             $currency,
        float              $amountTotal
    ): CreateHostedCheckoutRequest
    {
        $hostedCheckoutRequest =
            new CreateHostedCheckoutRequest();

        $adapter->log($this->translator->trans('buildingOrder'));

        $amountOfMoney = new AmountOfMoney();
        $amountOfMoney->setCurrencyCode($currency);
        $amountOfMoney->setAmount($amountTotal * 100);

        $order = new Order();
        $order->setAmountOfMoney($amountOfMoney);

        $hostedCheckoutSpecificInput = new HostedCheckoutSpecificInput();

        $returnUrl = $adapter->getPluginConfig(Form::RETURN_URL_FIELD);
        $hostedCheckoutSpecificInput->setReturnUrl($returnUrl);
        $hostedCheckoutRequest->setOrder($order);
        $hostedCheckoutRequest->setHostedCheckoutSpecificInput($hostedCheckoutSpecificInput);

        return $hostedCheckoutRequest;
    }

    /**
     * @param DataObject $hostedCheckoutResponse
     * @param Context $context
     * @param string $transactionId
     * @param string $orderId
     * @return void
     */
    private function saveCustomFields( //todo move it to PaymentHandler
        DataObject $hostedCheckoutResponse,
        Context    $context,
        string     $transactionId,
        string     $orderId
    )
    {
        $customFields = [
            Form::CUSTOM_FIELD_WORDLINE_PAYMENT_HOSTED_CHECKOUT_ID => $hostedCheckoutResponse->getHostedCheckoutId()
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
    }

}
