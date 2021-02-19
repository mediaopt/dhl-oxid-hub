<?php


namespace Mediaopt\DHL\Api\Internetmarke;

class ImageItem
{

    /**
     * @var ImageID $imageID
     */
    protected $imageID = null;

    /**
     * @var string $imageDescription
     */
    protected $imageDescription = null;

    /**
     * @var string $imageSlogan
     */
    protected $imageSlogan = null;

    /**
     * @var MotiveLink $links
     */
    protected $links = null;

    /**
     * @param ImageID $imageID
     * @param string $imageDescription
     * @param string $imageSlogan
     * @param MotiveLink $links
     */
    public function __construct($imageID, $imageDescription, $imageSlogan, $links)
    {
      $this->imageID = $imageID;
      $this->imageDescription = $imageDescription;
      $this->imageSlogan = $imageSlogan;
      $this->links = $links;
    }

    /**
     * @return ImageID
     */
    public function getImageID()
    {
      return $this->imageID;
    }

    /**
     * @param ImageID $imageID
     * @return ImageItem
     */
    public function setImageID($imageID)
    {
      $this->imageID = $imageID;
      return $this;
    }

    /**
     * @return string
     */
    public function getImageDescription()
    {
      return $this->imageDescription;
    }

    /**
     * @param string $imageDescription
     * @return ImageItem
     */
    public function setImageDescription($imageDescription)
    {
      $this->imageDescription = $imageDescription;
      return $this;
    }

    /**
     * @return string
     */
    public function getImageSlogan()
    {
      return $this->imageSlogan;
    }

    /**
     * @param string $imageSlogan
     * @return ImageItem
     */
    public function setImageSlogan($imageSlogan)
    {
      $this->imageSlogan = $imageSlogan;
      return $this;
    }

    /**
     * @return MotiveLink
     */
    public function getLinks()
    {
      return $this->links;
    }

    /**
     * @param MotiveLink $links
     * @return ImageItem
     */
    public function setLinks($links)
    {
      $this->links = $links;
      return $this;
    }

}
