<?php declare(strict_types=1);

namespace MoptWorldline\Controller\Payment;

use Monolog\Logger;
use MoptWorldline\Adapter\WorldlineSDKAdapter;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     */
    public function showIframe(): JsonResponse
    {
        $salesChannelId = '7634c1690d29463bbb97b81dd4643834'; //todo get it from frontend POST call
        $adapter = new WorldlineSDKAdapter($this->systemConfigService, $this->logger, $salesChannelId);
        $partUrl = $adapter->createHostedTokenizationRequest(); //todo add some data from page
        $fullUrl = 'https://payment.' . $partUrl;
        $form = "<iframe src='$fullUrl' title='description'></iframe>";

        return new JsonResponse([
            'form' => $form
        ]);
    }
}
