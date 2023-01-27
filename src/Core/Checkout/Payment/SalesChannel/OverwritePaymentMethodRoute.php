<?php declare(strict_types=1);

namespace MoptWorldline\Core\Checkout\Payment\SalesChannel;

use MoptWorldline\Bootstrap\Form;
use MoptWorldline\MoptWorldline;
use Shopware\Core\Checkout\Payment\PaymentMethodCollection;
use Shopware\Core\Checkout\Payment\PaymentMethodEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;
use Shopware\Core\Framework\Plugin\Exception\DecorationPatternException;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\Entity\SalesChannelRepositoryInterface;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;
use Shopware\Core\Checkout\Payment\SalesChannel\PaymentMethodRouteResponse;
use Shopware\Core\Checkout\Payment\SalesChannel\PaymentMethodRoute;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @RouteScope(scopes={"store-api"})
 */
class OverwritePaymentMethodRoute extends PaymentMethodRoute
{
    private SalesChannelRepositoryInterface $paymentMethodsRepository;
    private Session $session;

    /**
     * @param SalesChannelRepositoryInterface $paymentMethodsRepository
     * @param Session $session
     */
    public function __construct(SalesChannelRepositoryInterface $paymentMethodsRepository, Session $session)
    {
        parent::__construct($paymentMethodsRepository);
        $this->paymentMethodsRepository = $paymentMethodsRepository;
        $this->session = $session;
    }

    /**
     * @return PaymentMethodRoute
     */
    public function getDecorated(): PaymentMethodRoute
    {
        throw new DecorationPatternException(self::class);
    }

    /**
     * @param Request $request
     * @param SalesChannelContext $context
     * @param Criteria $criteria
     * @return PaymentMethodRouteResponse
     */
    public function load(Request $request, SalesChannelContext $context, Criteria $criteria): PaymentMethodRouteResponse
    {
        $selectedPaymentMethodId = $context->getPaymentMethod()->getId();
        $criteria
            ->addFilter(new EqualsFilter('active', true))
            ->addSorting(new FieldSorting('position'))
            ->addAssociation('media');

        $result = $this->paymentMethodsRepository->search($criteria, $context);

        /** @var PaymentMethodCollection $paymentMethods */
        $paymentMethods = $result->getEntities();

        if ($request->query->getBoolean('onlyAvailable')) {
            $paymentMethods = $paymentMethods->filterByActiveRules($context);
        }

        /** @var PaymentMethodEntity $method */
        foreach ($paymentMethods as $key => $method) {
            if ($method->getName() === MoptWorldline::SAVED_CARD_PAYMENT_METHOD_NAME) {
                $savedCardMethod = clone $method;
                $paymentMethods->remove($key);
                continue;
            }
            if ($method->getId() == $selectedPaymentMethodId) {
                $method->setCustomFields(['selected' => 1]);
            }
        }

        if (isset($savedCardMethod)) {
            if ($savedCardsMethods = $this->getSavedPaymentMethods($context, $savedCardMethod)) {
                $savedCardsMethods->merge($paymentMethods);
                $paymentMethods = $savedCardsMethods;
            }
        }

        return $this->buildResponse($result, $paymentMethods);
    }

    /**
     * @param EntitySearchResult $result
     * @param PaymentMethodCollection $methods
     * @return PaymentMethodRouteResponse
     */
    private function buildResponse(EntitySearchResult &$result, PaymentMethodCollection $methods): PaymentMethodRouteResponse
    {
        $result->assign(['entities' => $methods, 'elements' => $methods, 'total' => $methods->count()]);
        return new PaymentMethodRouteResponse($result);
    }

    /**
     * @param SalesChannelContext $context
     * @param PaymentMethodEntity $savedCardMethod
     * @return PaymentMethodCollection|null
     */
    private function getSavedPaymentMethods(SalesChannelContext $context, PaymentMethodEntity $savedCardMethod): ?PaymentMethodCollection
    {
        $customer = $context->getCustomer();
        if (is_null($customer) || !$customerCustomFields = $customer->getCustomFields()) {
            return null;
        }

        if (!array_key_exists(Form::CUSTOM_FIELD_WORLDLINE_CUSTOMER_SAVED_PAYMENT_CARD_TOKEN, $customerCustomFields)) {
            return null;
        }

        $savedCards = $customerCustomFields[Form::CUSTOM_FIELD_WORLDLINE_CUSTOMER_SAVED_PAYMENT_CARD_TOKEN];
        $sessionToken = $this->session->get(Form::CUSTOM_FIELD_WORLDLINE_CUSTOMER_SAVED_PAYMENT_CARD_TOKEN);

        $savedCardsMethods = new PaymentMethodCollection();

        foreach ($savedCards as $savedCard) {
            debug($savedCard);
            $newMethod = clone $savedCardMethod;
            $newMethod->setTranslated([
                'name' => "Pay with my previously saved card {$savedCard['paymentCard']} {$savedCard['title']}"
            ]);
            $customFields = [
                'token' => $savedCard['token']
            ];
            if ($sessionToken === $savedCard['token']) {
                $customFields['selected'] = 1;
            }
            $newMethod->setCustomFields($customFields);
            $newMethod->setUniqueIdentifier(md5($savedCard['token']));

            $savedCardsMethods->add($newMethod);
        }

        return $savedCardsMethods;
    }
}
