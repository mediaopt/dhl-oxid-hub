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
class ShipmentManifestingRequestNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipmentManifestingRequest';
    }
    public function supportsNormalization($data, $format = null) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipmentManifestingRequest';
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
        $object = new \Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentManifestingRequest();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('profile', $data)) {
            $object->setProfile($data['profile']);
            unset($data['profile']);
        }
        if (\array_key_exists('shipmentNumbers', $data)) {
            $values = array();
            foreach ($data['shipmentNumbers'] as $value) {
                $values[] = $value;
            }
            $object->setShipmentNumbers($values);
            unset($data['shipmentNumbers']);
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
        if ($object->isInitialized('profile') && null !== $object->getProfile()) {
            $data['profile'] = $object->getProfile();
        }
        $values = array();
        foreach ($object->getShipmentNumbers() as $value) {
            $values[] = $value;
        }
        $data['shipmentNumbers'] = $values;
        foreach ($object as $key => $value_1) {
            if (preg_match('/.*/', (string) $key)) {
                $data[$key] = $value_1;
            }
        }
        return $data;
    }
}