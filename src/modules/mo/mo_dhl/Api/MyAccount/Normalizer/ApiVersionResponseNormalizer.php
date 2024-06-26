<?php

namespace Mediaopt\DHL\Api\MyAccount\Normalizer;

use Jane\Component\JsonSchemaRuntime\Reference;
use Mediaopt\DHL\Api\MyAccount\Runtime\Normalizer\CheckArray;
use Mediaopt\DHL\Api\MyAccount\Runtime\Normalizer\ValidatorTrait;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
class ApiVersionResponseNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null, array $context = array()) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponse';
    }
    public function supportsNormalization($data, $format = null, array $context = array()) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponse';
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
        $object = new \Mediaopt\DHL\Api\MyAccount\Model\ApiVersionResponse();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('amp', $data)) {
            $object->setAmp($this->denormalizer->denormalize($data['amp'], 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponseAmp', 'json', $context));
            unset($data['amp']);
        }
        if (\array_key_exists('backend', $data)) {
            $object->setBackend($this->denormalizer->denormalize($data['backend'], 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponseBackend', 'json', $context));
            unset($data['backend']);
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
        if ($object->isInitialized('amp') && null !== $object->getAmp()) {
            $data['amp'] = $this->normalizer->normalize($object->getAmp(), 'json', $context);
        }
        if ($object->isInitialized('backend') && null !== $object->getBackend()) {
            $data['backend'] = $this->normalizer->normalize($object->getBackend(), 'json', $context);
        }
        foreach ($object as $key => $value) {
            if (preg_match('/.*/', (string) $key)) {
                $data[$key] = $value;
            }
        }
        return $data;
    }
    public function getSupportedTypes(?string $format = null) : array
    {
        return array('Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponse' => false);
    }
}