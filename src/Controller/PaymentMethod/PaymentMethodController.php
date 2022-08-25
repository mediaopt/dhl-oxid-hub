<?php

/**
 * @author Mediaopt GmbH
 * @package MoptWorldline\Controller
 */

namespace MoptWorldline\Controller\PaymentMethod;

use Monolog\Logger;
use MoptWorldline\Adapter\WorldlineSDKAdapter;
use MoptWorldline\Bootstrap\Form;
use MoptWorldline\MoptWorldline;
use MoptWorldline\Service\Payment;
use OnlinePayments\Sdk\Domain\GetPaymentProductsResponse;
use OnlinePayments\Sdk\Domain\PaymentProduct;
use Shopware\Core\Checkout\Payment\PaymentMethodEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Plugin\Util\PluginIdProvider;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class PaymentMethodController
{
    private SystemConfigService $systemConfigService;
    private Logger $logger;
    private EntityRepositoryInterface $paymentMethodRepository;
    private PluginIdProvider $pluginIdProvider;

    /**
     * @param SystemConfigService $systemConfigService
     * @param Logger $logger
     * @param EntityRepositoryInterface $paymentMethodRepository
     * @param PluginIdProvider $pluginIdProvider
     */
    public function __construct(
        SystemConfigService       $systemConfigService,
        Logger                    $logger,
        EntityRepositoryInterface $paymentMethodRepository,
        PluginIdProvider          $pluginIdProvider
    )
    {
        $this->systemConfigService = $systemConfigService;
        $this->logger = $logger;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->pluginIdProvider = $pluginIdProvider;
    }

    public function saveMethod(Request $request, Context $context): JsonResponse
    {
        $data = $request->request->get('data');

        //todo with salesChannelDefaultAssignments auto assign methods to channels
        $salesChannelId = $request->request->get('salesChannelId');

        $toCreate = [];
        foreach ($data as $paymentMethod) {
            if (!empty($paymentMethod['internalId'])) {
                //Activate/deactivate method, that already exist
                $this->processPaymentMethod($paymentMethod);
                continue;
            }

            if ($paymentMethod['status']) {
                $toCreate[] = $paymentMethod['id'];
            }
        }

        if (empty($toCreate)) {
            return $this->response(true, '', []);
        }
        $adapter = new WorldlineSDKAdapter($this->systemConfigService, $this->logger);
        $adapter->getMerchantClient();
        $paymentMethods = $adapter->getPaymentMethods();
        foreach ($paymentMethods->getPaymentProducts() as $method) {
            if (in_array($method->getId(), $toCreate)) {
                $this->createPaymentMethod($method, $context);
            }
        }

        return $this->response(true, '', []);
    }

    /**
     * @param array $credentials
     * @param $salesChannelId
     * @return array
     * @throws \Exception
     */
    public function getPaymentMentodsList(array $credentials, $salesChannelId)
    {
        $fullRedirectMethod = $this->getPaymentMethod('Worldline');
        $toFrontend[] = [
            'id' => 0,
            'logo' => '',
            'label' => 'Worldline full redirect',
            'isActive' => $fullRedirectMethod['isActive'],
            'internalId' => $fullRedirectMethod['internalId']
        ];

        if (is_null($salesChannelId)) {
            return $toFrontend;
        }

        $adapter = new WorldlineSDKAdapter($this->systemConfigService, $this->logger, $salesChannelId);
        $adapter->getMerchantClient($credentials);
        $paymentMethods = $adapter->getPaymentMethods();

        foreach ($paymentMethods->getPaymentProducts() as $method) {
            $name = $this->getPaymentMethodName($method->getDisplayHints()->getLabel());
            $createdPaymentMethod = $this->getPaymentMethod($name);

            $toFrontend[] = [
                'id' => $method->getId(),
                'logo' => $method->getDisplayHints()->getLogo(),
                'label' => $method->getDisplayHints()->getLabel(),
                'isActive' => $createdPaymentMethod['isActive'],
                'internalId' => $createdPaymentMethod['internalId']
            ];
        };
        return $toFrontend;
    }

    /**
     * @param PaymentProduct $method
     * @param $context
     * @return void
     */
    private function createPaymentMethod(PaymentProduct $method, $context)
    {
        $pluginId = $this->pluginIdProvider->getPluginIdByBaseClass(MoptWorldline::class, $context);

        $name = $this->getPaymentMethodName($method->getDisplayHints()->getLabel());
        $paymentData = [
            'handlerIdentifier' => Payment::class,
            'name' => $name,
            'pluginId' => $pluginId,
            'active' => true,
            'afterOrderEnabled' => true,
            'customFields' => [
                Form::CUSTOM_FIELD_WORLDLINE_PAYMENT_METHOD_ID => $method->getId()
            ]
        ];
        if (empty($this->getPaymentMethod($name))) {
            $this->paymentMethodRepository->create([$paymentData], $context);
        }
    }

    /**
     * @param $paymentMethod
     * @return void
     */
    private function processPaymentMethod($paymentMethod)
    {
        $data = [
            'id' => $paymentMethod['internalId'],
            'active' => $paymentMethod['status']
        ];
        $this->paymentMethodRepository->update([$data], Context::createDefaultContext());
    }

    /**
     * @param $name
     * @return array
     */
    private function getPaymentMethod($name): array
    {
        $paymentCriteria = (
        new Criteria())
            ->addFilter(new EqualsFilter('handlerIdentifier', Payment::class))
            ->addFilter(new EqualsFilter('name', $name));
        $payments = $this->paymentMethodRepository->search($paymentCriteria, Context::createDefaultContext());

        /** @var PaymentMethodEntity $payment */
        foreach ($payments as $payment) {
            return [
                'internalId' => $payment->getId(),
                'isActive' => $payment->getActive()
            ];
        }

        return [
            'internalId' => '',
            'isActive' => false
        ];
    }

    /**
     * @param $label
     * @return string
     */
    private function getPaymentMethodName($label)
    {
        return "Worldline $label";
    }

    /**
     * @param bool $success
     * @param string $message
     * @return JsonResponse
     */
    private function response(bool $success, string $message, $paymentMethods = []): JsonResponse
    {
        return new JsonResponse([
            'success' => $success,
            'message' => $message,
            'paymentMethods' => $paymentMethods,
        ]);
    }
}
