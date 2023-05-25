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
class ShipmentNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Shipment';
    }
    public function supportsNormalization($data, $format = null) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Shipment';
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
        $object = new \Mediaopt\DHL\Api\ParcelShipping\Model\Shipment();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('product', $data)) {
            $object->setProduct($data['product']);
            unset($data['product']);
        }
        if (\array_key_exists('billingNumber', $data)) {
            $object->setBillingNumber($data['billingNumber']);
            unset($data['billingNumber']);
        }
        if (\array_key_exists('refNo', $data)) {
            $object->setRefNo($data['refNo']);
            unset($data['refNo']);
        }
        if (\array_key_exists('costCenter', $data)) {
            $object->setCostCenter($data['costCenter']);
            unset($data['costCenter']);
        }
        if (\array_key_exists('creationSoftware', $data)) {
            $object->setCreationSoftware($data['creationSoftware']);
            unset($data['creationSoftware']);
        }
        if (\array_key_exists('shipDate', $data)) {
            $object->setShipDate(\DateTime::createFromFormat('Y-m-d', $data['shipDate'])->setTime(0, 0, 0));
            unset($data['shipDate']);
        }
        if (\array_key_exists('shipper', $data)) {
            $object->setShipper($this->denormalizer->denormalize($data['shipper'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Shipper', 'json', $context));
            unset($data['shipper']);
        }
        if (\array_key_exists('consignee', $data)) {
            $values = new \ArrayObject(array(), \ArrayObject::ARRAY_AS_PROPS);
            foreach ($data['consignee'] as $key => $value) {
                $values[$key] = $value;
            }
            $object->setConsignee($values);
            unset($data['consignee']);
        }
        if (\array_key_exists('details', $data)) {
            $object->setDetails($this->denormalizer->denormalize($data['details'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipmentDetails', 'json', $context));
            unset($data['details']);
        }
        if (\array_key_exists('services', $data)) {
            $object->setServices($this->denormalizer->denormalize($data['services'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VAS', 'json', $context));
            unset($data['services']);
        }
        if (\array_key_exists('customs', $data)) {
            $object->setCustoms($this->denormalizer->denormalize($data['customs'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\CustomsDetails', 'json', $context));
            unset($data['customs']);
        }
        foreach ($data as $key_1 => $value_1) {
            if (preg_match('/.*/', (string) $key_1)) {
                $object[$key_1] = $value_1;
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
        if ($object->isInitialized('product') && null !== $object->getProduct()) {
            $data['product'] = $object->getProduct();
        }
        if ($object->isInitialized('billingNumber') && null !== $object->getBillingNumber()) {
            $data['billingNumber'] = $object->getBillingNumber();
        }
        if ($object->isInitialized('refNo') && null !== $object->getRefNo()) {
            $data['refNo'] = $object->getRefNo();
        }
        if ($object->isInitialized('costCenter') && null !== $object->getCostCenter()) {
            $data['costCenter'] = $object->getCostCenter();
        }
        if ($object->isInitialized('creationSoftware') && null !== $object->getCreationSoftware()) {
            $data['creationSoftware'] = $object->getCreationSoftware();
        }
        if ($object->isInitialized('shipDate') && null !== $object->getShipDate()) {
            $data['shipDate'] = $object->getShipDate()->format('Y-m-d');
        }
        if ($object->isInitialized('shipper') && null !== $object->getShipper()) {
            $data['shipper'] = $this->normalizer->normalize($object->getShipper(), 'json', $context);
        }
        if ($object->isInitialized('consignee') && null !== $object->getConsignee()) {
            $values = array();
            foreach ($object->getConsignee() as $key => $value) {
                $values[$key] = $value;
            }
            $data['consignee'] = $values;
        }
        if ($object->isInitialized('details') && null !== $object->getDetails()) {
            $data['details'] = $this->normalizer->normalize($object->getDetails(), 'json', $context);
        }
        if ($object->isInitialized('services') && null !== $object->getServices()) {
            $data['services'] = $this->normalizer->normalize($object->getServices(), 'json', $context);
        }
        if ($object->isInitialized('customs') && null !== $object->getCustoms()) {
            $data['customs'] = $this->normalizer->normalize($object->getCustoms(), 'json', $context);
        }
        foreach ($object as $key_1 => $value_1) {
            if (preg_match('/.*/', (string) $key_1)) {
                $data[$key_1] = $value_1;
            }
        }
        return $data;
    }
}