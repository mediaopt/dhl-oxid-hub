<?php


namespace Mediaopt\DHL\Api\ProdWS;

class Region
{

    /**
     * @var mixed $type
     */
    protected $type = null;

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @param mixed $type
     * @param string $name
     */
    public function __construct($type, $name)
    {
      $this->type = $type;
      $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
      return $this->type;
    }

    /**
     * @param mixed $type
     * @return Region
     */
    public function setType($type)
    {
      $this->type = $type;
      return $this;
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
     * @return Region
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

}
