<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class ShipmentDetails extends \ArrayObject
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
     * Physical dimensions (aka 'Gurtmass') of the parcel. If you provide the dimension information, all attributes need to be provided. You cannot provide just the height, for example. If you provide length, width, and height in millimeters, they will be rounded to full cm.
     *
     * @var Dimensions
     */
    protected $dim;
    /**
     * Weight of item or shipment. Both uom and value are required.
     *
     * @var Weight
     */
    protected $weight;
    /**
     * Physical dimensions (aka 'Gurtmass') of the parcel. If you provide the dimension information, all attributes need to be provided. You cannot provide just the height, for example. If you provide length, width, and height in millimeters, they will be rounded to full cm.
     *
     * @return Dimensions
     */
    public function getDim() : Dimensions
    {
        return $this->dim;
    }
    /**
     * Physical dimensions (aka 'Gurtmass') of the parcel. If you provide the dimension information, all attributes need to be provided. You cannot provide just the height, for example. If you provide length, width, and height in millimeters, they will be rounded to full cm.
     *
     * @param Dimensions $dim
     *
     * @return self
     */
    public function setDim(Dimensions $dim) : self
    {
        $this->initialized['dim'] = true;
        $this->dim = $dim;
        return $this;
    }
    /**
     * Weight of item or shipment. Both uom and value are required.
     *
     * @return Weight
     */
    public function getWeight() : Weight
    {
        return $this->weight;
    }
    /**
     * Weight of item or shipment. Both uom and value are required.
     *
     * @param Weight $weight
     *
     * @return self
     */
    public function setWeight(Weight $weight) : self
    {
        $this->initialized['weight'] = true;
        $this->weight = $weight;
        return $this;
    }
}