<?php

namespace Mediaopt\DHL\Api\ParcelShipping\Model;

class ValidationMessageItem extends \ArrayObject
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
     * The property that is affected by the validation message.
     *
     * @var string
     */
    protected $property;
    /**
     * The validation message describing the error.
     *
     * @var string
     */
    protected $validationMessage;
    /**
     * The validation state resulting from the error.
     *
     * @var string
     */
    protected $validationState;
    /**
     * The property that is affected by the validation message.
     *
     * @return string
     */
    public function getProperty() : string
    {
        return $this->property;
    }
    /**
     * The property that is affected by the validation message.
     *
     * @param string $property
     *
     * @return self
     */
    public function setProperty(string $property) : self
    {
        $this->initialized['property'] = true;
        $this->property = $property;
        return $this;
    }
    /**
     * The validation message describing the error.
     *
     * @return string
     */
    public function getValidationMessage() : string
    {
        return $this->validationMessage;
    }
    /**
     * The validation message describing the error.
     *
     * @param string $validationMessage
     *
     * @return self
     */
    public function setValidationMessage(string $validationMessage) : self
    {
        $this->initialized['validationMessage'] = true;
        $this->validationMessage = $validationMessage;
        return $this;
    }
    /**
     * The validation state resulting from the error.
     *
     * @return string
     */
    public function getValidationState() : string
    {
        return $this->validationState;
    }
    /**
     * The validation state resulting from the error.
     *
     * @param string $validationState
     *
     * @return self
     */
    public function setValidationState(string $validationState) : self
    {
        $this->initialized['validationState'] = true;
        $this->validationState = $validationState;
        return $this;
    }
}