<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2017 derksen mediaopt GmbH
 */

namespace Mediaopt\DHL\ServiceProvider;

use Mediaopt\DHL\Address\Address;

class Paketshop extends BasicServiceProvider
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @param string             $id
     * @param int                $number
     * @param string             $name
     * @param Address            $address
     * @param Location           $location
     * @param ServiceInformation $information
     */
    public function __construct(
        $id,
        $number,
        $name,
        Address $address,
        Location $location,
        ServiceInformation $information
    ) {
        parent::__construct($id, $number, $address, $location, $information);
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @see BasicServiceProvider::toArray()
     * @return array
     */
    public function toArray()
    {
        return array_merge(['type' => 'Paketshop', 'name' => $this->getName()], parent::toArray());
    }

}
