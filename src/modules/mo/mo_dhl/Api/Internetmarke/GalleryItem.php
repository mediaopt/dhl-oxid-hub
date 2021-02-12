<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class GalleryItem
{

    /**
     * @var string $category
     */
    protected $category = null;

    /**
     * @var string $categoryDescription
     */
    protected $categoryDescription = null;

    /**
     * @var int $categoryId
     */
    protected $categoryId = null;

    /**
     * @var ImageItem[] $images
     */
    protected $images = null;

    /**
     * @param string $category
     * @param string $categoryDescription
     * @param int $categoryId
     * @param ImageItem[] $images
     */
    public function __construct($category, $categoryDescription, $categoryId, array $images)
    {
      $this->category = $category;
      $this->categoryDescription = $categoryDescription;
      $this->categoryId = $categoryId;
      $this->images = $images;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
      return $this->category;
    }

    /**
     * @param string $category
     * @return GalleryItem
     */
    public function setCategory($category)
    {
      $this->category = $category;
      return $this;
    }

    /**
     * @return string
     */
    public function getCategoryDescription()
    {
      return $this->categoryDescription;
    }

    /**
     * @param string $categoryDescription
     * @return GalleryItem
     */
    public function setCategoryDescription($categoryDescription)
    {
      $this->categoryDescription = $categoryDescription;
      return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
      return $this->categoryId;
    }

    /**
     * @param int $categoryId
     * @return GalleryItem
     */
    public function setCategoryId($categoryId)
    {
      $this->categoryId = $categoryId;
      return $this;
    }

    /**
     * @return ImageItem[]
     */
    public function getImages()
    {
      return $this->images;
    }

    /**
     * @param ImageItem[] $images
     * @return GalleryItem
     */
    public function setImages(array $images)
    {
      $this->images = $images;
      return $this;
    }

}
