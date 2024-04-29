<?php

namespace Mediaopt\DHL\Api\Authentication\Normalizer;

use Mediaopt\DHL\Api\Authentication\Runtime\Normalizer\CheckArray;
use Mediaopt\DHL\Api\Authentication\Runtime\Normalizer\ValidatorTrait;
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
    protected $normalizers = array('Mediaopt\\DHL\\Api\\Authentication\\Model\\TokenResponse' => 'Mediaopt\\DHL\\Api\\Authentication\\Normalizer\\TokenResponseNormalizer', 'Mediaopt\\DHL\\Api\\Authentication\\Model\\GetResponse200' => 'Mediaopt\\DHL\\Api\\Authentication\\Normalizer\\GetResponse200Normalizer', 'Mediaopt\\DHL\\Api\\Authentication\\Model\\GetResponse200Amp' => 'Mediaopt\\DHL\\Api\\Authentication\\Normalizer\\GetResponse200AmpNormalizer', 'Mediaopt\\DHL\\Api\\Authentication\\Model\\TokenPostBody' => 'Mediaopt\\DHL\\Api\\Authentication\\Normalizer\\TokenPostBodyNormalizer', '\\Jane\\Component\\JsonSchemaRuntime\\Reference' => '\\Mediaopt\\DHL\\Api\\Authentication\\Runtime\\Normalizer\\ReferenceNormalizer'), $normalizersCache = array();
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
        return array('Mediaopt\\DHL\\Api\\Authentication\\Model\\TokenResponse' => false, 'Mediaopt\\DHL\\Api\\Authentication\\Model\\GetResponse200' => false, 'Mediaopt\\DHL\\Api\\Authentication\\Model\\GetResponse200Amp' => false, 'Mediaopt\\DHL\\Api\\Authentication\\Model\\TokenPostBody' => false, '\\Jane\\Component\\JsonSchemaRuntime\\Reference' => false);
    }
}