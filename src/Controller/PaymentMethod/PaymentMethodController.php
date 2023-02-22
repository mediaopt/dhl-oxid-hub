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
use MoptWorldline\Service\PaymentMethodHelper;
use OnlinePayments\Sdk\Domain\GetPaymentProductsResponse;
use OnlinePayments\Sdk\Domain\PaymentProduct;
use Shopware\Core\Checkout\Payment\PaymentMethodEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Plugin\Util\PluginIdProvider;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class PaymentMethodController
{
    private SystemConfigService $systemConfigService;
    private Logger $logger;
    private EntityRepositoryInterface $paymentMethodRepository;
    private EntityRepositoryInterface $salesChannelPaymentRepository;
    private PluginIdProvider $pluginIdProvider;

    /**
     * @param SystemConfigService $systemConfigService
     * @param Logger $logger
     * @param EntityRepositoryInterface $paymentMethodRepository
     * @param EntityRepositoryInterface $salesChannelPaymentRepository
     * @param PluginIdProvider $pluginIdProvider
     */
    public function __construct(
        SystemConfigService       $systemConfigService,
        Logger                    $logger,
        EntityRepositoryInterface $paymentMethodRepository,
        EntityRepositoryInterface $salesChannelPaymentRepository,
        PluginIdProvider          $pluginIdProvider
    )
    {
        $this->systemConfigService = $systemConfigService;
        $this->logger = $logger;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->salesChannelPaymentRepository = $salesChannelPaymentRepository;
        $this->pluginIdProvider = $pluginIdProvider;
    }

    /**
     * @param Request $request
     * @param Context $context
     * @param ?string $countryIso3
     * @param ?string $currencyIsoCode
     * @return JsonResponse
     * @throws \Exception
     */
    public function saveMethod(Request $request, Context $context, ?string $countryIso3, ?string $currencyIsoCode): JsonResponse
    {
        $data = $request->request->get('data');
        $salesChannelId = $request->request->get('salesChannelId');

        $toCreate = [];
        foreach ($data as $paymentMethod) {
            if (!empty($paymentMethod['internalId'])) {
                //Activate/deactivate method, that already exist
                PaymentMethodHelper::setDBPaymentMethodStatus(
                    $this->paymentMethodRepository,
                    $paymentMethod['status'],
                    $context,
                    $paymentMethod['internalId']
                );
                continue;
            }

            if ($paymentMethod['status']) {
                $toCreate[] = $paymentMethod['id'];
            }
        }

        if (empty($toCreate)) {
            return $this->response();
        }
        $adapter = new WorldlineSDKAdapter($this->systemConfigService, $this->logger, $salesChannelId);
        $adapter->getMerchantClient();
        $paymentProducts = $adapter->getPaymentProducts($countryIso3, $currencyIsoCode);
        foreach ($paymentProducts->getPaymentProducts() as $product) {
            debug($product->toJson());
            $name = 'Worldline ' . $product->getDisplayHints()->getLabel();
            if (in_array($product->getId(), $toCreate)) {
                $method = [
                    'id' => $product->getId(),
                    'name' => $name,
                    'description' => '',
                    'active' => true,
                ];
                PaymentMethodHelper::addPaymentMethod(
                    $this->paymentMethodRepository,
                    $this->salesChannelPaymentRepository,
                    $this->pluginIdProvider,
                    $context,
                    $method,
                    $salesChannelId,
                    null
                );
            }
        }

        return $this->response();
    }

    /**
     * @param array $credentials
     * @param ?string $salesChannelId
     * @param ?string $countryIso3
     * @param ?string $currencyIsoCode
     * @return array
     * @throws \Exception
     */
    public function getPaymentMethodsList(
        array $credentials,
        ?string $salesChannelId,
        ?string $countryIso3,
        ?string $currencyIsoCode
    ): array
    {
        $toFrontend = [];
        foreach (Payment::METHODS_LIST as $method) {
            $dbMethod = PaymentMethodHelper::getPaymentMethod($this->paymentMethodRepository, $method['id']);
            $toFrontend[] = [
                'id' => $method['id'],
                'logo' => '',
                'label' => $dbMethod['label'],
                'isActive' => $dbMethod['isActive'],
                'internalId' => $dbMethod['internalId']
            ];
        }

        $adapter = new WorldlineSDKAdapter($this->systemConfigService, $this->logger, $salesChannelId);
        $adapter->getMerchantClient($credentials);

        if (is_null($salesChannelId)) {
            $adapter->testConnection();
            return $toFrontend;
        }

        $paymentProducts = $adapter->getPaymentProducts($countryIso3, $currencyIsoCode);
        foreach ($paymentProducts->getPaymentProducts() as $product) {
            $createdPaymentMethod = PaymentMethodHelper::getPaymentMethod($this->paymentMethodRepository, $product->getId());

            $toFrontend[] = [
                'id' => $product->getId(),
                'logo' => $product->getDisplayHints()->getLogo(),
                'label' => $createdPaymentMethod['label'] ? : $product->getDisplayHints()->getLabel(),
                'isActive' => $createdPaymentMethod['isActive'],
                'internalId' => $createdPaymentMethod['internalId']
            ];
        };
        return $toFrontend;
    }

    /**
     * @param bool $success
     * @param string $message
     * @param $paymentMethods
     * @return JsonResponse
     */
    private function response(bool $success = true, string $message = '', $paymentMethods = []): JsonResponse
    {
        return new JsonResponse([
            'success' => $success,
            'message' => $message,
            'paymentMethods' => $paymentMethods,
        ]);
    }
}
