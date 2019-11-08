<?php
/**
 * For the full copyright and license information, refer to the accompanying LICENSE file.
 *
 * @copyright 2016 Mediaopt GmbH
 */

namespace Mediaopt\DHL\Shipment;

use Mediaopt\DHL\Address\Addressable;
use Mediaopt\DHL\Address\Receiver;
use Mediaopt\DHL\Address\Sender;
use Mediaopt\DHL\Merchant\Ekp;

/**
 * This class represents an order that can be exported.
 *
 * @author Mediaopt GmbH
 */
class Shipment
{
    /**
     * @var string
     */
    protected $reference;

    /**
     * @var Receiver
     */
    protected $receiver;

    /**
     * @var Sender
     */
    protected $sender;

    /**
     * @var float
     */
    protected $weight;

    /**
     * @var string
     */
    protected $dateOfShipping;

    /**
     * @var Participation|null
     */
    protected $participation;

    /**
     * @var Ekp|null
     */
    protected $ekp;

    /**
     * @var Process|null
     */
    protected $process;

    /**
     * @param string      $reference
     * @param Receiver    $receiver
     * @param Addressable $sender
     * @param float       $weight
     * @param string      $dateOfShipping
     */
    public function __construct(
        $reference,
        Receiver $receiver,
        Addressable $sender,
        $weight,
        $dateOfShipping
    ) {
        $this->reference = $reference;
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->weight = $weight;
        $this->dateOfShipping = $dateOfShipping;
    }

    /**
     * @return Receiver
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @return Addressable
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getDateOfShipping()
    {
        return $this->dateOfShipping;
    }

    /**
     * @return Participation|null
     */
    public function getParticipation()
    {
        return $this->participation;
    }

    /**
     * @return Ekp|null
     */
    public function getEkp()
    {
        return $this->ekp;
    }

    /**
     * @return Process|null
     */
    public function getProcess()
    {
        return $this->process;
    }

    /**
     * @param Process $process
     * @return $this
     */
    public function setProcess(Process $process)
    {
        $this->process = $process;
        return $this;
    }

    /**
     * @param Ekp $ekp
     * @return $this
     */
    public function setEkp(Ekp $ekp)
    {
        $this->ekp = $ekp;
        return $this;
    }

    /**
     * @param Participation $participation
     * @return $this
     */
    public function setParticipation(Participation $participation)
    {
        $this->participation = $participation;
        return $this;
    }

    /**
     * @param BillingNumber $billingNumber
     * @return $this
     */
    public function setBillingNumber(BillingNumber $billingNumber)
    {
        $this->setEkp($billingNumber->getEkp());
        $this->setProcess($billingNumber->getProcess());
        $this->setParticipation($billingNumber->getParticipation());
        return $this;
    }

    /**
     * @return BillingNumber|null
     */
    public function getBillingNumber()
    {
        return $this->getEkp() !== null && $this->getProcess() !== null && $this->getParticipation() !== null
            ? new BillingNumber($this->getEkp(), $this->getProcess(), $this->getParticipation())
            : null;
    }
}
