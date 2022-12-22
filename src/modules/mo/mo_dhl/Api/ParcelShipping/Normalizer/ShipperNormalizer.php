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
class ShipperNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Shipper';
    }
    public function supportsNormalization($data, $format = null) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Shipper';
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
        $object = new \Mediaopt\DHL\Api\ParcelShipping\Model\Shipper();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('name1', $data)) {
            $object->setName1($data['name1']);
            unset($data['name1']);
        }
        if (\array_key_exists('name2', $data)) {
            $object->setName2($data['name2']);
            unset($data['name2']);
        }
        if (\array_key_exists('name3', $data)) {
            $object->setName3($data['name3']);
            unset($data['name3']);
        }
        if (\array_key_exists('dispatchingInformation', $data)) {
            $object->setDispatchingInformation($data['dispatchingInformation']);
            unset($data['dispatchingInformation']);
        }
        if (\array_key_exists('addressStreet', $data)) {
            $object->setAddressStreet($data['addressStreet']);
            unset($data['addressStreet']);
        }
        if (\array_key_exists('addressHouse', $data)) {
            $object->setAddressHouse($data['addressHouse']);
            unset($data['addressHouse']);
        }
        if (\array_key_exists('additionalAddressInformation1', $data)) {
            $object->setAdditionalAddressInformation1($data['additionalAddressInformation1']);
            unset($data['additionalAddressInformation1']);
        }
        if (\array_key_exists('additionalAddressInformation2', $data)) {
            $object->setAdditionalAddressInformation2($data['additionalAddressInformation2']);
            unset($data['additionalAddressInformation2']);
        }
        if (\array_key_exists('postalCode', $data)) {
            $object->setPostalCode($data['postalCode']);
            unset($data['postalCode']);
        }
        if (\array_key_exists('city', $data)) {
            $object->setCity($data['city']);
            unset($data['city']);
        }
        if (\array_key_exists('state', $data)) {
            $object->setState($data['state']);
            unset($data['state']);
        }
        if (\array_key_exists('country', $data)) {
            $object->setCountry($data['country']);
            unset($data['country']);
        }
        if (\array_key_exists('contactName', $data)) {
            $object->setContactName($data['contactName']);
            unset($data['contactName']);
        }
        if (\array_key_exists('phone', $data)) {
            $object->setPhone($data['phone']);
            unset($data['phone']);
        }
        if (\array_key_exists('email', $data)) {
            $object->setEmail($data['email']);
            unset($data['email']);
        }
        if (\array_key_exists('shipperRef', $data)) {
            $object->setShipperRef($data['shipperRef']);
            unset($data['shipperRef']);
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
        $data['name1'] = $object->getName1();
        if ($object->isInitialized('name2') && null !== $object->getName2()) {
            $data['name2'] = $object->getName2();
        }
        if ($object->isInitialized('name3') && null !== $object->getName3()) {
            $data['name3'] = $object->getName3();
        }
        if ($object->isInitialized('dispatchingInformation') && null !== $object->getDispatchingInformation()) {
            $data['dispatchingInformation'] = $object->getDispatchingInformation();
        }
        $data['addressStreet'] = $object->getAddressStreet();
        if ($object->isInitialized('addressHouse') && null !== $object->getAddressHouse()) {
            $data['addressHouse'] = $object->getAddressHouse();
        }
        if ($object->isInitialized('additionalAddressInformation1') && null !== $object->getAdditionalAddressInformation1()) {
            $data['additionalAddressInformation1'] = $object->getAdditionalAddressInformation1();
        }
        if ($object->isInitialized('additionalAddressInformation2') && null !== $object->getAdditionalAddressInformation2()) {
            $data['additionalAddressInformation2'] = $object->getAdditionalAddressInformation2();
        }
        if ($object->isInitialized('postalCode') && null !== $object->getPostalCode()) {
            $data['postalCode'] = $object->getPostalCode();
        }
        $data['city'] = $object->getCity();
        if ($object->isInitialized('state') && null !== $object->getState()) {
            $data['state'] = $object->getState();
        }
        $data['country'] = $object->getCountry();
        if ($object->isInitialized('contactName') && null !== $object->getContactName()) {
            $data['contactName'] = $object->getContactName();
        }
        if ($object->isInitialized('phone') && null !== $object->getPhone()) {
            $data['phone'] = $object->getPhone();
        }
        if ($object->isInitialized('email') && null !== $object->getEmail()) {
            $data['email'] = $object->getEmail();
        }
        if ($object->isInitialized('shipperRef') && null !== $object->getShipperRef()) {
            $data['shipperRef'] = $object->getShipperRef();
        }
        foreach ($object as $key => $value) {
            if (preg_match('/.*/', (string) $key)) {
                $data[$key] = $value;
            }
        }
        return $data;
    }
}