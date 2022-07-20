<?php

/**
 * @author Mediaopt GmbH
 * @package MoptWordline\Controller
 */

namespace MoptWordline\Controller\TransactionsControl;

use Monolog\Logger;
use MoptWordline\Bootstrap\Form;use MoptWordline\Service\Payment;
use MoptWordline\Service\PaymentHandler;
use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStateHandler;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Kernel;
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
    private OrderTransactionStateHandler $transactionStateHandler;
    private Logger $logger;
    private TranslatorInterface $translator;

    /**
     * @param SystemConfigService $systemConfigService
     * @param EntityRepositoryInterface $orderTransactionRepository
     * @param EntityRepositoryInterface $orderRepository
     * @param OrderTransactionStateHandler $transactionStateHandler
     * @param Logger $logger
     * @param TranslatorInterface $translator
     */
    public function __construct(
        SystemConfigService          $systemConfigService,
        EntityRepositoryInterface    $orderTransactionRepository,
        EntityRepositoryInterface    $orderRepository,
        OrderTransactionStateHandler $transactionStateHandler,
        Logger                       $logger,
        TranslatorInterface          $translator
    )
    {
        $this->systemConfigService = $systemConfigService;
        $this->orderTransactionRepository = $orderTransactionRepository;
        $this->orderRepository = $orderRepository;
        $this->transactionStateHandler = $transactionStateHandler;
        $this->logger = $logger;
        $this->translator = $translator;
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
        $message = 'Statue update error'; //todo translate
        if (!$hostedCheckoutId = $this->getTransactionId($request)) {
            $message = 'There is no transaction id for this order.'; //todo translate
            return $this->response($success, $message);
        }
        $handler = $this->getHandler($hostedCheckoutId, $context);
        $status = $handler->handlePayment($hostedCheckoutId);
        if ($status != 0) {
            $success = true;
            $message = 'Status update request sended.';
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
        if (!$hostedCheckoutId = $this->getTransactionId($request)) {
            $message = 'There is no transaction id for this order.'; //todo translate
            return $this->response(false, $message);
        }

        $handler = $this->getHandler($hostedCheckoutId, $context);

        $handler->capturePayment($hostedCheckoutId);

        $message = 'success'; //todo translate
        return $this->response(true, $message);
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
        if (!$hostedCheckoutId = $this->getTransactionId($request)) {
            $message = 'There is no transaction id for this order.'; //todo translate
            return $this->response(false, $message);
        }

        $handler = $this->getHandler($hostedCheckoutId, $context);

        $handler->refundPayment($hostedCheckoutId);

        $message = 'success'; //todo translate
        return $this->response(true, $message);
    }

    /**
     * @param Request $request
     * @return false|string
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    private function getTransactionId(Request $request): ?string
    {
        $url = explode('/', $request->request->get('url'));
        $orderId = $url[count($url) - 2];

        $connection = Kernel::getConnection();
        $sql = "SELECT custom_fields  FROM `order_transaction` WHERE order_id = UNHEX('$orderId')";
        $orderTransactionCustomFields = $connection->executeQuery($sql)->fetchAssociative();
        $customFields = json_decode($orderTransactionCustomFields['custom_fields'], true);
        if (!is_array($customFields) || !array_key_exists(Form::CUSTOM_FIELD_WORDLINE_PAYMENT_HOSTED_CHECKOUT_ID, $customFields)) {
            return false;
        }

        return $customFields[Form::CUSTOM_FIELD_WORDLINE_PAYMENT_HOSTED_CHECKOUT_ID];
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
            $context,
            $this->transactionStateHandler
        );
    }
}
