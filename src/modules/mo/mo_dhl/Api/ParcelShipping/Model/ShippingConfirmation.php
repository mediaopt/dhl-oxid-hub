<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class ShippingConfirmation extends \ArrayObject
{
    /**
     * @var array
     */
    protected $initialized = array();
    public function isInitialized($property) : bool
    {
        return array_key_exists($property, $this->initialized);
    }
    /**
     * Email address(es) of the recipient of the confirmation.
     *
     * @var string
     */
    protected $email;
    /**
     * A custom email template, this must be set up first and managed via business customer portal.
     *
     * @var string
     */
    protected $templateRef;
    /**
     * Email address(es) of the recipient of the confirmation.
     *
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }
    /**
     * Email address(es) of the recipient of the confirmation.
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email) : self
    {
        $this->initialized['email'] = true;
        $this->email = $email;
        return $this;
    }
    /**
     * A custom email template, this must be set up first and managed via business customer portal.
     *
     * @return string
     */
    public function getTemplateRef() : string
    {
        return $this->templateRef;
    }
    /**
     * A custom email template, this must be set up first and managed via business customer portal.
     *
     * @param string $templateRef
     *
     * @return self
     */
    public function setTemplateRef(string $templateRef) : self
    {
        $this->initialized['templateRef'] = true;
        $this->templateRef = $templateRef;
        return $this;
    }
}