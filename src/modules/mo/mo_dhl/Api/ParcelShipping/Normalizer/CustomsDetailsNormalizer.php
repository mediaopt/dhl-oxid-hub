<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Normalizer;

use Jane\Component\JsonSchemaRuntime\Reference;
use Mediaopt\DHL\Api\ParcelShipping\Runtime\Normalizer\CheckArray;
use Mediaopt\DHL\Api\ParcelShipping\Runtime\Normalizer\ValidatorTrait;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
class CustomsDetailsNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null, array $context = array()) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\CustomsDetails';
    }
    public function supportsNormalization($data, $format = null, array $context = array()) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\CustomsDetails';
    }
    /**
     * @return mixed
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (isset($data['$ref'])) {
            return new Reference($data['$ref'], $context['document-origin']);
        }
        if (isset($data['$recursiveRef'])) {
            return new Reference($data['$recursiveRef'], $context['document-origin']);
        }
        $object = new \Mediaopt\DHL\Api\ParcelShipping\Model\CustomsDetails();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('invoiceNo', $data)) {
            $object->setInvoiceNo($data['invoiceNo']);
            unset($data['invoiceNo']);
        }
        if (\array_key_exists('exportType', $data)) {
            $object->setExportType($data['exportType']);
            unset($data['exportType']);
        }
        if (\array_key_exists('exportDescription', $data)) {
            $object->setExportDescription($data['exportDescription']);
            unset($data['exportDescription']);
        }
        if (\array_key_exists('shippingConditions', $data)) {
            $object->setShippingConditions($data['shippingConditions']);
            unset($data['shippingConditions']);
        }
        if (\array_key_exists('permitNo', $data)) {
            $object->setPermitNo($data['permitNo']);
            unset($data['permitNo']);
        }
        if (\array_key_exists('attestationNo', $data)) {
            $object->setAttestationNo($data['attestationNo']);
            unset($data['attestationNo']);
        }
        if (\array_key_exists('hasElectronicExportNotification', $data)) {
            $object->setHasElectronicExportNotification($data['hasElectronicExportNotification']);
            unset($data['hasElectronicExportNotification']);
        }
        if (\array_key_exists('MRN', $data)) {
            $object->setMRN($data['MRN']);
            unset($data['MRN']);
        }
        if (\array_key_exists('postalCharges', $data)) {
            $object->setPostalCharges($this->denormalizer->denormalize($data['postalCharges'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\CustomsDetailsPostalCharges', 'json', $context));
            unset($data['postalCharges']);
        }
        if (\array_key_exists('officeOfOrigin', $data)) {
            $object->setOfficeOfOrigin($data['officeOfOrigin']);
            unset($data['officeOfOrigin']);
        }
        if (\array_key_exists('shipperCustomsRef', $data)) {
            $object->setShipperCustomsRef($data['shipperCustomsRef']);
            unset($data['shipperCustomsRef']);
        }
        if (\array_key_exists('consigneeCustomsRef', $data)) {
            $object->setConsigneeCustomsRef($data['consigneeCustomsRef']);
            unset($data['consigneeCustomsRef']);
        }
        if (\array_key_exists('items', $data)) {
            $values = array();
            foreach ($data['items'] as $value) {
                $values[] = $this->denormalizer->denormalize($value, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Commodity', 'json', $context);
            }
            $object->setItems($values);
            unset($data['items']);
        }
        foreach ($data as $key => $value_1) {
            if (preg_match('/.*/', (string) $key)) {
                $object[$key] = $value_1;
            }
        }
        return $object;
    }
    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $data = array();
        if ($object->isInitialized('invoiceNo') && null !== $object->getInvoiceNo()) {
            $data['invoiceNo'] = $object->getInvoiceNo();
        }
        $data['exportType'] = $object->getExportType();
        if ($object->isInitialized('exportDescription') && null !== $object->getExportDescription()) {
            $data['exportDescription'] = $object->getExportDescription();
        }
        if ($object->isInitialized('shippingConditions') && null !== $object->getShippingConditions()) {
            $data['shippingConditions'] = $object->getShippingConditions();
        }
        if ($object->isInitialized('permitNo') && null !== $object->getPermitNo()) {
            $data['permitNo'] = $object->getPermitNo();
        }
        if ($object->isInitialized('attestationNo') && null !== $object->getAttestationNo()) {
            $data['attestationNo'] = $object->getAttestationNo();
        }
        if ($object->isInitialized('hasElectronicExportNotification') && null !== $object->getHasElectronicExportNotification()) {
            $data['hasElectronicExportNotification'] = $object->getHasElectronicExportNotification();
        }
        if ($object->isInitialized('mRN') && null !== $object->getMRN()) {
            $data['MRN'] = $object->getMRN();
        }
        $data['postalCharges'] = $this->normalizer->normalize($object->getPostalCharges(), 'json', $context);
        if ($object->isInitialized('officeOfOrigin') && null !== $object->getOfficeOfOrigin()) {
            $data['officeOfOrigin'] = $object->getOfficeOfOrigin();
        }
        if ($object->isInitialized('shipperCustomsRef') && null !== $object->getShipperCustomsRef()) {
            $data['shipperCustomsRef'] = $object->getShipperCustomsRef();
        }
        if ($object->isInitialized('consigneeCustomsRef') && null !== $object->getConsigneeCustomsRef()) {
            $data['consigneeCustomsRef'] = $object->getConsigneeCustomsRef();
        }
        $values = array();
        foreach ($object->getItems() as $value) {
            $values[] = $this->normalizer->normalize($value, 'json', $context);
        }
        $data['items'] = $values;
        foreach ($object as $key => $value_1) {
            if (preg_match('/.*/', (string) $key)) {
                $data[$key] = $value_1;
            }
        }
        return $data;
    }
    public function getSupportedTypes(?string $format = null) : array
    {
        return array('Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\CustomsDetails' => false);
    }
}