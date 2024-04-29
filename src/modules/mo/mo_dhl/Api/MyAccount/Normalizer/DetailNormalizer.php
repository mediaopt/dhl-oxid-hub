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
class DetailNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null, array $context = array()) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\Detail';
    }
    public function supportsNormalization($data, $format = null, array $context = array()) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\Detail';
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
        $object = new \Mediaopt\DHL\Api\MyAccount\Model\Detail();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('billingNumber', $data)) {
            $object->setBillingNumber($data['billingNumber']);
            unset($data['billingNumber']);
        }
        if (\array_key_exists('bookingText', $data)) {
            $object->setBookingText($data['bookingText']);
            unset($data['bookingText']);
        }
        if (\array_key_exists('goGreen', $data)) {
            $object->setGoGreen($data['goGreen']);
            unset($data['goGreen']);
        }
        if (\array_key_exists('product', $data)) {
            $object->setProduct($this->denormalizer->denormalize($data['product'], 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\Product', 'json', $context));
            unset($data['product']);
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
        if ($object->isInitialized('billingNumber') && null !== $object->getBillingNumber()) {
            $data['billingNumber'] = $object->getBillingNumber();
        }
        if ($object->isInitialized('bookingText') && null !== $object->getBookingText()) {
            $data['bookingText'] = $object->getBookingText();
        }
        if ($object->isInitialized('goGreen') && null !== $object->getGoGreen()) {
            $data['goGreen'] = $object->getGoGreen();
        }
        if ($object->isInitialized('product') && null !== $object->getProduct()) {
            $data['product'] = $this->normalizer->normalize($object->getProduct(), 'json', $context);
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
        return array('Mediaopt\\DHL\\Api\\MyAccount\\Model\\Detail' => false);
    }
}