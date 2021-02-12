<?php


namespace Mediaopt\DHL\Api\ProdWS;

class Property
{

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var PropertyValueType $value
     */
    protected $value = null;

    /**
     * @param string            $name
     * @param PropertyValueType $value
     */
    public function __construct($name, $value)
    {
      $this->name = $name;
      $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
      return $this->name;
    }

    /**
     * @param string $name
     * @return Property
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return PropertyValueType
     */
    public function getValue()
    {
      return $this->value;
    }

    /**
     * @param PropertyValueType $value
     * @return Property
     */
    public function setValue($value)
    {
      $this->value = $value;
      return $this;
    }

}
