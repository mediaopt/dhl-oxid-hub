<?php

/**
 * @author Mediaopt GmbH
 * @package MoptWorldline\Controller
 */

namespace MoptWorldline\Controller\Api;

use Monolog\Logger;
use MoptWorldline\Bootstrap\Form;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\Plugin\Util\PluginIdProvider;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use MoptWorldline\Controller\PaymentMethod\PaymentMethodController;

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

        $salesChannelId = $request->request->get('salesChannelId');

        $credentials = $this->buildCredentials($salesChannelId ?: 'null', $configFormData);

        $paymentMethods = [];
        $message = '';
        try {
            $paymentMethodController = $this->getPaymentMethodController();
            $paymentMethods = $paymentMethodController->getPaymentMentodsList($credentials, $salesChannelId);
        } catch (\Exception $e) {
            $message = '<br/>' . $e->getMessage();
        }

        $success = empty($message);

        return $this->response($success, $message, $paymentMethods);
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
        $paymentMethodController = $this->getPaymentMethodController();
        return $paymentMethodController->saveMethod($request, $context);
    }

    /**
     * @return PaymentMethodController
     */
    private function getPaymentMethodController()
    {
        return new PaymentMethodController(
            $this->systemConfigService,
            $this->logger,
            $this->paymentMethodRepository,
            $this->pluginIdProvider
        );
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
