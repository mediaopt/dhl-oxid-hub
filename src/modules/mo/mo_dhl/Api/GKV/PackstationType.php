<?php

namespace Mediaopt\DHL\Api\GKV;

class PackstationType
{

    /**
     * @var string $PackstationNumber
     */
    protected $PackstationNumber = null;

    /**
     * @var string $PostNumber
     */
    protected $PostNumber = null;

    /**
     * @var string $Zip
     */
    protected $Zip = null;

    /**
     * @var string $City
     */
    protected $City = null;

    /**
     * @param string $PackstationNumber
     * @param string $PostNumber
     * @param string    $Zip
     * @param string   $City
     */
    public function __construct($PackstationNumber, $PostNumber, $Zip, $City)
    {
        $this->PackstationNumber = $PackstationNumber;
        $this->PostNumber = $PostNumber;
        $this->Zip = $Zip;
        $this->City = $City;
    }

    /**
     * @return string
     */
    public function getPackstationNumber()
    {
        return $this->PackstationNumber;
    }

    /**
     * @param string $PackstationNumber
     * @return PackstationType
     */
    public function setPackstationNumber($PackstationNumber)
    {
        $this->PackstationNumber = $PackstationNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostNumber()
    {
        return $this->PostNumber;
    }

    /**
     * @param string $PostNumber
     * @return PackstationType
     */
    public function setPostNumber($PostNumber)
    {
        $this->PostNumber = $PostNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->Zip;
    }

    /**
     * @param string $Zip
     * @return PackstationType
     */
    public function setZip($Zip)
    {
        $this->Zip = $Zip;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->City;
    }

    /**
     * @param string $City
     * @return PackstationType
     */
    public function setCity($City)
    {
        $this->City = $City;
        return $this;
    }

}
