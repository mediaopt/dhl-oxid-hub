<?php declare(strict_types=1);

namespace MoptWorldline\Controller\Payment;

use _PHPStan_b8e553790\Nette\Neon\Exception;
use Monolog\Logger;
use MoptWorldline\Adapter\WorldlineSDKAdapter;
use MoptWorldline\Bootstrap\Form;
use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\Routing\Exception\MissingRequestParameterException;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Symfony\Component\HttpFoundation\Session\Session;
use Shopware\Core\Framework\Routing\Annotation\LoginRequired;

/**
 * @RouteScope(scopes={"storefront"})
 */
class IframeController extends AbstractController
{
    public SystemConfigService $systemConfigService;
    private Logger $logger;
    private Session $session;
    private EntityRepositoryInterface $customerRepository;

    public function __construct(
        SystemConfigService       $systemConfigService,
        Logger                    $logger,
        Session                   $session,
        EntityRepositoryInterface $customerRepository
    )
    {
        $this->systemConfigService = $systemConfigService;
        $this->logger = $logger;
        $this->session = $session;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @Route("/worldline_iframe", name="worldline.iframe", defaults={"XmlHttpRequest"=true}, methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function showIframe(Request $request): JsonResponse
    {
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

    /**
     * @LoginRequired()
     * @Route("/worldline/card/delete/{tokenId}", name="worldline.card.delete", options={"seo"="false"}, methods={"POST"})
     *
     * @param string $tokenId
     * @param SalesChannelContext $context
     * @param CustomerEntity $customer
     * @return RedirectResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function deleteCard(string $tokenId, SalesChannelContext $context, CustomerEntity $customer): RedirectResponse
    {
        $success = true;
        if (!$tokenId) {
            throw new MissingRequestParameterException('tokenId');
        }

        try {
            $fields = $this->prepareCustomField($tokenId, $customer);
            $this->customerRepository->update([
                [
                    'id' => $customer->getId(),
                    'customFields' => $fields
                ]
            ], $context->getContext());

        } catch (\Exception $exception) {
            $success = false;
        }

        return new RedirectResponse(
            $this->container->get('router')
                ->generate('frontend.account.payment.page', ['cardDeleted' => $success])
        );
    }

    /**
     * @param string $tokenId
     * @param CustomerEntity $customer
     * @return mixed
     * @throws Exception
     */
    private function prepareCustomField(string $tokenId, CustomerEntity $customer)
    {
        $key = Form::CUSTOM_FIELD_WORLDLINE_CUSTOMER_SAVED_PAYMENT_CARD_TOKEN;

        if (!$customerCustomFields = $customer->getCustomFields()) {
            throw new Exception('No custom fields');
        }

        if (!array_key_exists($key, $customerCustomFields)) {
            throw new Exception('No saved cards');
        }

        $savedCards = $customerCustomFields[$key];
        if (!array_key_exists($tokenId, $savedCards)) {
            throw new Exception("Can not find saved card with token $tokenId");
        }

        $wasDefault = $savedCards[$tokenId]['default'];
        unset($savedCards[$tokenId]);

        if ($wasDefault && !empty($savedCards)) {
            $savedCards[key($savedCards)]['default'] = true;
        }
        $this->session->set(Form::CUSTOM_FIELD_WORLDLINE_CUSTOMER_SAVED_PAYMENT_CARD_TOKEN, null);
        $customerCustomFields[$key] = $savedCards;
        return $customerCustomFields;
    }
}
