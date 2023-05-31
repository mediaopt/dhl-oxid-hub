<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class GetManifestData extends \ArrayObject
{
    /**
     * @var array
     */
    protected $initialized = array();
    public function isInitialized($property) : bool
    {
        return array_key_exists($property, $this->initialized);
    }
    /**
     * The encoded byte stream
     *
     * @var string[]
     */
    protected $b64;
    /**
     * The document in zpl encoding
     *
     * @var string
     */
    protected $zpl2;
    /**
     * URL reference to download document
     *
     * @var string
     */
    protected $url;
    /**
     * format of the encoded bytes
     *
     * @var string
     */
    protected $fileFormat;
    /**
     * The print format used
     *
     * @var string
     */
    protected $printFormat;
    /**
     * The encoded byte stream
     *
     * @return string[]
     */
    public function getB64() : array
    {
        return $this->b64;
    }
    /**
     * The encoded byte stream
     *
     * @param string[] $b64
     *
     * @return self
     */
    public function setB64(array $b64) : self
    {
        $this->initialized['b64'] = true;
        $this->b64 = $b64;
        return $this;
    }
    /**
     * The document in zpl encoding
     *
     * @return string
     */
    public function getZpl2() : string
    {
        return $this->zpl2;
    }
    /**
     * The document in zpl encoding
     *
     * @param string $zpl2
     *
     * @return self
     */
    public function setZpl2(string $zpl2) : self
    {
        $this->initialized['zpl2'] = true;
        $this->zpl2 = $zpl2;
        return $this;
    }
    /**
     * URL reference to download document
     *
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
    }
    /**
     * URL reference to download document
     *
     * @param string $url
     *
     * @return self
     */
    public function setUrl(string $url) : self
    {
        $this->initialized['url'] = true;
        $this->url = $url;
        return $this;
    }
    /**
     * format of the encoded bytes
     *
     * @return string
     */
    public function getFileFormat() : string
    {
        return $this->fileFormat;
    }
    /**
     * format of the encoded bytes
     *
     * @param string $fileFormat
     *
     * @return self
     */
    public function setFileFormat(string $fileFormat) : self
    {
        $this->initialized['fileFormat'] = true;
        $this->fileFormat = $fileFormat;
        return $this;
    }
    /**
     * The print format used
     *
     * @return string
     */
    public function getPrintFormat() : string
    {
        return $this->printFormat;
    }
    /**
     * The print format used
     *
     * @param string $printFormat
     *
     * @return self
     */
    public function setPrintFormat(string $printFormat) : self
    {
        $this->initialized['printFormat'] = true;
        $this->printFormat = $printFormat;
        return $this;
    }
}