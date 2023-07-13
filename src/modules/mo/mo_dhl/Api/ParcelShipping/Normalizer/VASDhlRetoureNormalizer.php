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
class VASDhlRetoureNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VASDhlRetoure';
    }
    public function supportsNormalization($data, $format = null) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VASDhlRetoure';
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
        $object = new \Mediaopt\DHL\Api\ParcelShipping\Model\VASDhlRetoure();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('billingNumber', $data)) {
            $object->setBillingNumber($data['billingNumber']);
            unset($data['billingNumber']);
        }
        if (\array_key_exists('refNo', $data)) {
            $object->setRefNo($data['refNo']);
            unset($data['refNo']);
        }
        if (\array_key_exists('returnAddress', $data)) {
            $object->setReturnAddress($this->denormalizer->denormalize($data['returnAddress'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ContactAddress', 'json', $context));
            unset($data['returnAddress']);
        }
        foreach ($data as $key => $value) {
            if (preg_match('/.*/', (string) $key)) {
                $object[$key] = $value;
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
        $data['billingNumber'] = $object->getBillingNumber();
        if ($object->isInitialized('refNo') && null !== $object->getRefNo()) {
            $data['refNo'] = $object->getRefNo();
        }
        if ($object->isInitialized('returnAddress') && null !== $object->getReturnAddress()) {
            $data['returnAddress'] = $this->normalizer->normalize($object->getReturnAddress(), 'json', $context);
        }
        foreach ($object as $key => $value) {
            if (preg_match('/.*/', (string) $key)) {
                $data[$key] = $value;
            }
        }
        return $data;
    }
}