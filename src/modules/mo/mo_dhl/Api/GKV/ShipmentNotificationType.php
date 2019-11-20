<?php

namespace Mediaopt\DHL\Api\GKV;

class ShipmentNotificationType
{

    /**
     * @var string $recipientEmailAddress
     */
    protected $recipientEmailAddress = null;

    /**
     * @param string $recipientEmailAddress
     */
    public function __construct($recipientEmailAddress)
    {
        $this->recipientEmailAddress = $recipientEmailAddress;
    }

    /**
     * @return string
     */
    public function getRecipientEmailAddress()
    {
        return $this->recipientEmailAddress;
    }

    /**
     * @param string $recipientEmailAddress
     * @return ShipmentNotificationType
     */
    public function setRecipientEmailAddress($recipientEmailAddress)
    {
        $this->recipientEmailAddress = $recipientEmailAddress;
        return $this;
    }

}
