<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class PageFormat
{

    /**
     * @var PageFormatId $id
     */
    protected $id = null;

    /**
     * @var boolean $isAddressPossible
     */
    protected $isAddressPossible = null;

    /**
     * @var boolean $isImagePossible
     */
    protected $isImagePossible = null;

    /**
     * @var string $name
     */
    protected $name = null;

    /**
     * @var string $description
     */
    protected $description = null;

    /**
     * @var PageType $pageType
     */
    protected $pageType = null;

    /**
     * @var pageLayout $pageLayout
     */
    protected $pageLayout = null;

    /**
     * @param PageFormatId $id
     * @param boolean $isAddressPossible
     * @param boolean $isImagePossible
     * @param string $name
     * @param PageType $pageType
     * @param pageLayout $pageLayout
     */
    public function __construct($id, $isAddressPossible, $isImagePossible, $name, $pageType, $pageLayout)
    {
      $this->id = $id;
      $this->isAddressPossible = $isAddressPossible;
      $this->isImagePossible = $isImagePossible;
      $this->name = $name;
      $this->pageType = $pageType;
      $this->pageLayout = $pageLayout;
    }

    /**
     * @return PageFormatId
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param PageFormatId $id
     * @return PageFormat
     */
    public function setId($id)
    {
      $this->id = $id;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getIsAddressPossible()
    {
      return $this->isAddressPossible;
    }

    /**
     * @param boolean $isAddressPossible
     * @return PageFormat
     */
    public function setIsAddressPossible($isAddressPossible)
    {
      $this->isAddressPossible = $isAddressPossible;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getIsImagePossible()
    {
      return $this->isImagePossible;
    }

    /**
     * @param boolean $isImagePossible
     * @return PageFormat
     */
    public function setIsImagePossible($isImagePossible)
    {
      $this->isImagePossible = $isImagePossible;
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
     * @return PageFormat
     */
    public function setName($name)
    {
      $this->name = $name;
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
     * @return PageFormat
     */
    public function setDescription($description)
    {
      $this->description = $description;
      return $this;
    }

    /**
     * @return PageType
     */
    public function getPageType()
    {
      return $this->pageType;
    }

    /**
     * @param PageType $pageType
     * @return PageFormat
     */
    public function setPageType($pageType)
    {
      $this->pageType = $pageType;
      return $this;
    }

    /**
     * @return pageLayout
     */
    public function getPageLayout()
    {
      return $this->pageLayout;
    }

    /**
     * @param pageLayout $pageLayout
     * @return PageFormat
     */
    public function setPageLayout($pageLayout)
    {
      $this->pageLayout = $pageLayout;
      return $this;
    }

}
