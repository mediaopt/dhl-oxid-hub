<?php

/**
 * @author Mediaopt GmbH
 * @package MoptWordline\Controller
 */

namespace MoptWordline\Controller\Api;

use Monolog\Logger;
use MoptWordline\Adapter\WordlineSDKAdapter;
use MoptWordline\Bootstrap\Form;
use Shopware\Core\Framework\Context;
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
     */
    public function __construct(SystemConfigService $systemConfigService, Logger $logger)
    {
        $this->systemConfigService = $systemConfigService;
        $this->logger = $logger;
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

        $credentials = $this->buildCredentialsFromRequest($salesChannelId, $configFormData);
        $paymentMethods = [];
        $message = '';
        try {
            $adapter = new WordlineSDKAdapter($this->systemConfigService, $this->logger);//No sales channel needed
            $adapter->getMerchantClient($credentials);
            $paymentMethods = $adapter->getPaymentMethods()->toObject();
        } catch (\Exception $e) {
            $message = '<br/>' . $e->getMessage();
        }

        $success = empty($message);

        return $this->response($success, $message, $paymentMethods);
    }

    /**
     * @param string $salesChannelId
     * @param array $configData
     * @return array
     */
    private function buildCredentialsFromRequest(string $salesChannelId, array $configData): array
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
    private function response(bool $success, string $message, $pay = null): JsonResponse
    {
        return new JsonResponse([
            'success' => $success,
            'message' => $message,
            '123' => $pay
        ]);
    }
}
