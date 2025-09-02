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
class ShipmentNoToSheetNoNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null, array $context = array()) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipmentNoToSheetNo';
    }
    public function supportsNormalization($data, $format = null, array $context = array()) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipmentNoToSheetNo';
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
        $object = new \Mediaopt\DHL\Api\ParcelShipping\Model\ShipmentNoToSheetNo();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('shipmentNo', $data)) {
            $object->setShipmentNo($data['shipmentNo']);
            unset($data['shipmentNo']);
        }
        if (\array_key_exists('sheetNo', $data)) {
            $object->setSheetNo($data['sheetNo']);
            unset($data['sheetNo']);
        }
        if (\array_key_exists('sstatus', $data)) {
            $object->setSstatus($this->denormalizer->denormalize($data['sstatus'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json', $context));
            unset($data['sstatus']);
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
        if ($object->isInitialized('shipmentNo') && null !== $object->getShipmentNo()) {
            $data['shipmentNo'] = $object->getShipmentNo();
        }
        if ($object->isInitialized('sheetNo') && null !== $object->getSheetNo()) {
            $data['sheetNo'] = $object->getSheetNo();
        }
        if ($object->isInitialized('sstatus') && null !== $object->getSstatus()) {
            $data['sstatus'] = $this->normalizer->normalize($object->getSstatus(), 'json', $context);
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
        return array('Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipmentNoToSheetNo' => false);
    }
}