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
class ValidationMessageItemNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ValidationMessageItem';
    }
    public function supportsNormalization($data, $format = null) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ValidationMessageItem';
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
        $object = new \Mediaopt\DHL\Api\ParcelShipping\Model\ValidationMessageItem();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('property', $data)) {
            $object->setProperty($data['property']);
            unset($data['property']);
        }
        if (\array_key_exists('validationMessage', $data)) {
            $object->setValidationMessage($data['validationMessage']);
            unset($data['validationMessage']);
        }
        if (\array_key_exists('validationState', $data)) {
            $object->setValidationState($data['validationState']);
            unset($data['validationState']);
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
        if ($object->isInitialized('property') && null !== $object->getProperty()) {
            $data['property'] = $object->getProperty();
        }
        if ($object->isInitialized('validationMessage') && null !== $object->getValidationMessage()) {
            $data['validationMessage'] = $object->getValidationMessage();
        }
        if ($object->isInitialized('validationState') && null !== $object->getValidationState()) {
            $data['validationState'] = $object->getValidationState();
        }
        foreach ($object as $key => $value) {
            if (preg_match('/.*/', (string) $key)) {
                $data[$key] = $value;
            }
        }
        return $data;
    }
}