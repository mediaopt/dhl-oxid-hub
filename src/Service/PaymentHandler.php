<?php

namespace MoptWorldline\Service;

use Monolog\Logger;
use MoptWorldline\Bootstrap\Form;
use OnlinePayments\Sdk\Domain\AmountOfMoney;
use OnlinePayments\Sdk\Domain\CancelPaymentRequest;
use OnlinePayments\Sdk\Domain\CreateHostedCheckoutResponse;
use OnlinePayments\Sdk\Domain\CreatePaymentResponse;
use OnlinePayments\Sdk\Domain\GetHostedTokenizationResponse;
use OnlinePayments\Sdk\Domain\PaymentDetailsResponse;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionEntity;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStates;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Checkout\Payment\Exception\InvalidTransactionException;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\NotFilter;
use Shopware\Core\Kernel;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use MoptWorldline\Adapter\WorldlineSDKAdapter;
use Symfony\Contracts\Translation\TranslatorInterface;

class PaymentHandler
{
    private WorldlineSDKAdapter $adapter;
    private OrderTransactionEntity $orderTransaction;
    private TranslatorInterface $translator;
    private EntityRepositoryInterface $orderRepository;
    private EntityRepositoryInterface $orderTransactionRepository;
    private Context $context;
    private OrderTransactionStateHandler $transactionStateHandler;
    private EntityRepositoryInterface $customerRepository;

    /**
     * @param SystemConfigService $systemConfigService
     * @param Logger $logger
     * @param OrderTransactionEntity $orderTransaction
     * @param TranslatorInterface $translator
     * @param EntityRepositoryInterface $orderRepository
     * @param EntityRepositoryInterface $orderTransactionRepository
     * @param EntityRepositoryInterface $customerRepository
     * @param Context $context
     * @param OrderTransactionStateHandler $transactionStateHandler
     */
    public function __construct(
        SystemConfigService          $systemConfigService,
        Logger                       $logger,
        OrderTransactionEntity       $orderTransaction,
        TranslatorInterface          $translator,
        EntityRepositoryInterface    $orderRepository,
        EntityRepositoryInterface    $orderTransactionRepository,
        EntityRepositoryInterface    $customerRepository,
        Context                      $context,
        OrderTransactionStateHandler $transactionStateHandler
    )
    {
        $salesChannelId = $orderTransaction->getOrder()->getSalesChannelId();
        $this->adapter = new WorldlineSDKAdapter($systemConfigService, $logger, $salesChannelId);
        $this->orderTransaction = $orderTransaction;
        $this->translator = $translator;
        $this->orderRepository = $orderRepository;
        $this->orderTransactionRepository = $orderTransactionRepository;
        $this->customerRepository = $customerRepository;
        $this->context = $context;
        $this->transactionStateHandler = $transactionStateHandler;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderTransaction->getOrder()->getId();
    }

    /**
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->orderTransaction->getOrder()->getOrderCustomer()->getCustomerId();
    }

    /**
     * @param string $hostedCheckoutId
     * @param $status
     * @return int
     * @throws \Exception
     */
    public function updatePaymentStatus(string $hostedCheckoutId, $status = false): int
    {
        if (!$status) {
            $status = $this->updatePaymentTransactionStatus($hostedCheckoutId);
        } else {
            $this->saveOrderCustomFields($status, $hostedCheckoutId);
        }
        $this->updateOrderTransactionState($status, $hostedCheckoutId);

        return $status;
    }

