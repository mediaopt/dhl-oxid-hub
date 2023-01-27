<?php declare(strict_types=1);

namespace MoptWorldline\Controller\Payment;

use Monolog\Logger;
use MoptWorldline\Adapter\WorldlineSDKAdapter;
use MoptWorldline\Bootstrap\Form;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @RouteScope(scopes={"storefront"})
 */
class IframeController extends AbstractController
{
    public SystemConfigService $systemConfigService;
    private Logger $logger;
    private Session $session;

    public function __construct(
        SystemConfigService $systemConfigService,
        Logger              $logger,
        Session             $session
    )
    {
        $this->systemConfigService = $systemConfigService;
        $this->logger = $logger;
        $this->session = $session;
    }

    /**
     * @Route("/worldline_iframe", name="worldline.iframe", defaults={"XmlHttpRequest"=true}, methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function showIframe(Request $request): JsonResponse
    {
        debug('show Iframe');
        $salesChannelId = $request->get('salesChannelId');
        $token = $this->session->get(Form::CUSTOM_FIELD_WORLDLINE_CUSTOMER_SAVED_PAYMENT_CARD_TOKEN);
        $adapter = new WorldlineSDKAdapter($this->systemConfigService, $this->logger, $salesChannelId);
        $tokenizationUrl = $adapter->createHostedTokenizationUrl($token);

        return new JsonResponse([
            'url' => $tokenizationUrl
        ]);
    }

    /**
     * @Route("/worldline_cardToken", name="worldline.cardToken", defaults={"XmlHttpRequest"=true}, methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function saveCardToken(Request $request)
    {
        $token = $request->get('worldline_cardToken') ?: null;
        $this->session->set(Form::CUSTOM_FIELD_WORLDLINE_CUSTOMER_SAVED_PAYMENT_CARD_TOKEN, $token);
        return new JsonResponse([]);
    }

}
