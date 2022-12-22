<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class Dimensions extends \ArrayObject
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
     * Unit of metric, applies to all dimensions contained.
     *
     * @var string
     */
    protected $uom;
    /**
     * 
     *
     * @var int
     */
    protected $height;
    /**
     * 
     *
     * @var int
     */
    protected $length;
    /**
     * 
     *
     * @var int
     */
    protected $width;
    /**
     * Unit of metric, applies to all dimensions contained.
     *
     * @return string
     */
    public function getUom() : string
    {
        return $this->uom;
    }
    /**
     * Unit of metric, applies to all dimensions contained.
     *
     * @param string $uom
     *
     * @return self
     */
    public function setUom(string $uom) : self
    {
        $this->initialized['uom'] = true;
        $this->uom = $uom;
        return $this;
    }
    /**
     * 
     *
     * @return int
     */
    public function getHeight() : int
    {
        return $this->height;
    }
    /**
     * 
     *
     * @param int $height
     *
     * @return self
     */
    public function setHeight(int $height) : self
    {
        $this->initialized['height'] = true;
        $this->height = $height;
        return $this;
    }
    /**
     * 
     *
     * @return int
     */
    public function getLength() : int
    {
        return $this->length;
    }
    /**
     * 
     *
     * @param int $length
     *
     * @return self
     */
    public function setLength(int $length) : self
    {
        $this->initialized['length'] = true;
        $this->length = $length;
        return $this;
    }
    /**
     * 
     *
     * @return int
     */
    public function getWidth() : int
    {
        return $this->width;
    }
    /**
     * 
     *
     * @param int $width
     *
     * @return self
     */
    public function setWidth(int $width) : self
    {
        $this->initialized['width'] = true;
        $this->width = $width;
        return $this;
    }
}