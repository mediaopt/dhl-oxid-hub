<?php

namespace MoptWordline\Adapter;

use Monolog\Logger;
use OnlinePayments\Sdk\Merchant\MerchantClient;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use MoptWordline\Bootstrap\Form;
use OnlinePayments\Sdk\DefaultConnection;
use OnlinePayments\Sdk\CommunicatorConfiguration;
use OnlinePayments\Sdk\Communicator;
use OnlinePayments\Sdk\Client;
use OnlinePayments\Sdk\Merchant\Products\GetPaymentProductsParams;
use OnlinePayments\Sdk\Domain\GetPaymentProductsResponse;

/**
 * This is the adaptor for Wordline's API
 *
 * @author Mediaopt GmbH
 * @package MoptWordline\Adapter
 */
class WordlineSDKAdapter
{
    /** @var string */
    const INTEGRATOR_NAME = 'Mediaopt';

    /** @var MerchantClient */
    protected $merchantClient;

    /** @var SystemConfigService */
    private $systemConfigService;

    /** @var Logger */
    private $logger;

    /** @var string|null */
    private $salesChannelId;

    /**
     * @param SystemConfigService $systemConfigService
     * @param Logger $logger
     * @param string|null $salesChannelId
     */
    public function __construct(SystemConfigService $systemConfigService, Logger $logger, $salesChannelId = null)
    {
        $this->systemConfigService = $systemConfigService;
        $this->logger = $logger;
        $this->salesChannelId = $salesChannelId;
    }

    /**
     * @param array $credentials
     * @return MerchantClient
     * @throws \Exception
     */
    public function getMerchantClient(array $credentials = []): MerchantClient
    {
        if ($this->merchantClient !== null) {
            return $this->merchantClient;
        }

        if (empty($credentials)) {
            $credentials = [
                'merchantId' => $this->getPluginConfig(Form::MERCHANT_ID_FIELD),
                'apiKey' => $this->getPluginConfig(Form::API_KEY_FIELD),
                'apiSecret' => $this->getPluginConfig(Form::API_SECRET_FIELD),
                'isLiveMode' => (bool)$this->getPluginConfig(Form::IS_LIVE_MODE_FIELD),
            ];
        }
        $credentials['endpoint'] = $this->getEndpoint($credentials['isLiveMode']);

        $communicatorConfiguration = new CommunicatorConfiguration(
            $credentials['apiKey'],
            $credentials['apiSecret'],
            $credentials['endpoint'],
            self::INTEGRATOR_NAME,
            null
        );

        $connection = new DefaultConnection();
        $communicator = new Communicator($connection, $communicatorConfiguration);
        $client = new Client($communicator);
        $this->merchantClient = $client->merchant($credentials['merchantId']);

        return $this->merchantClient;
    }

    /**
     * @return GetPaymentProductsResponse
     * @throws \Exception
     */
    public function getPaymentMethods(): GetPaymentProductsResponse
    {
        $queryParams = new GetPaymentProductsParams();

        //todo take this from client settings
        $queryParams->setCountryCode("DE");
        $queryParams->setCurrencyCode("EUR");

        $paymentProductsResponse = $this->merchantClient
            ->products()
            ->getPaymentProducts($queryParams);

        return $paymentProductsResponse;
    }

    /**
     * @param bool $isLiveMode
     * @return string
     */
    private function getEndpoint(bool $isLiveMode): string
    {
        return $isLiveMode
            ? $this->getPluginConfig(Form::LIVE_ENDPOINT_FIELD)
            : $this->getPluginConfig(Form::SANDBOX_ENDPOINT_FIELD);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getPluginConfig($key)
    {
        return $this->systemConfigService->get($key, $this->salesChannelId);
    }
}
