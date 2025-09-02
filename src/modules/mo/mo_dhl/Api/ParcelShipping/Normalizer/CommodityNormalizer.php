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
class CommodityNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null, array $context = array()) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Commodity';
    }
    public function supportsNormalization($data, $format = null, array $context = array()) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Commodity';
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
        $object = new \Mediaopt\DHL\Api\ParcelShipping\Model\Commodity();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('itemDescription', $data)) {
            $object->setItemDescription($data['itemDescription']);
            unset($data['itemDescription']);
        }
        if (\array_key_exists('countryOfOrigin', $data)) {
            $object->setCountryOfOrigin($data['countryOfOrigin']);
            unset($data['countryOfOrigin']);
        }
        if (\array_key_exists('hsCode', $data)) {
            $object->setHsCode($data['hsCode']);
            unset($data['hsCode']);
        }
        if (\array_key_exists('packagedQuantity', $data)) {
            $object->setPackagedQuantity($data['packagedQuantity']);
            unset($data['packagedQuantity']);
        }
        if (\array_key_exists('itemValue', $data)) {
            $object->setItemValue($this->denormalizer->denormalize($data['itemValue'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Value', 'json', $context));
            unset($data['itemValue']);
        }
        if (\array_key_exists('itemWeight', $data)) {
            $object->setItemWeight($this->denormalizer->denormalize($data['itemWeight'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Weight', 'json', $context));
            unset($data['itemWeight']);
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
        $data['itemDescription'] = $object->getItemDescription();
        if ($object->isInitialized('countryOfOrigin') && null !== $object->getCountryOfOrigin()) {
            $data['countryOfOrigin'] = $object->getCountryOfOrigin();
        }
        if ($object->isInitialized('hsCode') && null !== $object->getHsCode()) {
            $data['hsCode'] = $object->getHsCode();
        }
        $data['packagedQuantity'] = $object->getPackagedQuantity();
        $data['itemValue'] = $this->normalizer->normalize($object->getItemValue(), 'json', $context);
        $data['itemWeight'] = $this->normalizer->normalize($object->getItemWeight(), 'json', $context);
        foreach ($object as $key => $value) {
            if (preg_match('/.*/', (string) $key)) {
                $data[$key] = $value;
            }
        }
        return $data;
    }
    public function getSupportedTypes(?string $format = null) : array
    {
        return array('Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Commodity' => false);
    }
}