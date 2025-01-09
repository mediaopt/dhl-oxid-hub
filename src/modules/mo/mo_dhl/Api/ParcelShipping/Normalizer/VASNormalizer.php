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
class VASNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    public function supportsDenormalization($data, $type, $format = null, array $context = array()) : bool
    {
        return $type === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VAS';
    }
    public function supportsNormalization($data, $format = null, array $context = array()) : bool
    {
        return is_object($data) && get_class($data) === 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VAS';
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
        $object = new \Mediaopt\DHL\Api\ParcelShipping\Model\VAS();
        if (null === $data || false === \is_array($data)) {
            return $object;
        }
        if (\array_key_exists('preferredNeighbour', $data)) {
            $object->setPreferredNeighbour($data['preferredNeighbour']);
            unset($data['preferredNeighbour']);
        }
        if (\array_key_exists('preferredLocation', $data)) {
            $object->setPreferredLocation($data['preferredLocation']);
            unset($data['preferredLocation']);
        }
        if (\array_key_exists('visualCheckOfAge', $data)) {
            $object->setVisualCheckOfAge($data['visualCheckOfAge']);
            unset($data['visualCheckOfAge']);
        }
        if (\array_key_exists('namedPersonOnly', $data)) {
            $object->setNamedPersonOnly($data['namedPersonOnly']);
            unset($data['namedPersonOnly']);
        }
        if (\array_key_exists('identCheck', $data)) {
            $object->setIdentCheck($this->denormalizer->denormalize($data['identCheck'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VASIdentCheck', 'json', $context));
            unset($data['identCheck']);
        }
        if (\array_key_exists('signedForByRecipient', $data)) {
            $object->setSignedForByRecipient($data['signedForByRecipient']);
            unset($data['signedForByRecipient']);
        }
        if (\array_key_exists('endorsement', $data)) {
            $object->setEndorsement($data['endorsement']);
            unset($data['endorsement']);
        }
        if (\array_key_exists('preferredDay', $data)) {
            $object->setPreferredDay(\DateTime::createFromFormat('Y-m-d', $data['preferredDay'])->setTime(0, 0, 0));
            unset($data['preferredDay']);
        }
        if (\array_key_exists('noNeighbourDelivery', $data)) {
            $object->setNoNeighbourDelivery($data['noNeighbourDelivery']);
            unset($data['noNeighbourDelivery']);
        }
        if (\array_key_exists('additionalInsurance', $data)) {
            $object->setAdditionalInsurance($this->denormalizer->denormalize($data['additionalInsurance'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Value', 'json', $context));
            unset($data['additionalInsurance']);
        }
        if (\array_key_exists('bulkyGoods', $data)) {
            $object->setBulkyGoods($data['bulkyGoods']);
            unset($data['bulkyGoods']);
        }
        if (\array_key_exists('cashOnDelivery', $data)) {
            $object->setCashOnDelivery($this->denormalizer->denormalize($data['cashOnDelivery'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VASCashOnDelivery', 'json', $context));
            unset($data['cashOnDelivery']);
        }
        if (\array_key_exists('individualSenderRequirement', $data)) {
            $object->setIndividualSenderRequirement($data['individualSenderRequirement']);
            unset($data['individualSenderRequirement']);
        }
        if (\array_key_exists('premium', $data)) {
            $object->setPremium($data['premium']);
            unset($data['premium']);
        }
        if (\array_key_exists('closestDropPoint', $data)) {
            $object->setClosestDropPoint($data['closestDropPoint']);
            unset($data['closestDropPoint']);
        }
        if (\array_key_exists('parcelOutletRouting', $data)) {
            $object->setParcelOutletRouting($data['parcelOutletRouting']);
            unset($data['parcelOutletRouting']);
        }
        if (\array_key_exists('dhlRetoure', $data)) {
            $object->setDhlRetoure($this->denormalizer->denormalize($data['dhlRetoure'], 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VASDhlRetoure', 'json', $context));
            unset($data['dhlRetoure']);
        }
        if (\array_key_exists('postalDeliveryDutyPaid', $data)) {
            $object->setPostalDeliveryDutyPaid($data['postalDeliveryDutyPaid']);
            unset($data['postalDeliveryDutyPaid']);
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
        if ($object->isInitialized('preferredNeighbour') && null !== $object->getPreferredNeighbour()) {
            $data['preferredNeighbour'] = $object->getPreferredNeighbour();
        }
        if ($object->isInitialized('preferredLocation') && null !== $object->getPreferredLocation()) {
            $data['preferredLocation'] = $object->getPreferredLocation();
        }
        if ($object->isInitialized('visualCheckOfAge') && null !== $object->getVisualCheckOfAge()) {
            $data['visualCheckOfAge'] = $object->getVisualCheckOfAge();
        }
        if ($object->isInitialized('namedPersonOnly') && null !== $object->getNamedPersonOnly()) {
            $data['namedPersonOnly'] = $object->getNamedPersonOnly();
        }
        if ($object->isInitialized('identCheck') && null !== $object->getIdentCheck()) {
            $data['identCheck'] = $this->normalizer->normalize($object->getIdentCheck(), 'json', $context);
        }
        if ($object->isInitialized('signedForByRecipient') && null !== $object->getSignedForByRecipient()) {
            $data['signedForByRecipient'] = $object->getSignedForByRecipient();
        }
        if ($object->isInitialized('endorsement') && null !== $object->getEndorsement()) {
            $data['endorsement'] = $object->getEndorsement();
        }
        if ($object->isInitialized('preferredDay') && null !== $object->getPreferredDay()) {
            $data['preferredDay'] = $object->getPreferredDay()->format('Y-m-d');
        }
        if ($object->isInitialized('noNeighbourDelivery') && null !== $object->getNoNeighbourDelivery()) {
            $data['noNeighbourDelivery'] = $object->getNoNeighbourDelivery();
        }
        if ($object->isInitialized('additionalInsurance') && null !== $object->getAdditionalInsurance()) {
            $data['additionalInsurance'] = $this->normalizer->normalize($object->getAdditionalInsurance(), 'json', $context);
        }
        if ($object->isInitialized('bulkyGoods') && null !== $object->getBulkyGoods()) {
            $data['bulkyGoods'] = $object->getBulkyGoods();
        }
        if ($object->isInitialized('cashOnDelivery') && null !== $object->getCashOnDelivery()) {
            $data['cashOnDelivery'] = $this->normalizer->normalize($object->getCashOnDelivery(), 'json', $context);
        }
        if ($object->isInitialized('individualSenderRequirement') && null !== $object->getIndividualSenderRequirement()) {
            $data['individualSenderRequirement'] = $object->getIndividualSenderRequirement();
        }
        if ($object->isInitialized('premium') && null !== $object->getPremium()) {
            $data['premium'] = $object->getPremium();
        }
        if ($object->isInitialized('closestDropPoint') && null !== $object->getClosestDropPoint()) {
            $data['closestDropPoint'] = $object->getClosestDropPoint();
        }
        if ($object->isInitialized('parcelOutletRouting') && null !== $object->getParcelOutletRouting()) {
            $data['parcelOutletRouting'] = $object->getParcelOutletRouting();
        }
        if ($object->isInitialized('dhlRetoure') && null !== $object->getDhlRetoure()) {
            $data['dhlRetoure'] = $this->normalizer->normalize($object->getDhlRetoure(), 'json', $context);
        }
        if ($object->isInitialized('postalDeliveryDutyPaid') && null !== $object->getPostalDeliveryDutyPaid()) {
            $data['postalDeliveryDutyPaid'] = $object->getPostalDeliveryDutyPaid();
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
        return array('Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VAS' => false);
    }
}