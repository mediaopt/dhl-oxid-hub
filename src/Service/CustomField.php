<?php declare(strict_types=1);

namespace MoptWordline\Service;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsAnyFilter;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\CustomField\CustomFieldTypes;
use Symfony\Component\DependencyInjection\ContainerInterface;
use MoptWordline\Bootstrap\Form;

class CustomField
{
    private ContainerInterface $container;

    /**
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @param InstallContext $installContext
     * @return void
     */
    public function addCustomFields(InstallContext $installContext)
    {
        $fieldIds = $this->customFieldsExist($installContext->getContext());

        if ($fieldIds) {
            return;
        }

        $customFieldSetRepository = $this->container->get('custom_field_set.repository');
        $customFieldSetRepository->upsert([
            $this->getShippingTaxCodeFieldset(),
        ], $installContext->getContext());
    }

    /**
     * todo - should we save order transaction id after uninstall?
     * for now - not used
     * @param UninstallContext $uninstallContext
     * @return void
     */
    public function removeCustomField(UninstallContext $uninstallContext)
    {
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');

        $fieldIds = $this->customFieldsExist($uninstallContext->getContext());

        if ($fieldIds) {
            $customFieldSetRepository->delete(array_values($fieldIds->getData()), $uninstallContext->getContext());
        }
    }

    /**
     * @param Context $context
     * @return mixed
     */
    public function customFieldsExist(Context $context)
    {
        $customFieldSetRepository = $this->container->get('custom_field_set.repository');

        $criteria = new Criteria();
        $criteria->addFilter(new EqualsAnyFilter(
            'name',
            [
                Form::CUSTOM_FIELD_WORDLINE_PAYMENT_TRANSACTION_ID_FIELDSET,
            ]
        ));

        $ids = $customFieldSetRepository->searchIds($criteria, $context);

        return $ids->getTotal() > 0 ? $ids : null;
    }

    /**
     * @return array
     */
    private function getShippingTaxCodeFieldset(): array
    {
        return [
            'id' => Uuid::randomHex(),
            'name' => Form::CUSTOM_FIELD_WORDLINE_PAYMENT_TRANSACTION_ID_FIELDSET,
            'config' => [
                'label' => [
                    'de-DE' => 'Zahlungstransaktions-ID',
                    'en-GB' => 'Payment transaction ID'
                ]
            ],
            'customFields' => [
                [
                    'id' => Uuid::randomHex(),
                    'name' => Form::CUSTOM_FIELD_WORDLINE_PAYMENT_TRANSACTION_ID,
                    'type' => CustomFieldTypes::TEXT,
                ]
            ],
            'relations' => [
                [
                    'id' => Uuid::randomHex(),
                    'entityName' => 'order'
                ]
            ]
        ];
    }
}
