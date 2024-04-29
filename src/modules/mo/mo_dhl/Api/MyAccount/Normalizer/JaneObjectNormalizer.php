<?php

namespace Mediaopt\DHL\Api\MyAccount\Normalizer;

use Mediaopt\DHL\Api\MyAccount\Runtime\Normalizer\CheckArray;
use Mediaopt\DHL\Api\MyAccount\Runtime\Normalizer\ValidatorTrait;
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
    protected $normalizers = array('Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponse' => 'Mediaopt\\DHL\\Api\\MyAccount\\Normalizer\\ApiVersionResponseNormalizer', 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponseAmp' => 'Mediaopt\\DHL\\Api\\MyAccount\\Normalizer\\ApiVersionResponseAmpNormalizer', 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponseBackend' => 'Mediaopt\\DHL\\Api\\MyAccount\\Normalizer\\ApiVersionResponseBackendNormalizer', 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponseHTML' => 'Mediaopt\\DHL\\Api\\MyAccount\\Normalizer\\ApiVersionResponseHTMLNormalizer', 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponseHTMLAmp' => 'Mediaopt\\DHL\\Api\\MyAccount\\Normalizer\\ApiVersionResponseHTMLAmpNormalizer', 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\AggregatedUserDataResponse' => 'Mediaopt\\DHL\\Api\\MyAccount\\Normalizer\\AggregatedUserDataResponseNormalizer', 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\Detail' => 'Mediaopt\\DHL\\Api\\MyAccount\\Normalizer\\DetailNormalizer', 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\Product' => 'Mediaopt\\DHL\\Api\\MyAccount\\Normalizer\\ProductNormalizer', 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\Service' => 'Mediaopt\\DHL\\Api\\MyAccount\\Normalizer\\ServiceNormalizer', 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\Shipping' => 'Mediaopt\\DHL\\Api\\MyAccount\\Normalizer\\ShippingNormalizer', 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\User' => 'Mediaopt\\DHL\\Api\\MyAccount\\Normalizer\\UserNormalizer', 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\RequestStatus' => 'Mediaopt\\DHL\\Api\\MyAccount\\Normalizer\\RequestStatusNormalizer', '\\Jane\\Component\\JsonSchemaRuntime\\Reference' => '\\Mediaopt\\DHL\\Api\\MyAccount\\Runtime\\Normalizer\\ReferenceNormalizer'), $normalizersCache = array();
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
        return array('Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponse' => false, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponseAmp' => false, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponseBackend' => false, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponseHTML' => false, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\ApiVersionResponseHTMLAmp' => false, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\AggregatedUserDataResponse' => false, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\Detail' => false, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\Product' => false, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\Service' => false, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\Shipping' => false, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\User' => false, 'Mediaopt\\DHL\\Api\\MyAccount\\Model\\RequestStatus' => false, '\\Jane\\Component\\JsonSchemaRuntime\\Reference' => false);
    }
}