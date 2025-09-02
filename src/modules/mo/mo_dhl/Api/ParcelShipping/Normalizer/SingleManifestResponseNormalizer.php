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
class SingleManifestResponseNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null, array $context = array()) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\SingleManifestResponse';
    }
    public function supportsNormalization($data, $format = null, array $context = array()) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\SingleManifestResponse';
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
        $object = new \Mediaopt\DHL\Api\ParcelShipping\Model\SingleManifestResponse();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('status', $data)) {
            $object->setStatus($this->denormalizer->denormalize($data['status'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus', 'json', $context));
            unset($data['status']);
        }
        if (\array_key_exists('manifestDate', $data)) {
            $object->setManifestDate($data['manifestDate']);
            unset($data['manifestDate']);
        }
        if (\array_key_exists('manifest', $data)) {
            $values = array();
            foreach ($data['manifest'] as $value) {
                $values[] = $this->denormalizer->denormalize($value, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Document', 'json', $context);
            }
            $object->setManifest($values);
            unset($data['manifest']);
        }
        if (\array_key_exists('sheetNo', $data)) {
            $values_1 = array();
            foreach ($data['sheetNo'] as $value_1) {
                $values_1[] = $this->denormalizer->denormalize($value_1, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\BillingNoToSheetNo', 'json', $context);
            }
            $object->setSheetNo($values_1);
            unset($data['sheetNo']);
        }
        if (\array_key_exists('items', $data)) {
            $values_2 = array();
            foreach ($data['items'] as $value_2) {
                $values_2[] = $this->denormalizer->denormalize($value_2, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipmentNoToSheetNo', 'json', $context);
            }
            $object->setItems($values_2);
            unset($data['items']);
        }
        foreach ($data as $key => $value_3) {
            if (preg_match('/.*/', (string) $key)) {
                $object[$key] = $value_3;
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
        if ($object->isInitialized('status') && null !== $object->getStatus()) {
            $data['status'] = $this->normalizer->normalize($object->getStatus(), 'json', $context);
        }
        if ($object->isInitialized('manifestDate') && null !== $object->getManifestDate()) {
            $data['manifestDate'] = $object->getManifestDate();
        }
        if ($object->isInitialized('manifest') && null !== $object->getManifest()) {
            $values = array();
            foreach ($object->getManifest() as $value) {
                $values[] = $this->normalizer->normalize($value, 'json', $context);
            }
            $data['manifest'] = $values;
        }
        if ($object->isInitialized('sheetNo') && null !== $object->getSheetNo()) {
            $values_1 = array();
            foreach ($object->getSheetNo() as $value_1) {
                $values_1[] = $this->normalizer->normalize($value_1, 'json', $context);
            }
            $data['sheetNo'] = $values_1;
        }
        if ($object->isInitialized('items') && null !== $object->getItems()) {
            $values_2 = array();
            foreach ($object->getItems() as $value_2) {
                $values_2[] = $this->normalizer->normalize($value_2, 'json', $context);
            }
            $data['items'] = $values_2;
        }
        foreach ($object as $key => $value_3) {
            if (preg_match('/.*/', (string) $key)) {
                $data[$key] = $value_3;
            }
        }
        return $data;
    }
    public function getSupportedTypes(?string $format = null) : array
    {
        return array('Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\SingleManifestResponse' => false);
    }
}