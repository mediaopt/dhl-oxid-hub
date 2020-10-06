<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class AddressBinding
{

    /**
     * @var NamedAddress $sender
     */
    protected $sender = null;

    /**
     * @var NamedAddress $receiver
     */
    protected $receiver = null;

    /**
     * @param NamedAddress $sender
     * @param NamedAddress $receiver
     */
    public function __construct($sender, $receiver)
    {
      $this->sender = $sender;
      $this->receiver = $receiver;
    }

    /**
     * @return NamedAddress
     */
    public function getSender()
    {
      return $this->sender;
    }

    /**
     * @param NamedAddress $sender
     * @return AddressBinding
     */
    public function setSender($sender)
    {
      $this->sender = $sender;
      return $this;
    }

    /**
     * @return NamedAddress
     */
    public function getReceiver()
    {
      return $this->receiver;
    }

    /**
     * @param NamedAddress $receiver
     * @return AddressBinding
     */
    public function setReceiver($receiver)
    {
      $this->receiver = $receiver;
      return $this;
    }

}
