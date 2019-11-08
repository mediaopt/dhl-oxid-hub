<?php

namespace Mediaopt\DHL\ServiceProvider;

use Mediaopt\DHL\Address\Address;
use Mediaopt\DHL\ServiceProvider\Timetable\Timetable;


/**
 * Represents the functionality shared by all service providers.
 *
 * @author  Mediaopt GmbH
 * @package Mediaopt\DHL\ServiceProvider
 */
class BasicServiceProvider
{

    /**
     * @var string
     */
    protected $id;

    /**
     * @var int
     */
    protected $number;

    /**
     * @var Address
     */
    protected $address;

    /**
     * @var Location
     */
    protected $location;

    /**
     * @var ServiceInformation
     */
    protected $serviceInformation;

    /**
     * @param string             $id
     * @param int                $number
     * @param Address            $address
     * @param Location           $location
     * @param ServiceInformation $information
     */
    public function __construct($id, $number, Address $address, Location $location, ServiceInformation $information)
    {
        $this->id = (string)$id;
        $this->number = (int)$number;
        $this->address = $address;
        $this->location = $location;
        $this->serviceInformation = $information;
    }

    /**
     * @see $id
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @see $address
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return ServiceInformation
     */
    public function getServiceInformation()
    {
        return $this->serviceInformation;
    }

    /**
     * @return Timetable
     */
    public function getTimetable()
    {
        return $this->getServiceInformation()->getTimetable();
    }

    /**
     * @return ServiceType[]
     */
    public function getServiceTypes()
    {
        return $this->getServiceInformation()->getServiceTypes();
    }

    /**
     * @param int $type
     * @return $this
     */
    public function filterTimetable($type)
    {
        $this->getServiceInformation()->setTimetable($this->getTimetable()->filter($type));
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'        => $this->getId(),
            'number'    => $this->getNumber(),
            'address'   => $this->getAddress()->toArray(),
            'location'  => $this->getLocation()->toArray(),
            'timetable' => $this->getTimetable()->toArray(),
            'remark'    => $this->getServiceInformation()->getRemarkInEachLanguage(),
            'services'  => array_map('strval', $this->getServiceInformation()->getServiceTypes()),
        ];
    }
}
