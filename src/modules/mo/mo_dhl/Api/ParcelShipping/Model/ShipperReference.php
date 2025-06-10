<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class ShipperReference extends \ArrayObject
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
     * Reference string to the shipper data configured in GKP(GeschÃ¤ftskundenportal - Business Costumer Portal).
     *
     * @var string
     */
    protected $shipperRef;
    /**
     * Reference string to the shipper data configured in GKP(GeschÃ¤ftskundenportal - Business Costumer Portal).
     *
     * @return string
     */
    public function getShipperRef() : string
    {
        return $this->shipperRef;
    }
    /**
     * Reference string to the shipper data configured in GKP(GeschÃ¤ftskundenportal - Business Costumer Portal).
     *
     * @param string $shipperRef
     *
     * @return self
     */
    public function setShipperRef(string $shipperRef) : self
    {
        $this->initialized['shipperRef'] = true;
        $this->shipperRef = $shipperRef;
        return $this;
    }
}