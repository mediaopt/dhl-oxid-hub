<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 derksen mediaopt GmbH
 */

namespace Mediaopt\DHL\Address;

/**
 * A class representing a sender.
 *
 * @author derksen mediaopt GmbH
 * @version ${VERSION}, ${REVISION}
 * @package Mediaopt\EmpfaengerServices
 */
class Sender implements Addressable
{

    /**
     * @var string
     */
    protected $line1;

    /**
     * @var string
     */
    protected $line2;

    /**
     * @var string
     */
    protected $line3;

    /**
     * @var Address
     */
    protected $address;

    /**
     * @param Address $address
     * @param string $line1
     * @param string $line2
     * @param string $line3
     */
    public function __construct(Address $address, $line1, $line2 = '', $line3 = '')
    {
        $this->line1 = $line1;
        $this->line2 = $line2;
        $this->line3 = $line3;
        $this->address = $address;
    }

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getLine1()
    {
        return $this->line1;
    }

    /**
     * @return string
     */
    public function getLine2()
    {
        return $this->line2;
    }

    /**
     * @return string
     */
    public function getLine3()
    {
        return $this->line3;
    }

}
