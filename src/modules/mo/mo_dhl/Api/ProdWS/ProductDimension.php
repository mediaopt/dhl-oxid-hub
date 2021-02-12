<?php


namespace Mediaopt\DHL\Api\ProdWS;

class ProductDimension
{

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var Dimension $dimension
     */
    protected $dimension = null;

    /**
     * @param string    $name
     * @param Dimension $dimension
     */
    public function __construct($name, $dimension)
    {
      $this->name = $name;
      $this->dimension = $dimension;
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
     * @return ProductDimension
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return Dimension
     */
    public function getDimension()
    {
      return $this->dimension;
    }

    /**
     * @param Dimension $dimension
     * @return ProductDimension
     */
    public function setDimension($dimension)
    {
      $this->dimension = $dimension;
      return $this;
    }

}
