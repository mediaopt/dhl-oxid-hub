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
class ResponseItemNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ResponseItem';
    }
    public function supportsNormalization($data, $format = null) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ResponseItem';
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
        $object = new \Mediaopt\DHL\Api\ParcelShipping\Model\ResponseItem();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('shipmentNo', $data)) {
            $object->setShipmentNo($data['shipmentNo']);
            unset($data['shipmentNo']);
        }
        if (\array_key_exists('returnShipmentNo', $data)) {
            $object->setReturnShipmentNo($data['returnShipmentNo']);
            unset($data['returnShipmentNo']);
        }
        if (\array_key_exists('sstatus', $data)) {
            $object->setSstatus($this->denormalizer->denormalize($data['sstatus'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\JSONStatus', 'json', $context));
            unset($data['sstatus']);
        }
        if (\array_key_exists('shipmentRefNo', $data)) {
            $object->setShipmentRefNo($data['shipmentRefNo']);
            unset($data['shipmentRefNo']);
        }
        if (\array_key_exists('label', $data)) {
            $object->setLabel($this->denormalizer->denormalize($data['label'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Document', 'json', $context));
            unset($data['label']);
        }
        if (\array_key_exists('returnLabel', $data)) {
            $object->setReturnLabel($this->denormalizer->denormalize($data['returnLabel'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Document', 'json', $context));
            unset($data['returnLabel']);
        }
        if (\array_key_exists('customsDoc', $data)) {
            $object->setCustomsDoc($this->denormalizer->denormalize($data['customsDoc'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Document', 'json', $context));
            unset($data['customsDoc']);
        }
        if (\array_key_exists('codLabel', $data)) {
            $object->setCodLabel($this->denormalizer->denormalize($data['codLabel'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Document', 'json', $context));
            unset($data['codLabel']);
        }
        if (\array_key_exists('validationMessages', $data)) {
            $values = array();
            foreach ($data['validationMessages'] as $value) {
                $values[] = $this->denormalizer->denormalize($value, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ValidationMessageItem', 'json', $context);
            }
            $object->setValidationMessages($values);
            unset($data['validationMessages']);
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
        if ($object->isInitialized('shipmentNo') && null !== $object->getShipmentNo()) {
            $data['shipmentNo'] = $object->getShipmentNo();
        }
        if ($object->isInitialized('returnShipmentNo') && null !== $object->getReturnShipmentNo()) {
            $data['returnShipmentNo'] = $object->getReturnShipmentNo();
        }
        $data['sstatus'] = $this->normalizer->normalize($object->getSstatus(), 'json', $context);
        if ($object->isInitialized('shipmentRefNo') && null !== $object->getShipmentRefNo()) {
            $data['shipmentRefNo'] = $object->getShipmentRefNo();
        }
        if ($object->isInitialized('label') && null !== $object->getLabel()) {
            $data['label'] = $this->normalizer->normalize($object->getLabel(), 'json', $context);
        }
        if ($object->isInitialized('returnLabel') && null !== $object->getReturnLabel()) {
            $data['returnLabel'] = $this->normalizer->normalize($object->getReturnLabel(), 'json', $context);
        }
        if ($object->isInitialized('customsDoc') && null !== $object->getCustomsDoc()) {
            $data['customsDoc'] = $this->normalizer->normalize($object->getCustomsDoc(), 'json', $context);
        }
        if ($object->isInitialized('codLabel') && null !== $object->getCodLabel()) {
            $data['codLabel'] = $this->normalizer->normalize($object->getCodLabel(), 'json', $context);
        }
        if ($object->isInitialized('validationMessages') && null !== $object->getValidationMessages()) {
            $values = array();
            foreach ($object->getValidationMessages() as $value) {
                $values[] = $this->normalizer->normalize($value, 'json', $context);
            }
            $data['validationMessages'] = $values;
        }
        foreach ($object as $key => $value_1) {
            if (preg_match('/.*/', (string) $key)) {
                $data[$key] = $value_1;
            }
        }
        return $data;
    }
}