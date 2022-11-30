<?php declare(strict_types=1);

namespace MoptWorldline\Controller\Payment;

use Monolog\Logger;
use MoptWorldline\Adapter\WorldlineSDKAdapter;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;

/**
 * @RouteScope(scopes={"storefront"})
 */
class IframeController extends AbstractController
{
    public SystemConfigService $systemConfigService;
    private Logger $logger;

    public function __construct(
        SystemConfigService $systemConfigService,
        Logger              $logger
    )
    {
        $this->systemConfigService = $systemConfigService;
        $this->logger = $logger;
    }

    /**
     * @Route("/worldline_iframe", name="worldline.iframe", defaults={"XmlHttpRequest"=true}, methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function showIframe(Request $request): JsonResponse
    {
        $salesChannelId = $request->get('salesChannelId');
        $adapter = new WorldlineSDKAdapter($this->systemConfigService, $this->logger, $salesChannelId);
        $tokenizationUrl = $adapter->createHostedTokenizationUrl();

        return new JsonResponse([
            'url' => $tokenizationUrl
        ]);
    }
}
