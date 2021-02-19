<?php


namespace Mediaopt\DHL\Api\ProdWS;

class CategoryList
{

    /**
     * @var GroupedPropertyType $category
     */
    protected $category = null;

    /**
     * @param GroupedPropertyType $category
     */
    public function __construct($category)
    {
      $this->category = $category;
    }

    /**
     * @return GroupedPropertyType
     */
    public function getCategory()
    {
      return $this->category;
    }

    /**
     * @param GroupedPropertyType $category
     * @return CategoryList
     */
    public function setCategory($category)
    {
      $this->category = $category;
      return $this;
    }

}
