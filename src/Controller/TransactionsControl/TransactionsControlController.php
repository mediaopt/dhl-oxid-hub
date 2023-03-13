<?php

/**
 * @author Mediaopt GmbH
 * @package MoptWorldline\Controller
 */

namespace MoptWorldline\Controller\TransactionsControl;

use Monolog\Logger;
use MoptWorldline\Bootstrap\Form;
use MoptWorldline\Service\AdminTranslate;
use MoptWorldline\Service\Payment;
use MoptWorldline\Service\PaymentHandler;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @RouteScope(scopes={"api"})
 */
class TransactionsControlController extends AbstractController
{
    private SystemConfigService $systemConfigService;
    private EntityRepositoryInterface $orderTransactionRepository;
    private EntityRepositoryInterface $orderRepository;
    private EntityRepositoryInterface $customerRepository;
    private OrderTransactionStateHandler $transactionStateHandler;
    private Logger $logger;
    private TranslatorInterface $translator;
    private RequestStack $requestStack;

    /**
     * @param SystemConfigService $systemConfigService
     * @param EntityRepositoryInterface $orderTransactionRepository
     * @param EntityRepositoryInterface $orderRepository
     * @param EntityRepositoryInterface $customerRepository
     * @param OrderTransactionStateHandler $transactionStateHandler
     * @param Logger $logger
     * @param TranslatorInterface $translator
     * @param RequestStack $requestStack
     */
    public function __construct(
        SystemConfigService          $systemConfigService,
        EntityRepositoryInterface    $orderTransactionRepository,
        EntityRepositoryInterface    $orderRepository,
        EntityRepositoryInterface    $customerRepository,
        OrderTransactionStateHandler $transactionStateHandler,
        Logger                       $logger,
        TranslatorInterface          $translator,
        RequestStack                 $requestStack
    )
    {
        $this->systemConfigService = $systemConfigService;
        $this->orderTransactionRepository = $orderTransactionRepository;
        $this->orderRepository = $orderRepository;
        $this->customerRepository = $customerRepository;
        $this->transactionStateHandler = $transactionStateHandler;
        $this->logger = $logger;
        $this->translator = $translator;
        $this->requestStack = $requestStack;
    }

    /**
     * @Route(
     *     "/api/_action/transactions-control/status",
     *     name="api.action.transactions.control.status",
     *     methods={"POST"}
     * )
     */
    public function status(Request $request, Context $context): JsonResponse
    {
        $success = false;
        $message = AdminTranslate::trans($this->translator->getLocale(), "statusUpdateError");
        $hostedCheckoutId = $request->request->get('transactionId');
        if (!$hostedCheckoutId) {
            $message = AdminTranslate::trans($this->translator->getLocale(), "noTransactionForThisOrder");
            return $this->response($success, $message);
        }
        $handler = $this->getHandler($hostedCheckoutId, $context);
        if ($handler->updatePaymentStatus($hostedCheckoutId)) {
            $success = true;
            $message = AdminTranslate::trans($this->translator->getLocale(), "statusUpdateRequestSent");
        }
        return $this->response($success, $message);
    }

    /**
     * @Route(
     *     "/api/_action/transactions-control/capture",
     *     name="api.action.transactions.control.capture",
     *     methods={"POST"}
     * )
     */
    public function capture(Request $request, Context $context): JsonResponse
    {
        return $this->processPayment($request, $context, 'capturePayment');
    }

    /**
     * @Route(
     *     "/api/_action/transactions-control/cancel",
     *     name="api.action.transactions.control.cancel",
     *     methods={"POST"}
     * )
     */
    public function cancel(Request $request, Context $context): JsonResponse
    {
        return $this->processPayment($request, $context, 'cancelPayment');
    }

    /**
     * @Route(
     *     "/api/_action/transactions-control/refund",
     *     name="api.action.transactions.control.refund",
     *     methods={"POST"}
     * )
     */
    public function refund(Request $request, Context $context): JsonResponse
    {
        return $this->processPayment($request, $context, 'refundPayment');
    }

    /**
     * @Route(
     *     "/api/_action/transactions-control/enableButtons",
     *     name="api.action.transactions.control.enableButtons",
     *     methods={"POST"}
     * )
     */
    public function enableButtons(Request $request, Context $context): JsonResponse
    {
        try {
            $hostedCheckoutId = $request->request->get('transactionId');
            $orderTransaction = PaymentHandler::getOrderTransaction($context, $this->orderTransactionRepository, $hostedCheckoutId);

            $customFields = $orderTransaction->getCustomFields();
            $log = [];
            if (array_key_exists(Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_LOG, $customFields)) {
                foreach ($customFields[Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_TRANSACTION_LOG] as $logId => $logEntity) {
                    $date = date('d-m-Y H:i:s', $logEntity['date']);
                    $amount = $logEntity['amount'] / 100;
                    $log[] = "$logId $date $amount {$logEntity['readableStatus']}";
                }
            }
            [$allowedActions, $allowedAmounts] = Payment::getAllowed($customFields);
        } catch (\Exception $e) {
            debug($e->getMessage());
            return $this->response(false,'');
        }
        return
            new JsonResponse([
                'success' => true,
                'message' => $allowedActions,
                'allowedAmounts' => $allowedAmounts,
                'log' => $log
            ]);
    }

    /**
     * @param Request $request
     * @param Context $context
     * @param string $action
     * @return JsonResponse
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    private function processPayment(Request $request, Context $context, string $action): JsonResponse
    {
        $hostedCheckoutId = $request->request->get('transactionId');
        $amount = (int)round($request->request->get('amount') * 100);
        if (!$hostedCheckoutId) {
            $message = AdminTranslate::trans($this->translator->getLocale(), "noTransactionForThisOrder");
            return $this->response(false, $message);
        }
        if (!$amount || $amount < 0) {
            $message = AdminTranslate::trans($this->translator->getLocale(), "wrongAmountInRequest");//todo
            return $this->response(false, $message);
        }

        $handler = $this->getHandler($hostedCheckoutId, $context);

        Payment::lockOrder($this->requestStack->getSession(), $handler->getOrderId());
        $message = AdminTranslate::trans($this->translator->getLocale(), "failed");
        if ($result = $handler->$action($hostedCheckoutId, $amount)) {
            $message = AdminTranslate::trans($this->translator->getLocale(), "success");
        }
        Payment::unlockOrder($this->requestStack->getSession(), $handler->getOrderId());

        return $this->response($result, $message);
    }

    /**
     * @param bool $success
     * @param string $message
     * @return JsonResponse
     */
    private function response(bool $success, string $message): JsonResponse
    {
        return new JsonResponse([
            'success' => $success,
            'message' => $message
        ]);
    }

    /**
     * @param string $hostedCheckoutId
     * @param Context $context
     * @return PaymentHandler|null
     */
    private function getHandler(string $hostedCheckoutId, Context $context): ?PaymentHandler
    {
        $orderTransaction = PaymentHandler::getOrderTransaction($context, $this->orderTransactionRepository, $hostedCheckoutId);

        return new PaymentHandler(
            $this->systemConfigService,
            $this->logger,
            $orderTransaction,
            $this->translator,
            $this->orderRepository,
            $this->orderTransactionRepository,
            $this->customerRepository,
            $context,
            $this->transactionStateHandler
        );
    }
}
