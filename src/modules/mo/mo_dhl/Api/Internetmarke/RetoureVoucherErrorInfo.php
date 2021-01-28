<?php

namespace Mediaopt\DHL\Api\Internetmarke;

class RetoureVoucherErrorInfo
{

    /**
     * @var RetoureVoucherErrorCodes $id
     */
    protected $id = null;

    /**
     * @var string $message
     */
    protected $message = null;

    /**
     * @param RetoureVoucherErrorCodes $id
     * @param string $message
     */
    public function __construct($id, $message)
    {
      $this->id = $id;
      $this->message = $message;
    }

    /**
     * @return RetoureVoucherErrorCodes
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param RetoureVoucherErrorCodes $id
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureVoucherErrorInfo
     */
    public function setId($id)
    {
      $this->id = $id;
      return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
      return $this->message;
    }

    /**
     * @param string $message
     * @return \Mediaopt\DHL\Api\Internetmarke\RetoureVoucherErrorInfo
     */
    public function setMessage($message)
    {
      $this->message = $message;
      return $this;
    }

}
