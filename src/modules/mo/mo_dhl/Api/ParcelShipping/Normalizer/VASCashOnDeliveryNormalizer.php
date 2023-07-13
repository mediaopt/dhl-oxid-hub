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
class VASCashOnDeliveryNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VASCashOnDelivery';
    }
    public function supportsNormalization($data, $format = null) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VASCashOnDelivery';
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
        $object = new \Mediaopt\DHL\Api\ParcelShipping\Model\VASCashOnDelivery();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('amount', $data)) {
            $object->setAmount($this->denormalizer->denormalize($data['amount'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Value', 'json', $context));
            unset($data['amount']);
        }
        if (\array_key_exists('bankAccount', $data)) {
            $object->setBankAccount($this->denormalizer->denormalize($data['bankAccount'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\BankAccount', 'json', $context));
            unset($data['bankAccount']);
        }
        if (\array_key_exists('accountReference', $data)) {
            $object->setAccountReference($data['accountReference']);
            unset($data['accountReference']);
        }
        if (\array_key_exists('transferNote1', $data)) {
            $object->setTransferNote1($data['transferNote1']);
            unset($data['transferNote1']);
        }
        if (\array_key_exists('transferNote2', $data)) {
            $object->setTransferNote2($data['transferNote2']);
            unset($data['transferNote2']);
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
        if ($object->isInitialized('amount') && null !== $object->getAmount()) {
            $data['amount'] = $this->normalizer->normalize($object->getAmount(), 'json', $context);
        }
        if ($object->isInitialized('bankAccount') && null !== $object->getBankAccount()) {
            $data['bankAccount'] = $this->normalizer->normalize($object->getBankAccount(), 'json', $context);
        }
        if ($object->isInitialized('accountReference') && null !== $object->getAccountReference()) {
            $data['accountReference'] = $object->getAccountReference();
        }
        if ($object->isInitialized('transferNote1') && null !== $object->getTransferNote1()) {
            $data['transferNote1'] = $object->getTransferNote1();
        }
        if ($object->isInitialized('transferNote2') && null !== $object->getTransferNote2()) {
            $data['transferNote2'] = $object->getTransferNote2();
        }
        foreach ($object as $key => $value) {
            if (preg_match('/.*/', (string) $key)) {
                $data[$key] = $value;
            }
        }
        return $data;
    }
}