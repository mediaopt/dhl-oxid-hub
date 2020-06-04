<?php

namespace Mediaopt\DHL\ServiceProvider;


/**
 * This class represents a list of service providers that are sorted by their distance to a zip/city combination.
 * It also provides functionality to filter service providers based on their type and merge with another
 * service provider list.
 *
 * @package Mediaopt\DHL\ServiceProvider
 */
class ServiceProviderList
{
    /**
     * @var BasicServiceProvider[]
     */
    protected $serviceProviders;

    /**
     * @param BasicServiceProvider[] $serviceProviders
     */
    public function __construct($serviceProviders)
    {
        $this->serviceProviders = $this->sortByDistance($serviceProviders);
    }

    /**
     * @param BasicServiceProvider[] $serviceProviders
     * @return BasicServiceProvider[]
     */
    protected function sortByDistance(array $serviceProviders)
    {
        $sortByDistance = function (BasicServiceProvider $serviceProvider1, BasicServiceProvider $serviceProvider2) {
            if ($serviceProvider1->getLocation()->getDistance() !== $serviceProvider2->getLocation()->getDistance()) {
                return $serviceProvider1->getLocation()->getDistance() - $serviceProvider2->getLocation()->getDistance();
            }
            return $serviceProvider1->getNumber() - $serviceProvider2->getNumber();
        };
        usort($serviceProviders, $sortByDistance);
        return $serviceProviders;
    }

    /**
     * Retains only the objects that are derived from the Packstation class.
     *
     * @return ServiceProviderList
     */
    public function filterPackstation()
    {
        return $this->filter(true, false, false);
    }

    /**
     * Retains only the objects that are derived from the Paketbox class.
     *
     * @return ServiceProviderList
     */
    public function filterPaketshop()
    {
        return $this->filter(false, false, true);
    }

    /**
     * Retains only the objects that are derived from the Filiale class.
     *
     * @return ServiceProviderList
     */
    public function filterFiliale()
    {
        return $this->filter(false, true, false);
    }

    /**
     * @param bool $packstation
     * @param bool $filiale
     * @param bool $paketshop
     * @return ServiceProviderList
     */
    public function filter($packstation, $filiale, $paketshop)
    {
        $classes = [];
        if ($packstation) {
            $classes[] = '\Mediaopt\DHL\ServiceProvider\Packstation';
        }
        if ($filiale) {
            $classes[] = '\Mediaopt\DHL\ServiceProvider\Filiale';
        }
        if ($paketshop) {
            $classes[] = '\Mediaopt\DHL\ServiceProvider\Paketshop';
        }
        $filteredServiceProviders = [];
        foreach ($this->serviceProviders as $serviceProvider) {
            foreach ($classes as $class) {
                if ($serviceProvider instanceof $class) {
                    $filteredServiceProviders[] = $serviceProvider;
                    continue 2;
                }
            }
        }
        $this->serviceProviders = $filteredServiceProviders;
        return $this;
    }

    /**
     * @param ServiceProviderList $anotherServiceProviderList
     * @return ServiceProviderList
     */
    public function merge(ServiceProviderList $anotherServiceProviderList)
    {
        foreach ($anotherServiceProviderList->toArray() as $serviceProvider) {
            $this->serviceProviders[] = clone $serviceProvider;
        }
        $this->serviceProviders = $this->sortByDistance($this->serviceProviders);
        return $this;
    }

    /**
     * Returns the service providers contained in this list.
     *
     * @return BasicServiceProvider[]
     */
    public function toArray()
    {
        return $this->serviceProviders;
    }

}