    /**
     * @param int $worldlinePaymentMethodId
     * @return CreateHostedCheckoutResponse
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function createPayment(int $worldlinePaymentMethodId): CreateHostedCheckoutResponse
    {
        $order = $this->orderTransaction->getOrder();
        $orderObject = null;
        if (in_array($worldlinePaymentMethodId, PaymentProducts::PAYMENT_PRODUCT_NEED_DETAILS)) {
            $criteria = new Criteria([$order->getId()]);
            $criteria->addAssociation('lineItems')
                ->addAssociation('deliveries.positions.orderLineItem')
                ->addAssociation('orderCustomer.customer')
                ->addAssociation('orderCustomer.customer.group')
                ->addAssociation('language.locale')
                ->addAssociation('billingAddress')
                ->addAssociation('billingAddress.country')
                ->addAssociation('deliveries.shippingOrderAddress')
                ->addAssociation('deliveries.shippingOrderAddress.country');
            $orderObject = $this->orderRepository->search($criteria, $this->context)->first();
        }

        $amountTotal = $order->getAmountTotal();
        $currencyISO = $this->getCurrencyISO();

        $this->log(AdminTranslate::trans($this->translator->getLocale(), 'buildingOrder'));
        $hostedCheckoutResponse = $this->adapter->createPayment(
            $amountTotal,
            $currencyISO,
            $worldlinePaymentMethodId,
            $orderObject
        );

        $this->saveOrderCustomFields(
            Payment::STATUS_PAYMENT_CREATED[0],
            $hostedCheckoutResponse->getHostedCheckoutId(),
            [
                'toCaptureOrCancel' => $amountTotal * 100,
                'toRefund' => 0,
            ]
        );
        return $hostedCheckoutResponse;
    }

    /**
     * @param array $iframeData
     * @return CreatePaymentResponse
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function createHostedTokenizationPayment(array $iframeData): CreatePaymentResponse
    {
        $order = $this->orderTransaction->getOrder();
        $amountTotal = $order->getAmountTotal();
        $currencyISO = $this->getCurrencyISO();

        $this->log(AdminTranslate::trans($this->translator->getLocale(), 'buildingHostdTokenizationOrder'));
        $hostedTokenization = $this->adapter->createHostedTokenization($iframeData);
        $hostedTokenizationPaymentResponse = $this->adapter->createHostedTokenizationPayment(
            $amountTotal,
            $currencyISO,
            $iframeData,
            $hostedTokenization
        );
        $this->saveCustomerCustomFields($hostedTokenization);

        $id = explode('_', $hostedTokenizationPaymentResponse->getPayment()->getId());
        $this->saveOrderCustomFields(
            $hostedTokenizationPaymentResponse->getPayment()->getStatusOutput()->getStatusCode(),
            $id[0],
            [
                'toCaptureOrCancel' => $amountTotal * 100,
                'toRefund' => 0,
            ]
        );

        return $hostedTokenizationPaymentResponse;
    }

    /**
     * @param string $hostedCheckoutId
     * @param float $amount
     * @return bool
     * @throws \Exception
     */
    public function capturePayment(string $hostedCheckoutId, float $amount): bool
    {
        $status = $this->updatePaymentTransactionStatus($hostedCheckoutId);
        $customFields = $this->orderTransaction->getCustomFields();

        if (!in_array($status, Payment::STATUS_PENDING_CAPTURE)) {
            $this->log('operationIsNotPossibleDueToCurrentStatus' . $status, Logger::ERROR);
            return false;
        }
        if ($amount > $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_CAPTURE_AMOUNT]) {
            $this->log('operationIsNotPossibleDueToCurrentStatus' . $amount, Logger::ERROR); //todo
            return false;
        }

