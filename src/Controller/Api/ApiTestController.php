<?php

/**
 * @author Mediaopt GmbH
 * @package MoptWorldline\Controller
 */

namespace MoptWorldline\Controller\Api;

use Monolog\Logger;
use MoptWorldline\Adapter\WorldlineSDKAdapter;
use MoptWorldline\Bootstrap\Form;
use MoptWorldline\MoptWorldline;
use MoptWorldline\Service\Payment;
use OnlinePayments\Sdk\Domain\GetPaymentProductsResponse;
use OnlinePayments\Sdk\Domain\PaymentProduct;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\Plugin\Util\PluginIdProvider;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Shopware\Core\System\SystemConfig\SystemConfigService;

/**
 * @RouteScope(scopes={"api"})
 */
class ApiTestController extends AbstractController
{
    private SystemConfigService $systemConfigService;
    private Logger $logger;
    private EntityRepositoryInterface $paymentMethodRepository;
    private PluginIdProvider $pluginIdProvider;

    /** @var array */
    private $credentialKeys = [
        'merchantId' => Form::MERCHANT_ID_FIELD,
        'apiSecret' => Form::API_SECRET_FIELD,
        'apiKey' => Form::API_KEY_FIELD,
        'isLiveMode' => Form::IS_LIVE_MODE_FIELD
    ];

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

    /**
     * @Route(
     *     "/api/_action/api-test/savemethod",
     *     name="api.action.test.savemethod",
     *     methods={"POST"}
     * )
     */
    public function saveMethod(Request $request, Context $context): JsonResponse
    {
        //todo split api test and payment creation
        $data = $request->request->get('data');

        //todo with salesChannelDefaultAssignments auto assign methods to channels
        $salesChannelId = $request->request->get('salesChannelId');

        $toCreate = [];
        foreach ($data as $key => $item) {
            if ($item['status']) {
                $toCreate[] = $item['id'];
            }
        }

        $adapter = new WorldlineSDKAdapter($this->systemConfigService, $this->logger);
        $adapter->getMerchantClient();
        $paymentMethods = $adapter->getPaymentMethods();
        foreach ($paymentMethods->getPaymentProducts() as $method) {
            if (in_array($method->getId(), $toCreate)) {
                $this->createPaymentMethod($method, $context);
            };
        }

        return $this->response(true, '', []);
    }

    /**
     * @Route(
     *     "/api/_action/api-test/test-connection",
     *     name="api.action.test.connection",
     *     methods={"POST"}
     * )
     */
    public function testConnection(Request $request, Context $context): JsonResponse
    {
        $configFormData = $request->request->get('сonfigData');

        if (is_null($configFormData)) {
            return $this->response(false, "There is no config data.");
        }

        $salesChannelId = $request->request->get('salesChannelId') ?: 'null';

        $credentials = $this->buildCredentials($salesChannelId, $configFormData);

        $paymentMethods = '';
        $message = '';
        try {
            $paymentMethods = $this->getPaymentMentodsList($credentials);
        } catch (\Exception $e) {
            $message = '<br/>' . $e->getMessage();
        }

        $success = empty($message);

        return $this->response($success, $message, $paymentMethods);
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
                'worldlineId' => $method->getId()
            ]
        ];
        if (empty($this->getPaymentMethodId($name))) {
            $this->paymentMethodRepository->create([$paymentData], $context);
        }
    }

    /**
     * @param $name
     * @return string|null
     */
    private function getPaymentMethodId($name): ?string
    {
        $paymentCriteria = (
        new Criteria())
            ->addFilter(new EqualsFilter('handlerIdentifier', Payment::class))
            ->addFilter(new EqualsFilter('name', $name));
        $paymentIds = $this->paymentMethodRepository->searchIds($paymentCriteria, Context::createDefaultContext());
        if ($paymentIds->getTotal() === 0) {
            return null;
        }
        return $paymentIds->getIds()[0];
    }

    /**
     * @param GetPaymentProductsResponse $paymentMethods
     * @return array
     */
    private function getPaymentMentodsList(array $credentials)
    {
        $adapter = new WorldlineSDKAdapter($this->systemConfigService, $this->logger);//No sales channel needed
        $adapter->getMerchantClient($credentials);
        $paymentMethods = $adapter->getPaymentMethods();

        $toFrontend = [];
        foreach ($paymentMethods->getPaymentProducts() as $method) {
            $name = $this->getPaymentMethodName($method->getDisplayHints()->getLabel());
            $isCreated = $this->getPaymentMethodId($name);
            if ($isCreated) {
                continue;//todo should we hide it?
            }
            $toFrontend[] = [
                'id' => $method->getId(),
                'logo' => $method->getDisplayHints()->getLogo(),
                'label' => $method->getDisplayHints()->getLabel(),
                'isCreated' => (bool)$isCreated
            ];
        }

        return $toFrontend;
    }

    /**
     * @param $label
     * @return string
     */
    private function getPaymentMethodName($label){
        return "Worldline $label";
    }

    /**
     * @param string $salesChannelId
     * @param array $configData
     * @return array
     */
    private function buildCredentials(string $salesChannelId, array $configData): array
    {
        $globalConfig = [];
        if (array_key_exists('null', $configData)) {
            $globalConfig = $configData['null'];
        }

        $credentials = [
            'isLiveMode' => false
        ];

        if (array_key_exists($salesChannelId, $configData)) {
            $channelConfig = $configData[$salesChannelId];
            foreach ($this->credentialKeys as $key => $formKey) {
                if (array_key_exists($formKey, $channelConfig) && !is_null($channelConfig[$formKey])) {
                    $credentials[$key] = $channelConfig[$formKey];
                } elseif (array_key_exists($formKey, $globalConfig) && !is_null($globalConfig[$formKey])) {
                    $credentials[$key] = $globalConfig[$formKey];
                }
            }
        }

        $credentials['isLiveMode'] = (bool)$credentials['isLiveMode'];

        return $credentials;
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
