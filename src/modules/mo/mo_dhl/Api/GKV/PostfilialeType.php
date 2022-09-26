<?php

namespace Mediaopt\DHL\Api\GKV;

class PostfilialeType
{

    use AssignTrait;

    /**
     * @var string $PostfilialNumber
     */
    protected $PostfilialNumber = null;

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
     * @param string $PostfilialNumber
     * @param string $PostNumber
     * @param string $Zip
     * @param string $City
     */
    public function __construct($PostfilialNumber, $PostNumber, $Zip, $City)
    {
        $this->PostfilialNumber = $PostfilialNumber;
        $this->PostNumber = $PostNumber;
        $this->Zip = $Zip;
        $this->City = $City;
    }

    /**
     * @return string
     */
    public function getPostfilialNumber()
    {
        return $this->PostfilialNumber;
    }

    /**
     * @param string $PostfilialNumber
     * @return PostfilialeType
     */
    public function setPostfilialNumber($PostfilialNumber)
    {
        $this->PostfilialNumber = $PostfilialNumber;
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
     * @return PostfilialeType
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
     * @return PostfilialeType
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
     * @return PostfilialeType
     */
    public function setCity($City)
    {
        $this->City = $City;
        return $this;
    }

}