        $isFinal = ($amount == $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_CAPTURE_AMOUNT]);
        $captureResponse = $this->adapter->capturePayment($hostedCheckoutId, $amount, $isFinal);
        $this->log('capturePayment', 0, $captureResponse->toJson());
        $newStatus = $captureResponse->getStatusOutput()->getStatusCode();

        $this->saveOrderCustomFields(
            $newStatus,
            $hostedCheckoutId,
            $this->recalculateAmounts($customFields, $amount, 0),
            date('d-m-Y H:i:s') . ' captured ' . ($amount / 100)
        );
        $this->updateOrderTransactionState($newStatus, $hostedCheckoutId);

        if (!in_array($newStatus, Payment::STATUS_CAPTURE_REQUESTED)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $hostedCheckoutId
     * @param float $amount
     * @return bool
     * @throws \Exception
     */
    public function cancelPayment(string $hostedCheckoutId, float $amount): bool
    {
        $status = $this->updatePaymentTransactionStatus($hostedCheckoutId);
        if (!in_array($status, Payment::STATUS_PENDING_CAPTURE)) {
            $this->log('operationIsNotPossibleDueToCurrentStatus' . $status, Logger::ERROR);
            return false;
        }

        $customFields = $this->orderTransaction->getCustomFields();
        if ($amount > $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_CAPTURE_AMOUNT]) {
            $this->log('operationIsNotPossibleDueToCurrentStatus' . $status, Logger::ERROR); //todo
            return false;
        }

        $currencyISO = $this->getCurrencyISO();
        if ($currencyISO === false) {
            return false;
        }

        $isFinal = $amount == $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_CAPTURE_AMOUNT];
        $cancelResponse = $this->adapter->cancelPayment(
            $hostedCheckoutId,
            $amount,
            $currencyISO,
            $isFinal
        );
        $this->log('cancelPayment', 0, $cancelResponse->toJson());
        $newStatus = $this->adapter->getCancelStatus($cancelResponse);

        $this->saveOrderCustomFields(
            $newStatus,
            $hostedCheckoutId,
            $this->recalculateAmounts($customFields, $amount, 0),
            date('d-m-Y H:i:s') . ' cancelled ' . ($amount / 100)
        );
        $this->updateOrderTransactionState($newStatus, $hostedCheckoutId);

        if (!in_array($newStatus, Payment::STATUS_PAYMENT_CANCELLED)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $hostedCheckoutId
     * @param float $amount
     * @return bool
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function refundPayment(string $hostedCheckoutId, float $amount): bool
    {
        $status = $this->updatePaymentTransactionStatus($hostedCheckoutId);

        /*if (in_array($status, Payment::STATUS_REFUNDED)) {
            return false;
        }
        /*if (!in_array($status, Payment::STATUS_CAPTURED)) {
            $this->log('operationIsNotPossibleDueToCurrentStatus' . $status, Logger::ERROR);
            return false;
        }*/

        $customFields = $this->orderTransaction->getCustomFields();
        if ($amount > $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_REFUND_AMOUNT]) {
            $this->log('operationIsNotPossibleDueToCurrentStatus' . $status, Logger::ERROR); //todo
            return false;
        }

        $currencyISO = $this->getCurrencyISO();
        if ($currencyISO === false) {
            return false;
        }

        $orderNumber = $this->orderTransaction->getOrder()->getOrderNumber();

        $refundResponse = $this->adapter->refundPayment(
            $hostedCheckoutId,
            $amount,
            $currencyISO,
            $orderNumber
        );

        $this->log('refundPayment', 0, $refundResponse->toJson());
        $newStatus = $this->adapter->getRefundStatus($refundResponse);

        $this->saveOrderCustomFields(
            $newStatus,
            $hostedCheckoutId,
            $this->recalculateAmounts($customFields, 0, $amount),
            date('d-m-Y H:i:s') . ' refunded ' . ($amount / 100)
        );
        $this->updateOrderTransactionState($newStatus, $hostedCheckoutId);

        if (!in_array($newStatus, Payment::STATUS_REFUND_REQUESTED)
            && !in_array($newStatus, Payment::STATUS_REFUNDED)) {
            return false;
        }
        return true;
    }

    /**
     * @param string $hostedCheckoutId
     * @return void
     * @throws \Exception
     */
    private function updatePaymentTransactionStatus(string $hostedCheckoutId): string
    {
        $this->log('gettingPaymentDetails', 0, ['hostedCheckoutId' => $hostedCheckoutId]);
        $paymentDetails = $this->adapter->getPaymentDetails($hostedCheckoutId);

        if ($token = $this->adapter->getRedirectToken($paymentDetails)) {
            $card = $this->createRedirectPaymentProduct($token, $paymentDetails);
            $this->saveCustomerCustomFields(
                null,
                $token,
                $card
            );
        }

        $status = $this->adapter->getStatus($paymentDetails);
        $this->saveOrderCustomFields($status, $hostedCheckoutId);
        return $status;
    }

    /**
     * @param array $customFields
     * @param float $captureOrCancelAmount
     * @param float $refundAmount
     * @return float[]
     */
    private function recalculateAmounts(array $customFields, float $captureOrCancelAmount, float $refundAmount): array
    {
        $toCaptureOrCancel = $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_CAPTURE_AMOUNT];
        $toRefund = $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_REFUND_AMOUNT];

        return [
            'toCaptureOrCancel' => $toCaptureOrCancel - $captureOrCancelAmount,
            'toRefund' => $toRefund + $captureOrCancelAmount - $refundAmount,
        ];
    }

    /**
     * @param int $statusCode
     * @param string $hostedCheckoutId
     * @param array $amounts
     * @param string $log
     * @return void
     */
    private function saveOrderCustomFields(int $statusCode, string $hostedCheckoutId, array $amounts = [], string $log = '')
    {
        $orderId = $this->getOrderId();
        $transactionId = $this->orderTransaction->getId();

        $currentCustomField = $this->orderTransaction->getCustomFields();
        if (!empty($currentCustomField)) {
            $customFields = $currentCustomField;
        }

        $readableStatus = $this->getReadableStatus($statusCode);
        $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_HOSTED_CHECKOUT_ID] = $hostedCheckoutId;
        $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_STATUS] = (string)$statusCode;
        $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_READABLE_STATUS] = $readableStatus;

        if (!empty($amounts)) {
            $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_CAPTURE_AMOUNT] = $amounts['toCaptureOrCancel'];
            $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_REFUND_AMOUNT] = $amounts['toRefund'];
        }

        if (!empty($log)) {
            $customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_LOG][] = $log;
        }

        $this->orderTransactionRepository->update([
            [
                'id' => $transactionId,
                'customFields' => $customFields
            ]
        ], $this->context);

        $this->orderRepository->update([
            [
                'id' => $orderId,
                'customFields' => $customFields
            ]
        ], $this->context);
    }

    /**
     * @param int $statusCode
     * @param string $hostedCheckoutId
     * @return void
     */
    public function updateOrderTransactionState(int $statusCode, string $hostedCheckoutId)
    {
        $orderTransactionId = $this->orderTransaction->getId();
        $orderTransactionState = $this->orderTransaction->getStateMachineState()->getTechnicalName();

        switch ($statusCode) {
            case in_array($statusCode, Payment::STATUS_PAYMENT_CREATED):
            case in_array($statusCode, Payment::STATUS_PENDING_CAPTURE):
            {
                if ($orderTransactionState === OrderTransactionStates::STATE_OPEN) {
                    break;
                }
                $this->log(
                    'paymentOpen',
                    0,
                    ['status' => $statusCode, 'hostedCheckoutId' => $hostedCheckoutId]
                );
                $this->transactionStateHandler->reopen($orderTransactionId, $this->context);
                break;
            }
            case in_array($statusCode, Payment::STATUS_CAPTURE_REQUESTED):
            {
                if ($orderTransactionState === OrderTransactionStates::STATE_IN_PROGRESS) {
                    break;
                }
                $this->log(
                    'paymentInProgress',
                    0,
                    ['status' => $statusCode, 'hostedCheckoutId' => $hostedCheckoutId]
                );
                $this->transactionStateHandler->process($orderTransactionId, $this->context);
                break;
            }
            case in_array($statusCode, Payment::STATUS_CAPTURED):
            {
                if ($orderTransactionState === OrderTransactionStates::STATE_PAID) {
                    break;
                }
                $this->log(
                    'paymentPaid',
                    0,
                    ['status' => $statusCode, 'hostedCheckoutId' => $hostedCheckoutId]
                );
                $this->transactionStateHandler->paid($orderTransactionId, $this->context);
                break;
            }
            case in_array($statusCode, Payment::STATUS_REFUND_REQUESTED):
            case in_array($statusCode, Payment::STATUS_REFUNDED):
            {
                if ($orderTransactionState === OrderTransactionStates::STATE_REFUNDED) {
                    break;
                }
                $this->log(
                    'paymentRefunded',
                    0,
                    ['status' => $statusCode, 'hostedCheckoutId' => $hostedCheckoutId]
                );
                $this->transactionStateHandler->refund($orderTransactionId, $this->context);
                break;
            }
            case in_array($statusCode, Payment::STATUS_PAYMENT_CANCELLED):
            {
                if ($orderTransactionState === OrderTransactionStates::STATE_CANCELLED) {
                    break;
                }
                $this->log(
                    'paymentCanceled',
                    0,
                    ['status' => $statusCode, 'hostedCheckoutId' => $hostedCheckoutId]
                );
                $this->transactionStateHandler->cancel($orderTransactionId, $this->context);
                break;
            }
            case in_array($statusCode, Payment::STATUS_PAYMENT_REJECTED):
            case in_array($statusCode, Payment::STATUS_REJECTED_CAPTURE):
            {
                if ($orderTransactionState === OrderTransactionStates::STATE_FAILED) {
                    break;
                }
                $this->log(
                    'paymentFailed',
                    0,
                    ['status' => $statusCode, 'hostedCheckoutId' => $hostedCheckoutId]
                );
                $this->transactionStateHandler->fail($orderTransactionId, $this->context);
                break;
            }
            default:
            {
                break;
            }
        }
    }

    /**
     * @param Context $context
     * @param EntityRepositoryInterface $orderTransactionRepository
     * @param string $hostedCheckoutId
     * @return OrderTransactionEntity|null
     */
    public static function getOrderTransaction(
        Context                   $context,
        EntityRepositoryInterface $orderTransactionRepository,
        string                    $hostedCheckoutId
    ): ?OrderTransactionEntity
    {
        $criteria = new Criteria();
        $criteria->addAssociation('order');
        $criteria->addFilter(
            new MultiFilter(
                MultiFilter::CONNECTION_AND,
                [
                    new EqualsFilter(
                        \sprintf('customFields.%s', Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_HOSTED_CHECKOUT_ID),
                        $hostedCheckoutId
                    ),
                    new NotFilter(
                        NotFilter::CONNECTION_AND,
                        [
                            new EqualsFilter(
                                \sprintf('customFields.%s', Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_HOSTED_CHECKOUT_ID),
                                null
                            ),
                        ]
                    ),
                ]
            )
        );

        /** @var OrderTransactionEntity|null $orderTransaction */
        $orderTransaction = $orderTransactionRepository->search($criteria, $context)->getEntities()->first();

        if ($orderTransaction === null) {
            throw new InvalidTransactionException('');
        }

        return $orderTransaction;
    }

    /**
     * @param array $request
     * @return void
     */
    public function logWebhook(array $request)
    {
        $this->log('webhook', 0, $request);
    }

    /**
     * @param string $string
     * @param int $logLevel
     * @param mixed $additionalData
     * @return void
     */
    private function log(string $string, int $logLevel = 0, $additionalData = null)
    {
        $additionalData = array_merge(
            [$additionalData],
            ['orderNumber' => $this->orderTransaction->getOrder()->getOrderNumber()]
        );

        $this->adapter->log(
            AdminTranslate::trans($this->translator->getLocale(), $string),
            $logLevel,
            $additionalData
        );
    }

    /**
     * @param string $currencyId
     * @return false|mixed|mixed[]
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    private function getCurrencyISO()
    {
        $currencyId = $this->orderTransaction->getOrder()->getCurrencyId();

        $connection = Kernel::getConnection();
        $sql = "SELECT iso_code  FROM `currency` WHERE id = UNHEX('$currencyId')";
        $currencyISO = $connection->executeQuery($sql)->fetchAssociative();

        if (array_key_exists('iso_code', $currencyISO)) {
            return $currencyISO['iso_code'];
        }

        $this->log('cantFindCurrencyOfOrder' . $currencyId, Logger::ERROR);
        return false;
    }

    /**
     * @param $statusCode
     * @return string
     */
    private function getReadableStatus($statusCode): string
    {
        $label = AdminTranslate::trans($this->translator->getLocale(), 'unknownStatus');
        if (array_key_exists($statusCode, Payment::STATUS_LABELS)) {
            $label = AdminTranslate::trans($this->translator->getLocale(), "transactionStatus." . Payment::STATUS_LABELS[$statusCode]);
        }

        return $label . " ($statusCode)";
    }

    public function translate($id)
    {
        return AdminTranslate::trans($this->translator->getLocale(), $id);
    }

    /**
     * @param GetHostedTokenizationResponse|null $hostedTokenization
     * @param string $token
     * @param array $paymentProduct
     * @return void
     */
    private function saveCustomerCustomFields(
        ?GetHostedTokenizationResponse $hostedTokenization,
        string                         $token = '',
        array                          $paymentProduct = []
    )
    {
        if (!is_null($hostedTokenization) && $hostedTokenization->getToken()->getIsTemporary()) {
            return;
        }

        if (empty($token)) {
            [$token, $paymentProduct] = $this->createPaymentProduct($hostedTokenization);
        }

        $customerId = $this->getCustomerId();
        $customer = $this->customerRepository->search(new Criteria([$customerId]), $this->context);
        $customFields = $customer->first()->getCustomFields();
        $customFields[Form::CUSTOM_FIELD_WORLDLINE_CUSTOMER_SAVED_PAYMENT_CARD_TOKEN][$token] = $paymentProduct;

        $this->customerRepository->update([
            [
                'id' => $customerId,
                'customFields' => $customFields
            ]
        ], $this->context);
    }

    /**
     * @param GetHostedTokenizationResponse $hostedTokenization
     * @return array
     */
    private function createPaymentProduct(GetHostedTokenizationResponse $hostedTokenization): array
    {
        $paymentProductId = $hostedTokenization->getToken()->getPaymentProductId();
        $token = $hostedTokenization->getToken()->getId();
        return [
            $token,
            array_merge(
                [
                    'paymentProductId' => $paymentProductId,
                    'token' => $token,
                    'paymentCard' => $hostedTokenization->getToken()->getCard()->getData()->getCardWithoutCvv()->getCardNumber(),
                    'default' => false
                ],
                PaymentProducts::getPaymentProductDetails($paymentProductId)
            )
        ];
    }

    /**
     * @param $token
     * @param PaymentDetailsResponse $paymentDetailsResponse
     * @return array
     */
    private function createRedirectPaymentProduct($token, PaymentDetailsResponse $paymentDetailsResponse): array
    {
        $paymentProductId = $paymentDetailsResponse->getPaymentOutput()->getCardPaymentMethodSpecificOutput()->getPaymentProductId();

        // Make masked card number from bin (123456) and last 4 digs (************1234) - 123456******1234
        $bin = $paymentDetailsResponse->getPaymentOutput()->getCardPaymentMethodSpecificOutput()->getCard()->getBin();
        $card = $paymentDetailsResponse->getPaymentOutput()->getCardPaymentMethodSpecificOutput()->getCard()->getCardNumber();
        $paymentCard = substr_replace($card, $bin, 0, 6);
        return array_merge(
            [
                'paymentProductId' => $paymentProductId,
                'token' => $token,
                'paymentCard' => $paymentCard,
                'default' => false
            ],
            PaymentProducts::getPaymentProductDetails($paymentProductId)
        );
    }
}
