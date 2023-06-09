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
class GetManifestDataNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\GetManifestData';
    }
    public function supportsNormalization($data, $format = null) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\GetManifestData';
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
        $object = new \Mediaopt\DHL\Api\ParcelShipping\Model\GetManifestData();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('b64', $data)) {
            $values = array();
            foreach ($data['b64'] as $value) {
                $values[] = $value;
            }
            $object->setB64($values);
            unset($data['b64']);
        }
        if (\array_key_exists('zpl2', $data)) {
            $object->setZpl2($data['zpl2']);
            unset($data['zpl2']);
        }
        if (\array_key_exists('url', $data)) {
            $object->setUrl($data['url']);
            unset($data['url']);
        }
        if (\array_key_exists('fileFormat', $data)) {
            $object->setFileFormat($data['fileFormat']);
            unset($data['fileFormat']);
        }
        if (\array_key_exists('printFormat', $data)) {
            $object->setPrintFormat($data['printFormat']);
            unset($data['printFormat']);
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
        if ($object->isInitialized('b64') && null !== $object->getB64()) {
            $values = array();
            foreach ($object->getB64() as $value) {
                $values[] = $value;
            }
            $data['b64'] = $values;
        }
        if ($object->isInitialized('zpl2') && null !== $object->getZpl2()) {
            $data['zpl2'] = $object->getZpl2();
        }
        if ($object->isInitialized('url') && null !== $object->getUrl()) {
            $data['url'] = $object->getUrl();
        }
        if ($object->isInitialized('fileFormat') && null !== $object->getFileFormat()) {
            $data['fileFormat'] = $object->getFileFormat();
        }
        if ($object->isInitialized('printFormat') && null !== $object->getPrintFormat()) {
            $data['printFormat'] = $object->getPrintFormat();
        }
        foreach ($object as $key => $value_1) {
            if (preg_match('/.*/', (string) $key)) {
                $data[$key] = $value_1;
            }
        }
        return $data;
    }
}