<?php

namespace Mediaopt\DHL\Shipment;

use Mediaopt\DHL\Merchant\Ekp;

/**
 * @author  derksen mediaopt GmbH
 * @package Mediaopt\DHL\Export\Order
 */
class BillingNumber
{
    /**
     * @var Ekp
     */
    protected $ekp;

    /**
     * @var Process
     */
    protected $process;

    /**
     * @var Participation
     */
    protected $participation;

    /**
     * @param Ekp           $ekp
     * @param Process       $process
     * @param Participation $participation
     */
    public function __construct(Ekp $ekp, Process $process, Participation $participation)
    {
        $this->ekp = $ekp;
        $this->process = $process;
        $this->participation = $participation;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getEkp() . $this->getProcess() . $this->getParticipation();
    }

    /**
     * @return Ekp
     */
    public function getEkp()
    {
        return $this->ekp;
    }

    /**
     * @return Process
     */
    public function getProcess()
    {
        return $this->process;
    }

    /**
     * @return Participation
     */
    public function getParticipation()
    {
        return $this->participation;
    }
}
