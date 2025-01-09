<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Normalizer;

use Mediaopt\DHL\Api\ParcelShipping\Runtime\Normalizer\CheckArray;
use Mediaopt\DHL\Api\ParcelShipping\Runtime\Normalizer\ValidatorTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
class JaneObjectNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    use NormalizerAwareTrait;
    use CheckArray;
    use ValidatorTrait;
    protected $normalizers = array('Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ServiceInformation' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ServiceInformationNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ServiceInformationAmp' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ServiceInformationAmpNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ServiceInformationBackend' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ServiceInformationBackendNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Document' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\DocumentNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\RequestStatusNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\LabelDataResponseNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ResponseItem' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ResponseItemNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ValidationMessageItem' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ValidationMessageItemNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\GetManifestData' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\GetManifestDataNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\SingleManifestResponse' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\SingleManifestResponseNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\MultipleManifestResponse' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\MultipleManifestResponseNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShortResponseItem' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ShortResponseItemNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipmentManifestingRequest' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ShipmentManifestingRequestNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\BankAccount' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\BankAccountNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Commodity' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\CommodityNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ContactAddress' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ContactAddressNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\CustomsDetails' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\CustomsDetailsNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\CustomsDetailsPostalCharges' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\CustomsDetailsPostalChargesNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Dimensions' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\DimensionsNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Locker' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\LockerNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\PostOffice' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\PostOfficeNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\POBox' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\POBoxNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Shipment' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ShipmentNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipmentDetails' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ShipmentDetailsNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipmentOrderRequest' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ShipmentOrderRequestNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Shipper' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ShipperNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipperReference' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ShipperReferenceNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VAS' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\VASNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VASCashOnDelivery' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\VASCashOnDeliveryNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VASDhlRetoure' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\VASDhlRetoureNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VASIdentCheck' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\VASIdentCheckNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Value' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\ValueNormalizer', 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Weight' => 'Mediaopt\\DHL\\Api\\ParcelShipping\\Normalizer\\WeightNormalizer', '\\Jane\\Component\\JsonSchemaRuntime\\Reference' => '\\Mediaopt\\DHL\\Api\\ParcelShipping\\Runtime\\Normalizer\\ReferenceNormalizer'), $normalizersCache = array();
    public function supportsDenormalization($data, $type, $format = null, array $context = array()) : bool
    {
        return array_key_exists($type, $this->normalizers);
    }
    public function supportsNormalization($data, $format = null, array $context = array()) : bool
    {
        return is_object($data) && array_key_exists(get_class($data), $this->normalizers);
    }
    /**
     * @return array|string|int|float|bool|\ArrayObject|null
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $normalizerClass = $this->normalizers[get_class($object)];
        $normalizer = $this->getNormalizer($normalizerClass);
        return $normalizer->normalize($object, $format, $context);
    }
    /**
     * @return mixed
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $denormalizerClass = $this->normalizers[$class];
        $denormalizer = $this->getNormalizer($denormalizerClass);
        return $denormalizer->denormalize($data, $class, $format, $context);
    }
    private function getNormalizer(string $normalizerClass)
    {
        return $this->normalizersCache[$normalizerClass] ?? $this->initNormalizer($normalizerClass);
    }
    private function initNormalizer(string $normalizerClass)
    {
        $normalizer = new $normalizerClass();
        $normalizer->setNormalizer($this->normalizer);
        $normalizer->setDenormalizer($this->denormalizer);
        $this->normalizersCache[$normalizerClass] = $normalizer;
        return $normalizer;
    }
    public function getSupportedTypes(?string $format = null) : array
    {
        return array('Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ServiceInformation' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ServiceInformationAmp' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ServiceInformationBackend' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Document' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\RequestStatus' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\LabelDataResponse' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ResponseItem' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ValidationMessageItem' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\GetManifestData' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\SingleManifestResponse' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\MultipleManifestResponse' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShortResponseItem' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipmentManifestingRequest' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\BankAccount' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Commodity' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ContactAddress' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\CustomsDetails' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\CustomsDetailsPostalCharges' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Dimensions' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Locker' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\PostOffice' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\POBox' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Shipment' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipmentDetails' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipmentOrderRequest' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Shipper' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\ShipperReference' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VAS' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VASCashOnDelivery' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VASDhlRetoure' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\VASIdentCheck' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Value' => false, 'Mediaopt\\DHL\\Api\\ParcelShipping\\Model\\Weight' => false, '\\Jane\\Component\\JsonSchemaRuntime\\Reference' => false);
    }
}