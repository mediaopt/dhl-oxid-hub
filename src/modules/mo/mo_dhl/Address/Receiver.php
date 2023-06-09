<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Address;

use Mediaopt\DHL\Shipment\Contact;

/**
 * A class representing a receiver.
 *
 * @author  Mediaopt GmbH
 * @version ${VERSION}, ${REVISION}
 * @package Mediaopt\DHL
 */
class Receiver implements Addressable
{

    /**
     * @var Contact
     */
    protected $receiver;

    /**
     * @var Address
     */
    protected $address;

    /**
     * @var string
     */
    protected $postnummer;

    /**
     * @var string
     */
    protected $desiredLocation;

    /**
     * @var string
     */
    protected $desiredLocationType;

    /**
     * @var string
     */
    protected $wunschtag;

    /**
     * @param Contact $receiver
     * @param string  $postnummer
     * @param Address $address
     * @param string  $desiredLocationType
     * @param string  $desiredLocation
     * @param string  $wunschtag
     */
    public function __construct(Contact $receiver, $postnummer, Address $address, $desiredLocationType, $desiredLocation, $wunschtag)
    {
        $this->receiver = $receiver;
        $this->postnummer = $postnummer;
        $this->address = $address;
        $this->desiredLocation = $desiredLocation;
        $this->desiredLocationType = $desiredLocationType;
        $this->wunschtag = $wunschtag;
    }

    /**
     * @return Contact
     */
    public function getReceiver()
    {
        return $this->receiver;
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
    public function getPostnummer()
    {
        return $this->postnummer;
    }

    /**
     * @return string
     */
    public function getDesiredLocation()
    {
        return $this->desiredLocation;
    }

    /**
     * @return string
     */
    public function getDesiredLocationType()
    {
        return $this->desiredLocationType;
    }


    /**
     * @return string
     */
    public function getWunschtag()
    {
        return $this->wunschtag;
    }

    /**
     * @return string
     */
    public function getLine1()
    {
        return $this->getReceiver()->getCompany() ?: $this->getReceiver()->getName();
    }

    /**
     * @return string
     */
    public function getLine2()
    {
        if ($this->getPostnummer() !== '') {
            return $this->getPostnummer();
        }

        return $this->getReceiver()->getCompany() !== '' ? $this->getReceiver()->getName() : '';
    }

    /**
     * @return string
     */
    public function getLine3()
    {
        return $this->getPostnummer() !== '' && $this->getReceiver()->getCompany() !== ''
            ? $this->getReceiver()->getName()
            : '';
    }
}
