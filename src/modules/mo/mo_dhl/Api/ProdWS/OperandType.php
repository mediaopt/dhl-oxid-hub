<?php


namespace Mediaopt\DHL\Api\ProdWS;

class OperandType
{

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var int $quantity
     */
    protected $quantity = null;

    /**
     * @var WeightType $weight
     */
    protected $weight = null;

    /**
     * @var PriceOperandType $price
     */
    protected $price = null;

    /**
     * @var string $description
     */
    protected $description = null;

    /**
     * @param string           $name
     * @param int              $quantity
     * @param WeightType       $weight
     * @param PriceOperandType $price
     */
    public function __construct($name, $quantity, $weight, $price)
    {
      $this->name = $name;
      $this->quantity = $quantity;
      $this->weight = $weight;
      $this->price = $price;
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
     * @return OperandType
     */
    public function setName($name)
    {
      $this->name = $name;
      return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
      return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return OperandType
     */
    public function setQuantity($quantity)
    {
      $this->quantity = $quantity;
      return $this;
    }

    /**
     * @return WeightType
     */
    public function getWeight()
    {
      return $this->weight;
    }

    /**
     * @param WeightType $weight
     * @return OperandType
     */
    public function setWeight($weight)
    {
      $this->weight = $weight;
      return $this;
    }

    /**
     * @return PriceOperandType
     */
    public function getPrice()
    {
      return $this->price;
    }

    /**
     * @param PriceOperandType $price
     * @return OperandType
     */
    public function setPrice($price)
    {
      $this->price = $price;
      return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
      return $this->description;
    }

    /**
     * @param string $description
     * @return OperandType
     */
    public function setDescription($description)
    {
      $this->description = $description;
      return $this;
    }

}
